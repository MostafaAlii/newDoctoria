<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainServicePackage extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function mainService(){
        return $this->belongsTo(MainService::class,'main_service_id');
    }
    public function package(){
        return $this->belongsTo(MainService::class,'main_service_id');
    }
}
