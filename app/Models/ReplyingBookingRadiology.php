<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyingBookingRadiology extends Model
{
    use HasFactory;
    protected $guarded=[];


    public function radiologyCenter(){
        return $this->belongsTo(RadiologyCenter::class,'radiology_center_id');
    }
    public function radiology(){
        return $this->belongsTo(Radiology::class,'radiology_id');
    }





}
