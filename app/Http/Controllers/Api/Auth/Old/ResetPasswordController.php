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
use Carbon\Carbon;
use App\Services\Otp\OtpServiceManager;
use App\Rules\AllowedEmailDomain;
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
            return $this->returnErrorNotFound('Otp not found.');
        if (Carbon::now()->greaterThan($otpCode->expires_at)) {
            $otpCode->update(['status' => 'invalid']);
            return response()->json([
                'status' => 'invalid',
                'message' => 'OTP has expired.',
            ], 400);
        }
        return response()->json([
            'otp' => $otpCode->otp,
            'is_sent' => $otpCode->is_sent ? 'valid' : 'invalid',
            'status' => $otpCode->status,
            'time_remaining' => $otpCode->time_remaining . ' minutes',
        ]);
    }

    public function forgotPassword(ForgotPasswordRequest $request) {
        $broker = $this->getBroker($request->user_type);
        if($request->driver == 'email') {
            $request->validate(['email' => ['required','email',new AllowedEmailDomain(),],]);
            $user = OtpServiceManager::getUserByIdentifier($broker, $request->email);
            if (!$user)
                return $this->returnErrorNotFound('User not found.');
            $otpService = $this->otpServiceManager->getService($request->email);
            $otpService->sendOtp($user, $request->driver);
            return $this->returnSuccessMessage('Reset password link sent to your email with otp.');
        } elseif($request->driver == 'whatsapp') {

        } elseif($request->driver =='sms') {

        } else {
            return $this->returnError('Invalid driver.');
        }
    }

    public function resetPassword(Request $request) {
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);
        $otp = OtpCode::where('otp', $request->otp)->where('status', 'valid')->first();
        if (!$otp || !$otp->isValid())
            return response()->json(['message' => 'Invalid or expired OTP'], 400);
        $user = $otp->otpable;
        $user->password = Hash::make($request->password);
        $user->save();
        $otp->delete();
        return response()->json(['message' => 'Password reset successful']);
    }

}
