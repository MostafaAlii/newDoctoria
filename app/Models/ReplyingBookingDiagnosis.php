<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyingBookingDiagnosis extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function diagnosis(){
        return $this->belongsTo(Diagnosis::class,'diagnosis_id');
    }
}
