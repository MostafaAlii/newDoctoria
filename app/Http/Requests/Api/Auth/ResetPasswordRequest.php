<?php
namespace App\Http\Requests\Api\Auth;
use Illuminate\Foundation\Http\FormRequest;
class ResetPasswordRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'otp' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'user_type' => 'required|string',
            'driver' => 'required|string|in:sms,whatsapp,email',
        ];
    }
}
