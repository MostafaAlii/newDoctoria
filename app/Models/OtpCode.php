<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;
class OtpCode extends Model {
    use HasFactory;
    protected $table = "otp_codes";
    protected $fillable = ['otp', 'is_sent', 'status', 'expires_at', 'type', 'phone_number', 'otpable_type', 'otpable_id'];
    protected $casts = [
        'expires_at' => 'datetime',
        'status' => 'string',
        'type' => 'string',
    ];
    protected $appends = ['time_remaining'];
    
    public function otpable() {
        return $this->morphTo();
    }

    public function getTimeRemainingAttribute() {
        $expiresAt = $this->expires_at;
        if ($expiresAt) {
            $remaining = Carbon::now()->diffInMinutes($expiresAt, false);
            return $remaining > 0 ? $remaining : 0;
        }
        return null;
    }

    public static function generateUniqueOtp() {
        do {
            $otp = Str::random(6);
            $otpExists = self::where('otp', $otp)->exists();
        } while ($otpExists);
        return $otp;
    }

    public function isValid() {
        return $this->status === 'valid' && $this->expires_at && $this->expires_at->isFuture();
    }
}
