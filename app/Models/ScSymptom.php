<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ScSymptom extends Model
{
    use HasFactory;
    use HasFactory,HasTranslations;
    public $translatable = ['name'];
    protected $guarded=[];


}
