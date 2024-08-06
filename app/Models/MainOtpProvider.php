<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class MainOtpProvider extends Model {
    use HasFactory;
    protected $table = 'main_otp_providers';
    protected $fillable = ['name', 'status'];
    protected $casts = [
        'status' => 'boolean',
    ];
    public function getStatusAttribute($value) {
        return $value ? 'Active' : 'Inactive';
    }
}
