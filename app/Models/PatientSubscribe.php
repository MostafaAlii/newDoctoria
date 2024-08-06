<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientSubscribe extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id');
    }
    public function package(){
        return $this->belongsTo(Package::class,'package_id');
    }
}
