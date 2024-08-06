<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Analysis extends Model
{
    use HasFactory,HasTranslations;
    public $translatable = ['name'];

    protected $guarded=[];

    public function laboratory(){
        return $this->belongsTo(Analysis::class,'laboratory_id');
    }

}
