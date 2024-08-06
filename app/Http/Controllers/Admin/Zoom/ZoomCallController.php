<?php

namespace App\Http\Controllers\Admin\Zoom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Booking, Doctor, Patient, ZoomVideoCall};
use App\Models\Triats\ZoomCall;
use Illuminate\Support\Facades\Http;
class ZoomCallController extends Controller {
    use ZoomCall;
    public function index() {
        $data = [];
        $data['bookings'] = Booking::all();
        $data['doctors'] = Doctor::all();
        $data['patients'] = Patient::all();
        return view('Admin.Zoom.index', $data);
    }

    public function store(Request $request) {
        /*$doctor = Doctor::find($request->doctor_id);
        $patient = Patient::find($request->patient_id);
        if (!$doctor || !$patient) 
            return response()->json(['error' => 'Doctor or patient not found'], 404);
        $randomNumber = mt_rand(100000, 999999);
        $topic = "{$doctor->name} & {$patient->name} Meeting #{$randomNumber}";
        $call = $this->createCall($request, $topic);
        ZoomVideoCall::create([
            'doctor_id' => $request->doctor_id,
            'patient_id' => $request->patient_id,
            'call_id' => $call->id,
            'start_url' => $call->start_url,
            'join_url' => $call->join_url,
        ]); */
        return $this->get_oauth_step_1();
    }
}
