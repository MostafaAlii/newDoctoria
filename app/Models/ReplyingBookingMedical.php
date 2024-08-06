<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyingBookingMedical extends Model
{
    use HasFactory;
    protected  $guarded=[];

    public function pharmacy(){
        return $this->belongsTo(Pharmacy::class,'pharmacy_id');
    }
    public function medicationUnit(){
        return $this->belongsTo(MedicationUnit::class,'medication_unit_id');
    }

    public function medicationWay(){
        return $this->belongsTo(MedicationWay::class,'medication_way_id');
    }
}
