<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Provider extends Model
{
    use HasFactory,HasTranslations;

    public $translatable = ['name','desc','about_us'];

    protected $guarded=[];



    public function provider_types(){
        return $this->belongsTo(ProviderType::class,'provider_type_id');
    }
    

}
