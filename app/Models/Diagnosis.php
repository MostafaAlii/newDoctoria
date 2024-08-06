<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Diagnosis extends Model
{
    use HasFactory,HasTranslations;
    public $translatable = ['diagnosis'];
    protected $guarded=[];


}
