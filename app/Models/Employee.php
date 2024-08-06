<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function type(){
        return $this->belongsTo(Type::class,'type_id');
    }

    public function city(){
        return $this->belongsTo(City::class,'city_id');
    }
    public function experience(){
        return $this->belongsTo(Experience::class,'experience_id');
    }
}
