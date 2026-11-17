<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user, public string $code)
    {
    }

    public function build()
    {
        return $this->subject('DoctorsInn — Password Reset Code')
            ->view('emails.password-reset-code')
            ->text('emails.password-reset-code-text');
    }
}
