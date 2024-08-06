<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderSpecializationBooking extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function docs(){
        return $this->hasMany(ProviderSpecializationBookingDocs::class,'booking_id');
    }
}
