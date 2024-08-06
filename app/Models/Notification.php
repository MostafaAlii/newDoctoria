<?php

namespace App\Models;

use App\Http\Resources\DoctorResource;
use App\Http\Traits\Api_Trait;
use App\Http\Traits\NotificationFirebaseTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory,NotificationFirebaseTrait;
    protected $guarded=[];

    public function mainService(){
        return $this->belongsTo(MainService::class,'main_service_id');
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class,'user_id');
    }

    public function patient(){
        return $this->belongsTo(Patient::class,'user_id');
    }


    protected static function booted()
    {
        parent::booted();

        static::created(function ($model) {


            $doctor=Doctor::find($model->user_id);
            $doctor_resource=DoctorResource::make($doctor);
            $parent_ides=[$model->user_id];
            $notificationObject = [
                'notification' => [
                    'title' => $model->title,
                    'body' => $model->body,
                    'sound'=>'default',
                ],
                'data' => [
                    'title' => $model->title,
                    'body' => $model->body,
                    'type' => $model->type,
                    'user_id'=>$model->user_id,
                    'user_type'=>$model->user_type,
                    'date'=>$model->date,
                    'doctor'=>$doctor_resource,
                    'foreign_id'=>$model->foreign_id,


                ],
            ];
            $model->sendFCMNotification($parent_ides, $model->user_type,$notificationObject);
        });
    }

}
