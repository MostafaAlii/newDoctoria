<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Pharmacy extends Model
{
    use HasFactory;

    use HasFactory,HasTranslations;

    public $translatable = ['name','desc', 'about_us'];

    protected $guarded=[];


    public function categories(){
        return $this->belongsToMany(Category::class,'provider_categories','provider_id','category_id')->where('provider_type','pharmacy');
    }

    public function medicationUnits(){
        return $this->belongsToMany(MedicationUnit::class,'medication_unit_pharmacies','pharmacy_id','medication_unit_id');
    }

}
