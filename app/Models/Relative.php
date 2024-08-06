<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relative extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function nationality(){
        return $this->belongsTo(Nationality::class,'nationality_id');
    }
    public function city(){
        return $this->belongsTo(City::class,'city_id');
    }

    public function country(){
        return $this->belongsTo(Nationality::class,'country_id');
    }
}
