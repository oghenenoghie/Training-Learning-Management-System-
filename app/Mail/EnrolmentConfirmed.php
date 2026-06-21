<?php
namespace App\Mail;

use App\Models\Enrolment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnrolmentConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Enrolment $enrolment)
    {
        $this->enrolment->loadMissing(['user', 'course', 'schedule']);
    }

    public function envelope(): Envelope
    {
        $courseName = $this->enrolment->course->title ?? 'Course';
        return new Envelope(subject: "Enrolment Confirmed – {$courseName}");
    }

    public function content(): Content
    {
        return new Content(view: 'emails.enrolment-confirmed');
    }
}
