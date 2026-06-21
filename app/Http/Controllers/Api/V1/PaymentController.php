<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Enrolment;
use App\Models\Payment;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
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
        return $this->success(new PaymentResource($payment->load(['user','enrolment'])));
    }

    public function initiate(StorePaymentRequest $request)
    {
        $enrolment = Enrolment::with('course')->findOrFail($request->enrolment_id);
        $amount = $enrolment->course->price;
        $vat = $amount * 0.075;
        $reference = 'IFS-' . strtoupper(Str::random(12));
        $payment = Payment::create([
            'user_id' => $request->user()->id,
            'enrolment_id' => $enrolment->id,
            'amount' => $amount,
            'currency' => 'NGN',
            'reference' => $reference,
            'gateway' => $request->gateway,
            'status' => 'pending',
            'vat_amount' => $vat,
            'invoice_number' => 'INV-' . date('Ymd') . '-' . rand(1000, 9999),
        ]);
        // Mock payment URL (replace with actual gateway integration)
        $paymentUrl = $request->gateway === 'paystack'
            ? "https://checkout.paystack.com/{$reference}"
            : "https://checkout.flutterwave.com/v3/hosted/pay/{$reference}";
        return $this->success([
            'payment' => new PaymentResource($payment),
            'payment_url' => $paymentUrl,
            'reference' => $reference,
        ], 'Payment initiated');
    }

    public function verify(Request $request, string $reference)
    {
        $payment = Payment::where('reference', $reference)->firstOrFail();
        // Mock verification - in production integrate with gateway
        $payment->update(['status' => 'paid', 'paid_at' => now()]);
        $payment->enrolment->update(['status' => 'enrolled']);
        return $this->success(new PaymentResource($payment), 'Payment verified');
    }

    public function refund(Payment $payment)
    {
        if ($payment->status !== 'paid') {
            return $this->error('Only paid payments can be refunded', 422);
        }
        $payment->update(['status' => 'refunded']);
        return $this->success(new PaymentResource($payment), 'Payment refunded');
    }
}
