<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalBagPatient extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id');
    }
    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
}
