<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyingBookingAnalysis extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function analysis(){
        return $this->belongsTo(Analysis::class,'analysis_id');
    }

    public function laboratory(){
        return $this->belongsTo(Laboratory::class,'laboratory_id');
    }
}
