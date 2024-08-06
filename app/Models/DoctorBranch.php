<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class DoctorBranch extends Model
{
    use HasFactory,HasTranslations;
    protected $guarded=[];
    public $translatable = ['about'];

    
    public function times(){
        return $this->hasMany(ProviderTime::class,'provider_id')->where('provider_type','doctor_branch');
    }
    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class,'provider_categories','provider_id','category_id')->where('provider_type','doctor_branch');
    }
}
