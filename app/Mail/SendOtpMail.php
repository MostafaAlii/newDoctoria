<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
class SendOtpMail extends Mailable {
    use Queueable, SerializesModels;
    public $otpCode;
    public function __construct($otpCode) {
        $this->otpCode = $otpCode;
    }

    public function build() {
        return $this->view('emails.sendOtp')
                    ->subject('Password Reset OTP')
                    ->with([
                        'otpCode' => $this->otpCode,
                    ]);
    }
}
