<?php
namespace App\Services\Otp;
use Illuminate\Support\Facades\Mail;
use App\Models\OtpCode;
use Carbon\Carbon;
use App\Mail\SendOtpMail;
use App\Services\Interfaces\OtpServiceInterface;
class EmailOtpService implements OtpServiceInterface {
    public function sendOtp($user, $driver): void {
        $otpCode = OtpCode::generateUniqueOtp();
        OtpCode::create([
            'otp' => $otpCode,
            'is_sent' => true,
            'status' => 'valid',
            'type' => $driver,
            'phone_number' => $user->phone_number,
            'otpable_type' => get_class($user),
            'otpable_id' => $user->id,
            'expires_at' => Carbon::now()->addHour(),
        ]);
        Mail::to($user->email)->send(new SendOtpMail($otpCode));
    }
}
