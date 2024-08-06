<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyingBooking extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function doctor(){
        return $this->belongsTo(Doctor::class,'doctor_id');
    }
    public function replyingBookingAnalysis(){
        return $this->hasMany(ReplyingBookingAnalysis::class,'replying_booking_id');
    }

    public function replyingBookingMedicals(){
        return $this->hasMany(ReplyingBookingMedical::class,'replying_booking_id');
    }
    public function replyingBookingRadiology(){
        return $this->hasMany(ReplyingBookingRadiology::class,'replying_booking_id');
    }

    public function replyingBookingDiagnoses(){
        return $this->hasMany(ReplyingBookingDiagnosis::class,'replying_booking_id');
    }


}
