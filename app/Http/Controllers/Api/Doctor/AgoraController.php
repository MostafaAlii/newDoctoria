<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Resources\AgoraRoomResource;
use App\Http\Resources\AgoraTokenResource;
use App\Http\Traits\Api_Trait;
use App\Http\Traits\NotificationFirebaseTrait;
use App\Models\AgoraRoom;
use App\Models\Booking;
use App\RtcTokenBuilder2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use TomatoPHP\LaravelAgora\Services\Agora;

class AgoraController extends Controller {
    use Api_Trait,NotificationFirebaseTrait;
    public function doctor_start_call(Request $request){
        $validator = Validator::make($request->all(),
            [
                'booking_id' => 'required|exists:bookings,id',
                'type'=>'required|in:audio,video',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }
        $doctor = auth('doctor')->user();
        $booking=Booking::where('doctor_id',$doctor->id)->where('status','active')->find($request->booking_id);
        if (!$booking){
            return  $this->returnError([helperTrans('api.Booking not Found')]);
        }
        $room= AgoraRoom::where('doctor_id',$doctor->id)->where('booking_id',$booking->id)->where('patient_id',$booking->patient_id)->where('type',$request->type)->where('name','!=',null)->first();
        if (!$room){
            $name=$doctor->id.$booking->patient_id.strtotime(now());
            $room=AgoraRoom::create([
                'booking_id'=>$booking->id,
                'patient_id'=>$booking->patient_id,
                'doctor_id'=>$doctor->id,
                'name'=>$name,
                'type'=>$request->type,
            ]);
        }
        $appId = env('AGORA_APP_ID');
        // Need to set environment variable AGORA_APP_CERTIFICATE
        $appCertificate = env('AGORA_APP_CERTIFICATE');
        $channelName = $room->name;
        $uid = substr($doctor->phone, 3);
        $tempInt = (int) $uid;
        
        $uidStr = "2882341273";
        $tokenExpirationInSeconds = 3600;
        $privilegeExpirationInSeconds = 3600;
        $joinChannelPrivilegeExpireInSeconds = 3600;
        $pubAudioPrivilegeExpireInSeconds = 3600;
        $pubVideoPrivilegeExpireInSeconds = 3600;
        $pubDataStreamPrivilegeExpireInSeconds = 3600;
        $token = RtcTokenBuilder2::buildTokenWithUid(
            $appId,
            $appCertificate,
            $channelName, 
            $tempInt, 
            RtcTokenBuilder2::ROLE_PUBLISHER,
            $tokenExpirationInSeconds, 
            $privilegeExpirationInSeconds
        );
        $body=helperTrans('api.you receive ').$request->type.'from Doctor';
        $parent_ides=[$booking->patient_id];
        $notificationObject = [
            'notification' => [
                'title' => helperTrans('api.Room Notification'),
                'body' => $body,
                'sound'=>'default',
            ],
            'data' => [
                'title' => helperTrans('api.Room Notification'),
                'body' => $body,
                'type' => $request->type,
                'name'=>$room->name,

            ],
        ];
        $this->sendFCMNotification($parent_ides, 'patient',$notificationObject);
        $data=[];
        $data['token']=$token;
        $data['room_name']=$room->name;
        return $this->returnData(AgoraTokenResource::make($data),[helperTrans('api.Token Data')],200);
    }

    public function patient_join_call(Request $request){
        $validator = Validator::make($request->all(),
            [
                'booking_id' => 'required|exists:bookings,id',
                'type'=>'required|in:audio,video',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }

        $patient = auth('patient')->user();
        $booking=Booking::where('patient_id',$patient->id)->where('status','active')->find($request->booking_id);
        if (!$booking) {
            return  $this->returnError([helperTrans('api.Booking not Found')]);
        }

        $room= AgoraRoom::where('doctor_id',$booking->doctor_id)->where('booking_id',$booking->id)->where('patient_id',$patient->id)->where('type',$request->type)->where('name','!=',null)->first();

        if (!$room){
            return  $this->returnError([helperTrans('api.Room not Found')]);
        }



        $appId = env('AGORA_APP_ID');
        // Need to set environment variable AGORA_APP_CERTIFICATE
        $appCertificate = env('AGORA_APP_CERTIFICATE');;

        $channelName = $room->name;
        //$uid = $patient->phone;
        $uid = substr($patient->phone, 3);
        $tempInt = (int) $uid;
        $uidStr = "2882341273";
        $tokenExpirationInSeconds = 3600;
        $privilegeExpirationInSeconds = 3600;
        $joinChannelPrivilegeExpireInSeconds = 3600;
        $pubAudioPrivilegeExpireInSeconds = 3600;
        $pubVideoPrivilegeExpireInSeconds = 3600;
        $pubDataStreamPrivilegeExpireInSeconds = 3600;

        $token = RtcTokenBuilder2::buildTokenWithUid($appId, $appCertificate, $channelName, $uid, RtcTokenBuilder2::ROLE_SUBSCRIBER, $tokenExpirationInSeconds, $privilegeExpirationInSeconds);


        $data=[];
        $data['token']=$token;
        $data['room_name']=$room->name;

        return $this->returnData(AgoraTokenResource::make($data),[helperTrans('api.Token Data')],200);

    }
}
