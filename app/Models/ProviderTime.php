<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderTime extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function day(){
        return $this->belongsTo(Day::class,'day_id');
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
}
