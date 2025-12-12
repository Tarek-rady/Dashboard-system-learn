<?php

namespace App\Jobs;

use App\Mail\LoginOtpMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendLoginOtpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $email,
        public string $name,
        public string $otp
    ) {}

    public function handle(): void
    {
         Log::info('Sending OTP email', [
            'email' => $this->email,
            'otp'   => $this->otp,
        ]);
        Mail::to($this->email)->send(new LoginOtpMail($this->otp, $this->name));
    }
}
