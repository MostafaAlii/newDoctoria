<?php
namespace App\Http\Controllers\Api\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\Api_Trait;
use App\Models\{Doctor, Patient};
use Illuminate\Support\Str;
use App\Http\Requests\Api\Auth\{ForgotPasswordRequest, ResetPasswordRequest};
use App\Models\OtpCode;
use Illuminate\Support\Facades\{Mail,Hash};
use App\Mail\SendOtpMail;
use Carbon\Carbon;
use App\Services\Otp\OtpServiceManager;
class ResetPasswordController extends Controller {
    use Api_Trait;

    public function __construct(protected OtpServiceManager $otpServiceManager) {
        $this->otpServiceManager = $otpServiceManager;
    }

    protected function getBroker($userType) {
        return $userType === 'patient' ? 'patient' : 'doctor';
    }

    public function checkOtp(Request $request) {
        $request->validate(['otp' => 'required|string',]);
        $otpCode = OtpCode::where('otp', $request->otp)->first();
        if (!$otpCode)
            return $this->returnErrorDataNotFound('Otp not found.');
        if (Carbon::now()->greaterThan($otpCode->expires_at)) {
            $otpCode->update(['status' => 'invalid']);
            return $this->returnInvalidData('OTP has expired');
        }
        return $this->returnData(
            [
                'otp' => $otpCode->otp,
                'is_sent' => $otpCode->is_sent ? 'valid' : 'invalid',
                'otpStatus' => $otpCode->status,
                'time_remaining' => $otpCode->time_remaining . ' minutes',
            ],
            ['Get Otp Successfully']
        );
    }

    /*public function forgotPassword(ForgotPasswordRequest $request) {
        if($request->driver == 'email') {
            $request->validate([
                'data' => [
                    'required',
                    'email',
                    function ($attribute, $value, $fail) {
                        $allowedDomains = ['gmail.com', 'yahoo.com', 'outlook.com'];
                        $emailDomain = substr(strrchr($value, "@"), 1);
                        if (!in_array($emailDomain, $allowedDomains))
                            $fail('Only gmail, yahoo, and outlook accounts are allowed.');
                    },
                ],
            ]);
            $broker = $this->getBroker($request->user_type);
            $user = OtpServiceManager::getUserByIdentifier($broker, $request->email);
            if (!$user)
                return $this->returnErrorDataNotFound('User not found.');
            $otpService = $this->otpServiceManager->getService($request->email);
            $otpService->sendOtp($user, $request->driver);
            return $this->returnSuccessDataMessage('OTP sent to your email.');
        } elseif($request->driver == 'whatsapp') {

        } elseif($request->driver =='sms') {

        } else {
            return $this->returnErrorDataNotFound('Invalid driver.');
        }
    }*/
    public function forgotPassword(ForgotPasswordRequest $request) {
        if ($request->driver == 'email') {
            $request->validate([
                'data' => [
                    'required',
                    'email',
                    function ($attribute, $value, $fail) {
                        $allowedDomains = ['gmail.com', 'yahoo.com', 'outlook.com'];
                        $emailDomain = substr(strrchr($value, "@"), 1);
                        if (!in_array($emailDomain, $allowedDomains))
                            $fail('Only gmail, yahoo, and outlook accounts are allowed.');
                    },
                ],
            ]);
            $user = OtpServiceManager::getUserByEmail($request->data);
            if (!$user) 
                return $this->returnErrorDataNotFound('User not found.');
            $otpService = $this->otpServiceManager->getService($request->driver);
            $otpService->sendOtp($user, $request->driver);
            return $this->returnSuccessDataMessage('OTP sent to your email.');
        } elseif ($request->driver == 'whatsapp') {
            // التعامل مع واتساب
        } elseif ($request->driver == 'sms') {
            // التعامل مع SMS
        } else {
            return $this->returnErrorDataNotFound('Invalid driver.');
        }
    }



    public function resetPassword(Request $request) {
        $request->validate([
            'data' => 'required|min:8',
        ]);
        $otp = OtpCode::whereOtp($request->otp)->whereStatus('valid')->first();
        if (!$otp || !$otp->isValid())
            return $this->returnInvalidData('OTP has expired');
        $user = $otp->otpable;
        $user->password = Hash::make($request->password);
        $user->save();
        $otp->delete();
        return $this->returnSuccessDataMessage('Password reset successful.');
    }

}