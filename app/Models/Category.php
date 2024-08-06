<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory,HasTranslations;
    protected $guarded=[];

    public $translatable = ['name'];

    public function mainService(){
        return $this->belongsTo(MainService::class,'main_service_id');
    }


    public function doctors(){
        return $this->belongsToMany(Doctor::class,'provider_categories','category_id','provider_id')->where('provider_type','doctor')->where('status',true);
    }


    public function laboratories(){
        return $this->belongsToMany(Laboratory::class,'provider_categories','category_id','provider_id')->where('provider_type','laboratory');
    }


}
