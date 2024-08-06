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

class Patient extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasApiTokens;
    protected $guarded = [];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function nationality()
    {
        return $this->belongsTo(Nationality::class, 'nationality_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'patient_id');
    }
    public function signs()
    {
        return $this->belongsToMany(Sign::class, 'patient_signs', 'patient_id', 'sign_id');
    }

    public function chronicDisease()
    {
        return $this->belongsToMany(ChronicDisease::class, 'patient_chronic_diseases', 'patient_id', 'chronic_disease_id');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
