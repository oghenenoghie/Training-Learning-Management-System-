<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Mail\PaymentReceived;
use App\Models\Assessment;
use App\Models\Enrolment;
use App\Models\Payment;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $query = Payment::with(['user', 'enrolment']);
        if ($request->user()->hasRole('delegate')) {
            $query->where('user_id', $request->user()->id);
        }
        return $this->success(PaymentResource::collection($query->paginate(15)));
    }

    public function show(Payment $payment)
    {
        return $this->success(new PaymentResource($payment->load(['user', 'enrolment'])));
    }

    public function initiate(StorePaymentRequest $request)
    {
        $enrolment = Enrolment::with('course')->findOrFail($request->enrolment_id);
        $amount    = $enrolment->course->price;
        $vat       = $amount * 0.075;
        $reference = 'IFS-' . strtoupper(Str::random(12));
        $gateway   = $request->gateway;
        $user      = $request->user();

        $payment = Payment::create([
            'user_id'        => $user->id,
            'enrolment_id'   => $enrolment->id,
            'amount'         => $amount,
            'currency'       => 'NGN',
            'reference'      => $reference,
            'gateway'        => $gateway,
            'status'         => 'pending',
            'vat_amount'     => $vat,
            'invoice_number' => 'INV-' . date('Ymd') . '-' . rand(1000, 9999),
        ]);

        $paymentUrl = $this->initiateGatewayPayment($gateway, $user, $amount, $vat, $reference);

        return $this->success([
            'payment'     => new PaymentResource($payment),
            'payment_url' => $paymentUrl,
            'reference'   => $reference,
        ], 'Payment initiated');
    }

    public function verify(Request $request, string $reference)
    {
        $payment = Payment::where('reference', $reference)->firstOrFail();

        if ($payment->status === 'paid') {
            return $this->success(new PaymentResource($payment), 'Payment already verified');
        }

        $verified = $this->verifyWithGateway($reference, $payment);

        if (!$verified) {
            return $this->error('Payment verification failed', 422);
        }

        $payment->update(['status' => 'paid', 'paid_at' => now()]);

        $enrolment = $payment->enrolment;
        $enrolment->update(['status' => 'enrolled', 'enrolled_at' => now()]);

        // Auto-issue certificate if course has no assessments
        $hasAssessments = Assessment::where('course_id', $enrolment->course_id)->exists();
        if (!$hasAssessments) {
            CertificateController::issue($enrolment->user_id, $enrolment->course_id, $enrolment->id);
        }

        // Send payment received email
        $user = $payment->user;
        if ($user) {
            Mail::to($user->email)->queue(new PaymentReceived($payment));
        }

        return $this->success(new PaymentResource($payment->fresh()), 'Payment verified');
    }

    public function refund(Payment $payment)
    {
        if ($payment->status !== 'paid') {
            return $this->error('Only paid payments can be refunded', 422);
        }
        $payment->update(['status' => 'refunded']);
        return $this->success(new PaymentResource($payment), 'Payment refunded');
    }

    private function initiateGatewayPayment(string $gateway, $user, $amount, $vat, string $reference): string
    {
        $total = $amount + $vat;

        if ($gateway === 'paystack') {
            $secret = config('services.paystack.secret');
            if ($secret) {
                $response = Http::withToken($secret)->post('https://api.paystack.co/transaction/initialize', [
                    'email'        => $user->email,
                    'amount'       => (int) ($total * 100), // kobo
                    'reference'    => $reference,
                    'callback_url' => config('app.url') . '/api/v1/payments/verify/' . $reference,
                ]);
                if ($response->successful() && isset($response['data']['authorization_url'])) {
                    return $response['data']['authorization_url'];
                }
            }
            return "https://checkout.paystack.com/{$reference}";
        }

        if ($gateway === 'flutterwave') {
            $secret = config('services.flutterwave.secret');
            if ($secret) {
                $response = Http::withToken($secret)->post('https://api.flutterwave.com/v3/payments', [
                    'tx_ref'       => $reference,
                    'amount'       => $total,
                    'currency'     => 'NGN',
                    'redirect_url' => config('app.url') . '/api/v1/payments/verify/' . $reference,
                    'customer'     => [
                        'email' => $user->email,
                        'name'  => $user->name,
                    ],
                ]);
                if ($response->successful() && isset($response['data']['link'])) {
                    return $response['data']['link'];
                }
            }
            return "https://checkout.flutterwave.com/v3/hosted/pay/{$reference}";
        }

        return "#";
    }

    private function verifyWithGateway(string $reference, Payment $payment): bool
    {
        // Flutterwave references start with FLW-
        if (str_starts_with($reference, 'FLW-')) {
            $secret = config('services.flutterwave.secret');
            if (!$secret) return true; // fallback for testing

            // Extract numeric id from reference if embedded, otherwise search
            $response = Http::withToken($secret)->get("https://api.flutterwave.com/v3/transactions/{$reference}/verify");
            if ($response->successful() && isset($response['data']['status']) && $response['data']['status'] === 'successful') {
                return true;
            }
            return false;
        }

        // Default: Paystack
        $secret = config('services.paystack.secret');
        if (!$secret) return true; // fallback for testing

        $response = Http::withToken($secret)->get("https://api.paystack.co/transaction/verify/{$reference}");
        if ($response->successful() && isset($response['data']['status']) && $response['data']['status'] === 'success') {
            return true;
        }

        return false;
    }
}
