<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Package extends Model
{
    use HasFactory,HasTranslations;

    public $translatable = ['name'];

    protected $guarded=[];
    public function mainServicesPackage(){
        return $this->hasMany(MainServicePackage::class,'package_id');
    }

}
