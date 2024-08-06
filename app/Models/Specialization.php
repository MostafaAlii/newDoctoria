<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Specialization extends Model
{
    use HasFactory,HasTranslations;
    protected $guarded=[];

    public $translatable = ['name'];

    public function limitPopularDoctors(){
        return $this->hasMany(Doctor::class,'specialization_id')->limit(6)->where('is_popular',true)->where('status',true);
    }

}
