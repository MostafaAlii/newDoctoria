<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ScType extends Model
{
    use HasFactory;
    use HasFactory,HasTranslations;

    public $translatable = ['name','details'];

    protected $guarded=[];

    public function mainService(){
        return $this->belongsTo(MainService::class,'main_service_id');
    }
    public function scCategory(){
        return $this->belongsTo(ScCategory::class,'sc_category_id');
    }
}
