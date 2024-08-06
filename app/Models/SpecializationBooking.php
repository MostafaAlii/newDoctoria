<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecializationBooking extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id');
    }
    public function docs(){
        return $this->hasMany(SpecializationBookingDocs::class,'booking_id');
    }
    public function doctor(){
        return $this->belongsTo(Doctor::class,'doctor_id');
    }
}
