<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Type extends Model
{
    use HasFactory,HasTranslations;

    protected $guarded=[];

    public $translatable = ['name'];


    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
}
