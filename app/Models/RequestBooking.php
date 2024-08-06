<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestBooking extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function docs(){
        return $this->hasMany(RequestBookingDoc::class,'request_booking_id');
    }

    public function governorate(){
        return $this->belongsTo(Governorate::class,'governorate_id');
    }

    public function city(){
        return $this->belongsTo(City::class,'city_id');
    }
}
