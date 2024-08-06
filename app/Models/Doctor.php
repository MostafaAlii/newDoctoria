<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Translatable\HasTranslations;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Notifications\ResetPasswordNotification;
class Doctor extends Authenticatable implements JWTSubject {
    use HasFactory, Notifiable, HasApiTokens, HasTranslations;
    protected $guarded = [];

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }
    public $translatable = ['about'];


    public function scopeWhenGender($query, $gender) {
        return $query->when($gender,  function ($q) use ($gender) {
            return $q->where('gender', $gender);
        });
    }

    public function scopeWhenSpecialization($query, $specialization) {
        return $query->when($specialization, function ($q) use ($specialization) {
            return $q->whereHas('specialization', function ($qu) use ($specialization) {
                return $qu->whereIn('id', (array)$specialization)->orWhere('name', 'like', '%' . $specialization . '%');
            });
        });
    }

    public function scopeWhenCity($query, $city) {
        return $query->when($city, function ($q) use ($city) {
            return $q->whereHas('city', function ($qu) use ($city) {
                return $qu->whereIn('id', (array)$city)->orWhere('name', 'like', '%' . $city . '%');
            });
        });
    }

    public function scopeWhenGovernorate($query, $governorate) {
        return $query->when($governorate, function ($q) use ($governorate) {
            return $q->whereHas('governorate', function ($qu) use ($governorate) {
                return $qu->whereIn('id', (array)$governorate)->orWhere('name', 'like', '%' . $governorate . '%');
            });
        });
    }

    public function scopeWhenPriceHome($query, $priceFromHome, $priceToHome) {
        return $query->when($priceFromHome && $priceToHome, function ($q) use ($priceFromHome, $priceToHome) {
            return $q->whereBetween('service_price_home', [$priceFromHome, $priceToHome]);
        });
    }

    public function scopeWhenPriceOnline($query, $priceFromOnline, $priceToOnline) {
        return $query->when($priceFromOnline && $priceToOnline, function ($q) use ($priceFromOnline, $priceToOnline) {
            return $q->whereBetween('service_price_online', [$priceFromOnline, $priceToOnline]);
        });
    }

    public function city() {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function governorate() {
        return $this->belongsTo(Governorate::class, 'governorate_id');
    }

    public function specialization() {
        return $this->belongsTo(Specialization::class, 'specialization_id');
    }

    public function times() {
        return $this->hasMany(ProviderTime::class, 'provider_id')->where('provider_type', 'doctor');
    }

    public function categories() {
        return $this->belongsToMany(Category::class, 'provider_categories', 'provider_id', 'category_id')->where('provider_type', 'doctor');
    }

    public function doctor_branch() {
        return $this->hasMany(DoctorBranch::class)->with('times');
    }
}
