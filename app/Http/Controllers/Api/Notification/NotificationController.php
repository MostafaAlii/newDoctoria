<?php

namespace App\Http\Controllers\Api\Notification;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Http\Traits\Api_Trait;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\RtcTokenBuilder2;

class NotificationController extends Controller
{
    use Api_Trait;
    //
    public function index(Request $request){


        $validator = Validator::make($request->all(),
            [
                'user_type' => 'required|in:patient,doctor',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }


        if ($request->user_type == 'doctor') {
            $user = auth('doctor')->user();
        } else {
            $user = auth('patient')->user();
        }
        if (!$user) {
            return $this->returnError([helperTrans('api.Unauthorized')], 401);
        }


        $notifications=Notification::with(['mainService'])->where('user_type',$request->user_type)->where('user_id',$user->id)->get();



        return $this->returnData(NotificationResource::collection($notifications),[helperTrans('api.notifications data')],200);

    }

    public function notification_details(Request $request){
        $validator = Validator::make($request->all(),
            [
                'user_type' => 'required|in:patient,doctor',
                'notification_id'=>'required|exists:notifications,id',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }


        if ($request->user_type == 'doctor') {
            $user = auth('doctor')->user();
        } else {
            $user = auth('patient')->user();
        }
        if (!$user) {
            return $this->returnError([helperTrans('api.Unauthorized')], 401);
        }


        $notification=Notification::with(['mainService'])->where('user_type',$request->user_type)->where('user_id',$user->id)->find($request->notification_id);



        return $this->returnData(NotificationResource::make($notification),[helperTrans('api.notification data')],200);

    }

    public function test_test(Request $request){
        $appId = getenv("AGORA_APP_ID");
// Need to set environment variable AGORA_APP_CERTIFICATE
        $appCertificate = getenv("AGORA_APP_CERTIFICATE");

        $channelName = "7d72365eb983485397e3e3f9d460bdda";
        $uid = 2882341273;
        $uidStr = "2882341273";
        $tokenExpirationInSeconds = 3600;
        $privilegeExpirationInSeconds = 3600;
        $joinChannelPrivilegeExpireInSeconds = 3600;
        $pubAudioPrivilegeExpireInSeconds = 3600;
        $pubVideoPrivilegeExpireInSeconds = 3600;
        $pubDataStreamPrivilegeExpireInSeconds = 3600;

        echo "App Id: " . $appId . PHP_EOL;
        echo "App Certificate: " . $appCertificate . PHP_EOL;
        if ($appId == "" || $appCertificate == "") {
            echo "Need to set environment variable AGORA_APP_ID and AGORA_APP_CERTIFICATE" . PHP_EOL;
            exit;
        }

        $token = RtcTokenBuilder2::buildTokenWithUid($appId, $appCertificate, $channelName, $uid, RtcTokenBuilder2::ROLE_PUBLISHER, $tokenExpirationInSeconds, $privilegeExpirationInSeconds);
        echo 'Token with int uid: ' . $token . PHP_EOL;

//        $token = RtcTokenBuilder2::buildTokenWithUserAccount($appId, $appCertificate, $channelName, $uidStr, RtcTokenBuilder2::ROLE_PUBLISHER, $tokenExpirationInSeconds, $privilegeExpirationInSeconds);
//        echo 'Token with user account: ' . $token . PHP_EOL;
//
//        $token = RtcTokenBuilder2::buildTokenWithUidAndPrivilege($appId, $appCertificate, $channelName, $uid, $tokenExpirationInSeconds, $joinChannelPrivilegeExpireInSeconds, $pubAudioPrivilegeExpireInSeconds, $pubVideoPrivilegeExpireInSeconds, $pubDataStreamPrivilegeExpireInSeconds);
//        echo 'Token with int uid and privilege: ' . $token . PHP_EOL;
//
//        $token = RtcTokenBuilder2::buildTokenWithUserAccountAndPrivilege($appId, $appCertificate, $channelName, $uidStr, $tokenExpirationInSeconds, $joinChannelPrivilegeExpireInSeconds, $pubAudioPrivilegeExpireInSeconds, $pubVideoPrivilegeExpireInSeconds, $pubDataStreamPrivilegeExpireInSeconds);
//        echo 'Token with user account and privilege: ' . $token . PHP_EOL;

    }
}
