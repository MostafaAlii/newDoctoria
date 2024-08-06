<?php

namespace App\Models;

use App\Http\Traits\NotificationFirebaseTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Booking extends Model
{
    use HasFactory,NotificationFirebaseTrait;
    protected $guarded=[];
    protected static function booted()
    {
        parent::booted();

        static::created(function ($model) {
            $mainService=$model->mainService;
            $body = helperTrans('api.Patient Waiting to be accept ').$mainService->name;

            $category_ides=Category::where('main_service_id',$mainService->id)->pluck('id')->toArray();

            $doctor_ides=Doctor::whereHas('categories',function ($query) use ($category_ides){
                $query->whereIn('categories.id',$category_ides);
            })->pluck('id')->toArray();





            $chunkSize = 200;

            // Split the array into chunks
            $chunks = array_chunk($doctor_ides, $chunkSize);

            foreach ($chunks as $chunk) {
                $data = [];
                $now = now(); // Get the current timestamp

                foreach ($chunk as $doctor_id) {
                    $data[] = [
                        'title'=>helperTrans('api.Patient Waiting to be accept') ,
                        'body'=>$body,
                        'user_type'=>'doctor',
                        'user_id'=>$doctor_id,
                        'type'=>'booking',
                        'foreign_id'=>$model->id,
                        'main_service_id'=>$mainService->id,
                        'date'=>date('Y-m-d'),
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                    ];
                }

                Notification::withoutEvents(function () use ($data, $now,$model) {
                    // Use the insert method for bulk insert
                    Notification::insert($data);

                    // Retrieve the inserted notifications
                    $notifications = Notification::whereIn('user_id', array_column($data, 'user_id'))->where('user_type','doctor')->where('created_at',$now)->where('updated_at',$now)->get();

                    // Set foreign_id to be the same as the id
                    foreach ($notifications as $notification) {

                        $parent_ides=[$notification->user_id];
                        $notificationObject = [
                            'notification' => [
                                'title' => $notification->title,
                                'body' => $notification->body,
                                'sound'=>'default',
                            ],
                            'data' => [
                                'title' => $notification->title,
                                'body' => $notification->body,
                                'type' => $notification->type,
                                'user_id'=>$notification->user_id,
                                'user_type'=>$notification->user_type,
                                'date'=>$notification->date,


                            ],
                        ];
                        $model->sendFCMNotification($parent_ides, $notification->user_type,$notificationObject);

                    }
                });
            }














        });
    }


    public function mainService(){
        return $this->belongsTo(MainService::class,'main_service_id');
    }

    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id');
    }
    public function docs(){
        return $this->hasMany(BookingDoc::class,'booking_id');
    }
    public function doctor(){
        return $this->belongsTo(Doctor::class,'doctor_id');
    }
    public function replying(){
        return $this->hasOne(ReplyingBooking::class,'booking_id');
    }
}
