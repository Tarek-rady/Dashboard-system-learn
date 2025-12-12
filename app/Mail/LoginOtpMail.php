<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoginOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $otp,
        public string $name
    ) {}

    public function build()
    {
        return $this->subject('Your Login OTP Code')
            ->view('emails.auth.login-otp');
    }
}
