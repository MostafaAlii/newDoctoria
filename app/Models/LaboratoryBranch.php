<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class LaboratoryBranch extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function  governorate(){
        return $this->belongsTo(Governorate::class,'governorate_id');
    }

    public function  city(){
        return $this->belongsTo(City::class,'city_id');
    }
}
