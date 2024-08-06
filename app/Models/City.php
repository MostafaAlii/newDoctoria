<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class City extends Model
{
    use HasFactory,HasTranslations;
    protected $guarded=[];

    public $translatable = ['name'];


    public function nationality(){
        return $this->belongsTo(Nationality::class,'nationality_id');
    }
    public function governorate(){
        return $this->belongsTo(Governorate::class,'governorate_id');
    }
}
