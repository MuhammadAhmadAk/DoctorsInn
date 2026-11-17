<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactInquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $senderName,
        public string $senderEmail,
        public ?string $senderPhone,
        public ?string $topic,
        public string $inquiry,
    ) {
    }

    public function build()
    {
        return $this->subject('New contact message — ' . $this->senderName)
            ->replyTo($this->senderEmail, $this->senderName)
            ->view('emails.contact-inquiry')
            ->text('emails.contact-inquiry-text');
    }
}
