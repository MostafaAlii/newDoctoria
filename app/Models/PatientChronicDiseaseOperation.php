<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientChronicDiseaseOperation extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function medicalOperation(){
        return $this->belongsTo(MedicalOperation::class,'medical_operation_id');
    }
    public function chronicDisease(){
        return $this->belongsTo(ChronicDisease::class,'chronic_disease_id');
    }
}
