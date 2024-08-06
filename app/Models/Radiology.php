<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Radiology extends Model
{
    use HasFactory,HasTranslations;
    public $translatable = ['name'];

    protected $guarded=[];

    public function radiologyCenter(){
        return $this->belongsTo(RadiologyCenter::class,'radiology_center_id');
    }
}
