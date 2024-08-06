<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Sign extends Model
{
    use HasFactory,HasTranslations;
    protected $guarded=[];

    public $translatable = ['name'];

    protected $appends=['is_checked'];

    public function getIsCheckedAttribute($key)
    {
        if (request()->has('patient_id')){
            $count = PatientSign::where('patient_id',request()->patient_id)->where('sign_id',$this->id)->count();
            return $count?true:false;
        }
        return false;
    }
}
