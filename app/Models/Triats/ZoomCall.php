<?php
namespace App\Models\Triats;
use MacsiDigital\Zoom\Facades\Zoom;
use Carbon\Carbon;
trait ZoomCall {
    public function createCall($request, $topic) {
        $user = Zoom::user()->first();
        $callData = [
            'topic' => $topic,
            'duration' => null,
            'password' => null,
            'start_at' => Carbon::now(),
            'time_zone' => config('zoom.timezone'),
        ];
        $call = Zoom::meeting()->make($callData);
        $call->settings()->make([
            'join_before_host' => true,
            'registration_type' => 2,
            'enforce_login' => false,

            'host_video' => true,
            'participant_video' => true,
            'mute_upon_entry' => true,
            'waiting_room' => true,
            'approval_type' => config('zoom.approval_type'),
            'audio' => config('zoom.audio'),
            'auto_recording' => config('zoom.auto_recording')
        ]);
        return $user->meetings()->save($call);
    }

    public function get_oauth_step_1() {
        //++++++++++++++++++++++++++++++++++++++++++++++++
        //++++++++++++++++++++++++++++++++++++++++++++++++
        $redirectURL  = 'http://127.0.0.1/zoom_video_call/store';
        $authorizeURL = 'https://zoom.us/oauth/authorize';
        //++++++++++++++++++++++++++++++++++++++++++++++++++
        $clientID     = env("ZOOM_CLIENT_ID");
        $clientSecret = env("ZOOM_CLIENT_SECRECT");
        //++++++++++++++++++++++++++++++++++++++++++++++++
        //++++++++++++++++++++++++++++++++++++++++++++++++
        $authURL = $authorizeURL . '?client_id=' . $clientID . '&redirect_uri=' . $redirectURL . '&response_type=code&scope=&state=xyz';
        header('Location: ' . $authURL);
        exit;
    }
}