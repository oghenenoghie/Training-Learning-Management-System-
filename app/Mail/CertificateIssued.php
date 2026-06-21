<?php
namespace App\Mail;

use App\Models\Certificate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CertificateIssued extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Certificate $certificate)
    {
        $this->certificate->loadMissing(['user', 'course']);
    }

    public function envelope(): Envelope
    {
        $courseName = $this->certificate->course->title ?? 'Course';
        return new Envelope(subject: "Your Certificate is Ready – {$courseName}");
    }

    public function content(): Content
    {
        return new Content(view: 'emails.certificate-issued');
    }
}
