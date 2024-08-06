<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Laboratory extends Model
{
    use HasFactory,HasTranslations;

    public $translatable = ['name','desc', 'about_us'];

    protected $guarded=[];

    public function categories(){
        return $this->belongsToMany(Category::class,'provider_categories','provider_id','category_id')->where('provider_type','laboratory');
    }

}
