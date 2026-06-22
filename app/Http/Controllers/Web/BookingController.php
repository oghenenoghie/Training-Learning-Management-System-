<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\BookingConfirmed;
use App\Models\Course;
use App\Models\CourseSchedule;
use App\Models\Enrolment;
use App\Models\Payment;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    // ── Show Checkout Form ────────────────────────────────────────────────────

    public function showCheckout(string $slug, Request $request)
    {
        $course = Course::where('slug', $slug)
            ->where('is_published', true)
            ->with(['category', 'schedules' => function ($q) {
                $q->where('status', 'open')
                  ->where('start_date', '>=', now()->toDateString())
                  ->orderBy('start_date');
            }])
            ->firstOrFail();

        $preselectedSchedule = null;
        if ($request->has('schedule_id')) {
            $preselectedSchedule = $course->schedules->firstWhere('id', $request->schedule_id);
        }

        return view('booking.checkout', compact('course', 'preselectedSchedule'));
    }

    // ── Process Checkout ──────────────────────────────────────────────────────

    public function processCheckout(string $slug, Request $request)
    {
        $course = Course::where('slug', $slug)->where('is_published', true)->firstOrFail();

        $validated = $request->validate([
            'booker_type'              => 'required|in:individual,company',
            'contact_person'           => 'required|string|max:255',
            'contact_email'            => 'required|email',
            'contact_phone'            => 'required|string|max:20',
            'company_name'             => 'required_if:booker_type,company|nullable|string|max:255',
            'company_address'          => 'nullable|string|max:500',
            'po_number'                => 'nullable|string|max:100',
            'schedule_id'              => 'required|exists:course_schedules,id',
            'number_of_delegates'      => 'required|integer|min:1|max:100',
            'delegate_names'           => 'nullable|array',
            'delegate_names.*.name'    => 'nullable|string|max:255',
            'delegate_names.*.email'   => 'nullable|email',
            'payment_method'           => 'required|in:paystack,flutterwave,invoice',
        ]);

        // Verify schedule belongs to this course
        $schedule = CourseSchedule::where('id', $validated['schedule_id'])
            ->where('course_id', $course->id)
            ->firstOrFail();

        // Calculate financials
        $pricePerPerson = (float) $course->price;
        $delegates      = (int) $validated['number_of_delegates'];
        $subtotal       = $pricePerPerson * $delegates;
        $vatAmount      = $subtotal * 0.075;
        $total          = $subtotal + $vatAmount;

        // Generate unique booking reference
        $year      = now()->year;
        $sequence  = str_pad(Enrolment::whereYear('created_at', $year)->count() + 1, 5, '0', STR_PAD_LEFT);
        $reference = "IFS-{$year}-{$sequence}";
        // Ensure uniqueness
        while (Enrolment::where('booking_reference', $reference)->exists()) {
            $sequence  = str_pad((int) $sequence + 1, 5, '0', STR_PAD_LEFT);
            $reference = "IFS-{$year}-{$sequence}";
        }

        // Find or create user based on contact email
        $user = User::firstOrCreate(
            ['email' => $validated['contact_email']],
            [
                'name'         => $validated['contact_person'],
                'phone'        => $validated['contact_phone'],
                'organisation' => $validated['company_name'] ?? null,
                'password'     => Hash::make(Str::random(16)),
                'role'         => 'delegate',
            ]
        );

        // Filter out empty delegate rows
        $delegateNames = collect($validated['delegate_names'] ?? [])
            ->filter(fn ($d) => !empty($d['name']) || !empty($d['email']))
            ->values()
            ->toArray();

        // Create Enrolment
        $enrolment = Enrolment::create([
            'user_id'             => $user->id,
            'course_id'           => $course->id,
            'schedule_id'         => $schedule->id,
            'status'              => 'pending',
            'enrolled_at'         => now(),
            'progress'            => 0,
            'booker_type'         => $validated['booker_type'],
            'company_name'        => $validated['company_name'] ?? null,
            'contact_person'      => $validated['contact_person'],
            'contact_email'       => $validated['contact_email'],
            'contact_phone'       => $validated['contact_phone'],
            'company_address'     => $validated['company_address'] ?? null,
            'po_number'           => $validated['po_number'] ?? null,
            'number_of_delegates' => $delegates,
            'delegate_names'      => $delegateNames ?: null,
            'payment_method'      => $validated['payment_method'],
            'subtotal'            => $subtotal,
            'vat_amount'          => $vatAmount,
            'total_amount'        => $total,
            'booking_reference'   => $reference,
        ]);

        // Generate invoice number
        $invoiceNumber = 'INV-' . str_pad($enrolment->id, 6, '0', STR_PAD_LEFT);

        // Create Payment record
        $payment = Payment::create([
            'user_id'        => $user->id,
            'enrolment_id'   => $enrolment->id,
            'amount'         => $total,
            'currency'       => 'NGN',
            'reference'      => $reference,
            'gateway'        => $validated['payment_method'] === 'invoice' ? 'paystack' : $validated['payment_method'],
            'status'         => $validated['payment_method'] === 'invoice' ? 'pending' : 'pending',
            'vat_amount'     => $vatAmount,
            'invoice_number' => $invoiceNumber,
        ]);

        if ($validated['payment_method'] === 'invoice') {
            // Send confirmation email
            try {
                Mail::to($validated['contact_email'])->send(new BookingConfirmed($enrolment, $payment));
            } catch (\Throwable $e) {
                // Mail failure should not break flow
            }
            return redirect()->route('booking.success', $reference);
        }

        return redirect()->route('booking.pay', $reference);
    }

    // ── Initiate Payment ──────────────────────────────────────────────────────

    public function initiatePayment(string $reference)
    {
        $enrolment = Enrolment::with(['course', 'schedule'])
            ->where('booking_reference', $reference)
            ->firstOrFail();

        $payment = $enrolment->payment;

        if ($payment->status === 'paid') {
            return redirect()->route('booking.success', $reference);
        }

        $amountKobo = (int) round($payment->amount * 100);
        $email      = $enrolment->contact_email;
        $callbackUrl = route('booking.verify', $reference);

        if ($enrolment->payment_method === 'flutterwave') {
            $secretKey = config('services.flutterwave.secret_key');
            if (empty($secretKey)) {
                return redirect()->route('booking.success', $reference)
                    ->with('error', 'Flutterwave is not configured. Please contact support.');
            }
            $response = Http::withToken($secretKey)->post('https://api.flutterwave.com/v3/payments', [
                'tx_ref'       => $reference,
                'amount'       => $payment->amount,
                'currency'     => 'NGN',
                'redirect_url' => $callbackUrl,
                'customer'     => ['email' => $email, 'name' => $enrolment->contact_person],
                'customizations' => ['title' => 'IFS Nigeria — ' . $enrolment->course->title],
            ]);
            if ($response->successful() && isset($response['data']['link'])) {
                return redirect($response['data']['link']);
            }
            return redirect()->route('booking.success', $reference)
                ->with('error', 'Could not initiate Flutterwave payment.');
        }

        // Default: Paystack
        $secretKey = config('services.paystack.secret_key');
        if (empty($secretKey)) {
            return redirect()->route('booking.success', $reference)
                ->with('info', 'Online payment is not configured. Your booking has been received and our team will send an invoice.');
        }
        $response = Http::withToken($secretKey)->post('https://api.paystack.co/transaction/initialize', [
            'email'        => $email,
            'amount'       => $amountKobo,
            'reference'    => $reference,
            'callback_url' => $callbackUrl,
            'metadata'     => ['booking_reference' => $reference, 'course' => $enrolment->course->title],
        ]);
        if ($response->successful() && isset($response['data']['authorization_url'])) {
            return redirect($response['data']['authorization_url']);
        }
        return redirect()->route('booking.success', $reference)
            ->with('error', 'Could not initiate Paystack payment. Please contact support.');
    }

    // ── Verify Payment ────────────────────────────────────────────────────────

    public function verifyPayment(string $reference)
    {
        $enrolment = Enrolment::with(['course', 'payment'])
            ->where('booking_reference', $reference)
            ->firstOrFail();

        $payment = $enrolment->payment;

        if ($payment->status === 'paid') {
            return redirect()->route('booking.success', $reference);
        }

        if ($enrolment->payment_method === 'flutterwave') {
            $txRef     = request('tx_ref', $reference);
            $secretKey = config('services.flutterwave.secret_key');
            $response  = Http::withToken($secretKey)
                ->get("https://api.flutterwave.com/v3/transactions/verify_by_reference?tx_ref={$txRef}");
            if ($response->successful() && ($response['data']['status'] ?? '') === 'successful') {
                $this->markPaid($payment, $enrolment);
            }
        } else {
            $secretKey = config('services.paystack.secret_key');
            $response  = Http::withToken($secretKey)
                ->get("https://api.paystack.co/transaction/verify/{$reference}");
            if ($response->successful() && ($response['data']['status'] ?? '') === 'success') {
                $this->markPaid($payment, $enrolment);
            }
        }

        return redirect()->route('booking.success', $reference);
    }

    private function markPaid(Payment $payment, Enrolment $enrolment): void
    {
        $payment->update(['status' => 'paid', 'paid_at' => now()]);
        $enrolment->update(['status' => 'enrolled']);
        try {
            Mail::to($enrolment->contact_email)->send(new BookingConfirmed($enrolment, $payment));
        } catch (\Throwable $e) {
            // Mail failure should not break flow
        }
    }

    // ── Success Page ──────────────────────────────────────────────────────────

    public function success(string $reference)
    {
        $enrolment = Enrolment::with(['course', 'schedule', 'payment'])
            ->where('booking_reference', $reference)
            ->firstOrFail();

        return view('booking.success', compact('enrolment'));
    }

    // ── Download Invoice ──────────────────────────────────────────────────────

    public function downloadInvoice(string $reference)
    {
        $enrolment = Enrolment::with(['course', 'schedule', 'payment'])
            ->where('booking_reference', $reference)
            ->firstOrFail();

        $pdf = Pdf::loadView('booking.invoice', compact('enrolment'))
            ->setPaper('a4', 'portrait');

        return $pdf->download("Invoice-{$reference}.pdf");
    }
}
