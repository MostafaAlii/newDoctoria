<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ScService extends Model
{
    use HasFactory,HasTranslations;

    public $translatable = ['name','description'];

    protected $guarded=[];


    public function Type(){
        return $this->belongsTo(ScType::class,'sc_type_id');
    }

    public function experience(){
        return $this->belongsTo(Experience::class,'experience_id');
    }
}
