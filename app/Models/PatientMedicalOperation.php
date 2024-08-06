<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientMedicalOperation extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function medicalOperation(){
        return $this->belongsTo(MedicalOperation::class,'medical_operation_id');

    }
}
