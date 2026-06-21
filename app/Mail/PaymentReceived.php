<?php
namespace App\Mail;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Payment $payment)
    {
        $this->payment->loadMissing(['user', 'enrolment.course']);
    }

    public function envelope(): Envelope
    {
        $invoice = $this->payment->invoice_number ?? '';
        return new Envelope(subject: "Payment Confirmed – Invoice {$invoice}");
    }

    public function content(): Content
    {
        return new Content(view: 'emails.payment-received');
    }
}
