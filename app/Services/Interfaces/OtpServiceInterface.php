<?php
namespace App\Services\Interfaces;
interface OtpServiceInterface {
    public function sendOtp($recipient, $otp);
}
