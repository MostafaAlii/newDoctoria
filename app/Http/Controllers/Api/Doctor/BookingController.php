<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Resources\AgoraRoomResource;
use App\Http\Resources\BookingResource;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\ReplayingBookingResource;
use App\Http\Resources\SelectProviderResource;
use App\Http\Traits\Api_Trait;
use App\Http\Traits\NotificationFirebaseTrait;
use App\Models\AgoraRoom;
use App\Models\Booking;
use App\Models\BookingDoc;
use App\Models\Category;
use App\Models\Doctor;
use App\Models\FirebaseToken;
use App\Models\MainService;
use App\Models\Notification;
use App\Models\ProviderCategory;
use App\Models\ReplyingBooking;
use App\Models\ReplyingBookingAnalysis;
use App\Models\ReplyingBookingDiagnosis;
use App\Models\ReplyingBookingMedical;
use App\Models\ReplyingBookingRadiology;
use App\Models\SelectProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Prompts\Table;
use PDF;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    use Api_Trait, NotificationFirebaseTrait;

    //

    public function index(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
                'status' => 'required|in:pending,active,complete',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }

        $doctor = auth('doctor')->user();
        // Fetch category IDs associated with the doctor
        $categoryIds = ProviderCategory::where('provider_type', 'doctor')
            ->where('provider_id', $doctor->id)
            ->pluck('category_id')
            ->toArray();
        // Fetch main service IDs associated with the categories
        $mainServiceIds = MainService::whereHas('categories', function ($query) use ($categoryIds) {
            $query->whereIn('categories.id', $categoryIds);
        })->pluck('id')->toArray();

        // Fetch bookings based on status
        if ($request->status == 'pending') {
            // Pending bookings can be either unassigned or assigned to this doctor
            $bookings = Booking::with('patient')
                ->whereIn('main_service_id', $mainServiceIds)
                ->where('status', $request->status)
                ->where(function ($query) use ($doctor) {
                    $query->whereNull('doctor_id')->orWhere('doctor_id', $doctor->id);
                })->latest()->get();
        } else {
            // Bookings with a Specific status assigned to this doctor
            $bookings = Booking::with('patient')
                ->latest()
                ->where('doctor_id', $doctor->id)
                ->where('status', $request->status)
                ->get();
        }

        return $this->returnData(BookingResource::collection($bookings), [helperTrans('api.Booking Data')], 200);

    }

    public function accept_booking(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
                'booking_id' => 'required|exists:bookings,id',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }

        $doctor = auth('doctor')->user();

        $booking = Booking::where('status', 'pending')->where('doctor_id', null)->find($request->booking_id);

        if (!$booking)
            return $this->returnError([helperTrans('api.the booking accepted before')]);


        $booking->doctor_id = $doctor->id;
        $booking->status = 'active';
        $booking->save();


        $body = helperTrans('api.It was asked by the doctor and will be answered now');

        Notification::create([
            'title' => helperTrans('api.Accept Booking'),
            'body' => $body,
            'user_type' => 'patient',
            'user_id' => $booking->patient_id,
            'type' => 'accept',
            'foreign_id' => $booking->id,
            'main_service_id' => $booking->main_service_id,
            'date' => date('Y-m-d'),
        ]);

        return $this->returnSuccessMessage(['api.accepted successfully']);
    }


    public function booking_details(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
                'booking_id' => 'required|exists:bookings,id',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }

        $booking = Booking::with(['docs', 'patient', 'mainService','replying.replyingBookingDiagnoses'])->find($request->booking_id);


        return $this->returnData(BookingResource::make($booking), [helperTrans('api.Booking Data')], 200);

    }

    public function make_replying(Request $request){

        $validator = Validator::make($request->all(),
            [
                'booking_id' => 'required|exists:bookings,id',
                'desc'=>'nullable',
                'pharmacy' => 'nullable|array',
                'pharmacy.*.pharmacy_id' => 'required_with:pharmacy|nullable|exists:pharmacies,id',
                'pharmacy.*.medication_unit_id' => 'required_with:pharmacy|nullable|exists:medication_units,id',
                'pharmacy.*.medication_way_id' => 'required_with:pharmacy|nullable|exists:medication_ways,id',
                'pharmacy.*.note' => 'required_with:pharmacy|nullable|string',

                'laboratory' => 'nullable|array',
                'laboratory.*.laboratory_id' => 'required_with:laboratory|nullable|exists:laboratories,id',
                'laboratory.*.analysis_id' => 'required_with:laboratory|nullable|exists:analyses,id',
                'laboratory.*.note' => 'required_with:laboratory|nullable|string',

                'radiology_center' => 'nullable|array',
                'radiology_center.*.radiology_center_id' => 'required_with:radiology_center|nullable|exists:radiology_centers,id',
                'radiology_center.*.radiology_id' => 'required_with:radiology_center|nullable|exists:radiologies,id',
                'radiology_center.*.note' => 'required_with:radiology_center|nullable|string',



                'diagnoses' => 'required|array',
                'diagnoses.*.diagnosis_id' => 'required|exists:diagnoses,id',

            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }

        $doctor = auth('doctor')->user();

        $booking=Booking::where('status','active')->where('doctor_id',$doctor->id)->find($request->booking_id);

        if (!$booking){
            return $this->returnError([helperTrans('api.booking not found')]);
        }

        $replaying=ReplyingBooking::where('booking_id',$request->booking_id)->where('patient_id',$booking->patient_id)->where('doctor_id',$doctor->id)->first();

        if ($replaying){
            return $this->returnError([helperTrans('api.You are Replaying Before')]);
        }

        $replaying=ReplyingBooking::create([
            'booking_id'=>$booking->id,
            'patient_id'=>$booking->patient_id,
            'doctor_id'=>$doctor->id,
            'desc'=>$request->desc,
        ]);

        if ($request->pharmacy) {
            $medicalsData = $request->input('pharmacy');
            foreach ($medicalsData as $medicalData) {
                $data=[];

                $data['booking_id'] = $booking->id;
                $data['patient_id'] = $booking->patient_id;
                $data['doctor_id'] = $booking->doctor_id;
                $data['replying_booking_id'] = $replaying->id;
                $data['pharmacy_id']=$medicalData['pharmacy_id'];
                $data['medication_unit_id']=$medicalData['medication_unit_id'];
                $data['medication_way_id']=$medicalData['medication_way_id'];
                $data['note']=$medicalData['note'];

                ReplyingBookingMedical::create($data);
            }
        }


        if ($request->laboratory) {
            $analysisData = $request->input('laboratory');
            foreach ($analysisData as $analysData) {
                $data=[];

                $data['booking_id'] = $booking->id;
                $data['patient_id'] = $booking->patient_id;
                $data['doctor_id'] = $booking->doctor_id;
                $data['replying_booking_id'] = $replaying->id;
                $data['laboratory_id']=$analysData['laboratory_id'];
                $data['analysis_id']=$analysData['analysis_id'];
                $data['note']=$analysData['note'];

                ReplyingBookingAnalysis::create($data);
            }
        }

        if ($request->radiology_center) {
            $radiologyData = $request->input('radiology_center');
            foreach ($radiologyData as $radiologData) {
                $data=[];
                $data['booking_id'] = $booking->id;
                $data['patient_id'] = $booking->patient_id;
                $data['doctor_id'] = $booking->doctor_id;
                $data['replying_booking_id'] = $replaying->id;
                $data['radiology_center_id']=$radiologData['radiology_center_id'];
                $data['radiology_id']=$radiologData['radiology_id'];
                $data['note']=$radiologData['note'];

                ReplyingBookingRadiology::create($data);
            }

        }

// Insert data for "diagnoses"

        if ($request->diagnoses) {

            $diagnosesData = $request->input('diagnoses');
            foreach ($diagnosesData as $diagnosisData) {
                $data=[];
                $data['booking_id'] = $booking->id;
                $data['patient_id'] = $booking->patient_id;
                $data['doctor_id'] = $booking->doctor_id;
                $data['replying_booking_id'] = $replaying->id;
                $data['diagnosis_id']=$diagnosisData['diagnosis_id'];
                ReplyingBookingDiagnosis::create($data);
            }

        }

        Notification::create([
            'title'=>helperTrans('api.Doctor Replying For Your Booking'),
            'body'=>helperTrans('api.Doctor Replying For Your Booking'),
            'user_type'=>'patient',
            'user_id'=>$booking->patient_id,
            'type'=>'accept',
            'date'=>date('Y-m-d'),
            'foreign_id'=>$booking->id,
            'main_service_id'=>$booking->main_service_id,

        ]);


        $booking->update([
            'status'=>'complete',
        ]);

        return  $this->returnSuccessMessage([helperTrans('api.replaying added successfully')]);

    }

    public function make_new_replying(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
                'booking_id' => 'required|exists:bookings,id',
                'desc' => 'nullable',

            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }

        $doctor = auth('doctor')->user();

        $booking = Booking::where('status', 'active')->where('doctor_id', $doctor->id)->find($request->booking_id);

        if (!$booking) {
            return $this->returnError([helperTrans('api.booking not found')]);
        }

        $replaying = ReplyingBooking::where('booking_id', $request->booking_id)->where('patient_id', $booking->patient_id)->where('doctor_id', $doctor->id)->first();

        if (!$replaying) {
            $replaying = ReplyingBooking::create([
                'booking_id' => $booking->id,
                'patient_id' => $booking->patient_id,
                'doctor_id' => $doctor->id,
                'desc' => $request->desc,
            ]);

        } else {
            $replaying->update([
                'desc' => $request->desc,
            ]);
        }

         Notification::create([
             'title'=>helperTrans('api.Doctor Report'),
             'body'=>$ $request->desc ?? helperTrans('api.Doctor Report'),
             'user_type'=>'patient',
             'user_id'=>$booking->patient_id,
             'type'=>'accept',
             'date'=>date('Y-m-d'),
             'foreign_id'=>$booking->id,
             'main_service_id'=>$booking->main_service_id,

         ]);


        return $this->returnSuccessMessage([helperTrans('api.replaying added successfully')]);

    }

    public function make_replying_laboratory(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
                'booking_id' => 'required|exists:bookings,id',
                'laboratory' => 'nullable|array',
                'laboratory.*.laboratory_id' => 'required_with:laboratory|nullable|exists:laboratories,id',
                'laboratory.*.analysis_id' => 'required_with:laboratory|nullable|exists:analyses,id',
                'laboratory.*.note' => 'required_with:laboratory|nullable|string',


            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }

        $doctor = auth('doctor')->user();

        $booking = Booking::where('status', 'active')->where('doctor_id', $doctor->id)->find($request->booking_id);

        if (!$booking) {
            return $this->returnError([helperTrans('api.booking not found')]);
        }

        $replaying = ReplyingBooking::where('booking_id', $request->booking_id)->where('patient_id', $booking->patient_id)->where('doctor_id', $doctor->id)->first();

        if (!$replaying) {

            $replaying = ReplyingBooking::create([
                'booking_id' => $booking->id,
                'patient_id' => $booking->patient_id,
                'doctor_id' => $doctor->id,
                'desc' => null,
            ]);
        }

        ReplyingBookingAnalysis::where('booking_id', $booking->id)->where('replying_booking_id', $replaying->id)->delete();


        if ($request->laboratory) {
            $analysisData = $request->input('laboratory');
            foreach ($analysisData as $analysData) {
                $data = [];

                $data['booking_id'] = $booking->id;
                $data['patient_id'] = $booking->patient_id;
                $data['doctor_id'] = $booking->doctor_id;
                $data['replying_booking_id'] = $replaying->id;
                $data['laboratory_id'] = $analysData['laboratory_id'];
                $data['analysis_id'] = $analysData['analysis_id'];
                $data['note'] = $analysData['note'];

                ReplyingBookingAnalysis::create($data);
            }
        }


        Notification::create([
            'title'=>helperTrans('api.Doctor Replying For Your Booking'),
            'body'=>helperTrans('api.Doctor Replying For Your Booking'),
            'user_type'=>'patient',
            'user_id'=>$booking->patient_id,
            'type'=>'accept',
            'date'=>date('Y-m-d'),
            'foreign_id'=>$booking->id,
            'main_service_id'=>$booking->main_service_id,

        ]);


        return $this->returnSuccessMessage([helperTrans('api.laboratory replaying added successfully')]);


    }

    public function make_replying_radiology_center(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
                'booking_id' => 'required|exists:bookings,id',
                'radiology_center' => 'nullable|array',
                'radiology_center.*.radiology_center_id' => 'required_with:radiology_center|nullable|exists:radiology_centers,id',
                'radiology_center.*.radiology_id' => 'nullable|exists:radiologies,id',
                'radiology_center.*.note' => 'nullable|string',


            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }

        $doctor = auth('doctor')->user();

        $booking = Booking::where('status', 'active')->where('doctor_id', $doctor->id)->find($request->booking_id);

        if (!$booking) {
            return $this->returnError([helperTrans('api.booking not found')]);
        }

        $replaying = ReplyingBooking::where('booking_id', $request->booking_id)->where('patient_id', $booking->patient_id)->where('doctor_id', $doctor->id)->first();

        if (!$replaying) {

            $replaying = ReplyingBooking::create([
                'booking_id' => $booking->id,
                'patient_id' => $booking->patient_id,
                'doctor_id' => $doctor->id,
                'desc' => null,
            ]);
        }

        ReplyingBookingRadiology::where('booking_id', $booking->id)->where('replying_booking_id', $replaying->id)->delete();


        if ($request->radiology_center) {
            $radiologyData = $request->input('radiology_center');
            foreach ($radiologyData as $radiologData) {
                $data = [];
                $data['booking_id'] = $booking->id;
                $data['patient_id'] = $booking->patient_id;
                $data['doctor_id'] = $booking->doctor_id;
                $data['replying_booking_id'] = $replaying->id;
                $data['radiology_center_id'] = $radiologData['radiology_center_id'];
                $data['radiology_id'] = $radiologData['radiology_id'];
                $data['note'] =  $radiologData['note'] ?? null;

                ReplyingBookingRadiology::create($data);
            }

        }

        Notification::create([
            'title'=>helperTrans('api.Doctor Replying For Your Booking'),
            'body'=>helperTrans('api.Doctor Replying For Your Booking'),
            'user_type'=>'patient',
            'user_id'=>$booking->patient_id,
            'type'=>'accept',
            'date'=>date('Y-m-d'),
            'foreign_id'=>$booking->id,
            'main_service_id'=>$booking->main_service_id,

        ]);

        return $this->returnSuccessMessage([helperTrans('api.radiology center replaying added successfully')]);


    }


    public function make_replying_pharmacy(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'booking_id' => 'required|exists:bookings,id',
                'pharmacy' => 'nullable|array',
                'pharmacy.*.pharmacy_id' => 'required_with:pharmacy|nullable|exists:pharmacies,id',
                'pharmacy.*.medication_unit_id' => 'required_with:pharmacy|nullable|exists:medication_units,id',
                'pharmacy.*.medication_way_id' => 'required_with:pharmacy|nullable|exists:medication_ways,id',
                'pharmacy.*.note' => 'required_with:pharmacy|nullable|string',


            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }

        $doctor = auth('doctor')->user();

        $booking = Booking::where('status', 'active')->where('doctor_id', $doctor->id)->find($request->booking_id);

        if (!$booking) {
            return $this->returnError([helperTrans('api.booking not found')]);
        }

        $replaying = ReplyingBooking::where('booking_id', $request->booking_id)->where('patient_id', $booking->patient_id)->where('doctor_id', $doctor->id)->first();

        if (!$replaying) {

            $replaying = ReplyingBooking::create([
                'booking_id' => $booking->id,
                'patient_id' => $booking->patient_id,
                'doctor_id' => $doctor->id,
                'desc' => null,
            ]);
        }

        ReplyingBookingMedical::where('booking_id', $booking->id)->where('replying_booking_id', $replaying->id)->delete();


        if ($request->pharmacy) {
            $medicalsData = $request->input('pharmacy');
            foreach ($medicalsData as $medicalData) {
                $data = [];

                $data['booking_id'] = $booking->id;
                $data['patient_id'] = $booking->patient_id;
                $data['doctor_id'] = $booking->doctor_id;
                $data['replying_booking_id'] = $replaying->id;
                $data['pharmacy_id'] = $medicalData['pharmacy_id'];
                $data['medication_unit_id'] = $medicalData['medication_unit_id'];
                $data['medication_way_id'] = $medicalData['medication_way_id'];
                $data['note'] = $medicalData['note'];

                ReplyingBookingMedical::create($data);
            }
        }


        Notification::create([
            'title'=>helperTrans('api.Doctor Replying For Your Booking'),
            'body'=>helperTrans('api.Doctor Replying For Your Booking'),
            'user_type'=>'patient',
            'user_id'=>$booking->patient_id,
            'type'=>'accept',
            'date'=>date('Y-m-d'),
            'foreign_id'=>$booking->id,
            'main_service_id'=>$booking->main_service_id,

        ]);

        return $this->returnSuccessMessage([helperTrans('api.pharmacy replaying added successfully')]);


    }



    public function make_replying_diagnoses(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
                'booking_id' => 'required|exists:bookings,id',
                'diagnoses' => 'required|array',
                'diagnoses.*.diagnosis_id' => 'required|exists:diagnoses,id',

            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }

        $doctor = auth('doctor')->user();

        $booking = Booking::where('status', 'active')->where('doctor_id', $doctor->id)->find($request->booking_id);

        if (!$booking) {
            return $this->returnError([helperTrans('api.booking not found')]);
        }

        $replaying = ReplyingBooking::where('booking_id', $request->booking_id)->where('patient_id', $booking->patient_id)->where('doctor_id', $doctor->id)->first();

        if (!$replaying) {

            $replaying = ReplyingBooking::create([
                'booking_id' => $booking->id,
                'patient_id' => $booking->patient_id,
                'doctor_id' => $doctor->id,
                'desc' => null,
            ]);
        }

        //ReplyingBookingDiagnosis::where('booking_id', $booking->id)->where('replying_booking_id', $replaying->id)->delete();
        if ($request->diagnoses) {

            $diagnosesData = $request->input('diagnoses');
            foreach ($diagnosesData as $diagnosisData) {
                $row = ReplyingBookingDiagnosis::where('booking_id', $booking->id)->where('replying_booking_id', $replaying->id)->where('diagnosis_id', $diagnosisData['diagnosis_id'])->first();
                if($row == null) {
                    $data = [];
                    $data['booking_id'] = $booking->id;
                    $data['patient_id'] = $booking->patient_id;
                    $data['doctor_id'] = $booking->doctor_id;
                    $data['replying_booking_id'] = $replaying->id;
                    $data['diagnosis_id'] = $diagnosisData['diagnosis_id'];
                    ReplyingBookingDiagnosis::create($data);
                }
            }

        }


        Notification::create([
            'title'=>helperTrans('api.Doctor Replying For Your Booking'),
            'body'=>helperTrans('api.Doctor Replying For Your Booking'),
            'user_type'=>'patient',
            'user_id'=>$booking->patient_id,
            'type'=>'accept',
            'date'=>date('Y-m-d'),
            'foreign_id'=>$booking->id,
            'main_service_id'=>$booking->main_service_id,

        ]);

        return $this->returnSuccessMessage([helperTrans('api.diagnoses replaying added successfully')]);


    }

    public function delete_replying_diagnoses(Request $request) {
        $validator = Validator::make($request->all(),
        [
            'booking_id' => 'required|exists:bookings,id',
            'diagnosis_id' => 'required|exists:diagnoses,id',

        ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }

        $doctor = auth('doctor')->user();

        $booking = Booking::where('status', 'active')->where('doctor_id', $doctor->id)->find($request->booking_id);

        if (!$booking) {
            return $this->returnError([helperTrans('api.booking not found')]);
        }

        $replaying = ReplyingBooking::where('booking_id', $request->booking_id)->where('patient_id', $booking->patient_id)->where('doctor_id', $doctor->id)->first();

        if (!$replaying) {

            $replaying = ReplyingBooking::create([
                'booking_id' => $booking->id,
                'patient_id' => $booking->patient_id,
                'doctor_id' => $doctor->id,
                'desc' => null,
            ]);
        }

        $delete_diagnosis = ReplyingBookingDiagnosis::where('booking_id', $booking->id)->where('replying_booking_id', $replaying->id)->where('diagnosis_id', $request->diagnosis_id)->first();
        if($delete_diagnosis == null) {
            return $this->returnSuccessMessage([helperTrans('api.This diagnosis does not exist')]);
        }
        return $this->returnSuccessMessage([helperTrans('api.diagnoses replaying deleted successfully')]);
    }


    public function show_replying_laboratory(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
                'booking_id' => 'required|exists:bookings,id',

            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }

        $doctor = auth('doctor')->user();

        $booking = Booking::where('status', 'active')->where('doctor_id', $doctor->id)->find($request->booking_id);

        if (!$booking) {
            return $this->returnError([helperTrans('api.booking not found')]);
        }

        $replay = ReplyingBooking::with(['replyingBookingAnalysis'])->where('booking_id', $request->booking_id)->where('patient_id', $booking->patient_id)->where('doctor_id', $doctor->id)->first();

        if (!$replay) {

            return $this->returnError([helperTrans('api.Main Replaying not found')]);
        }


        return $this->returnData(ReplayingBookingResource::make($replay), [helperTrans('api.Booking Replay Data')], 200);


    }


    public function show_replying_pharmacy(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
                'booking_id' => 'required|exists:bookings,id',

            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }

        $doctor = auth('doctor')->user();

        $booking = Booking::where('status', 'active')->where('doctor_id', $doctor->id)->find($request->booking_id);

        if (!$booking) {
            return $this->returnError([helperTrans('api.booking not found')]);
        }

        $replay = ReplyingBooking::with(['replyingBookingMedicals'])->where('booking_id', $request->booking_id)->where('patient_id', $booking->patient_id)->where('doctor_id', $doctor->id)->first();


        if (!$replay) {

            return $this->returnError([helperTrans('api.Main Replaying not found')]);
        }


        return $this->returnData(ReplayingBookingResource::make($replay), [helperTrans('api.Booking Replay Data')], 200);


    }

    public function show_replying_radiology_center(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
                'booking_id' => 'required|exists:bookings,id',

            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }

        $doctor = auth('doctor')->user();

        $booking = Booking::where('status', 'active')->where('doctor_id', $doctor->id)->find($request->booking_id);

        if (!$booking) {
            return $this->returnError([helperTrans('api.booking not found')]);
        }

        $replay = ReplyingBooking::with(['replyingBookingRadiology'])->where('booking_id', $request->booking_id)->where('patient_id', $booking->patient_id)->where('doctor_id', $doctor->id)->first();

        if (!$replay) {

            return $this->returnError([helperTrans('api.Main Replaying not found')]);
        }


        return $this->returnData(ReplayingBookingResource::make($replay), [helperTrans('api.Booking Replay Data')], 200);


    }

    public function show_replying_diagnoses(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
                'booking_id' => 'required|exists:bookings,id',

            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }

        $doctor = auth('doctor')->user();

        $booking = Booking::where('status', 'active')->where('doctor_id', $doctor->id)->find($request->booking_id);

        if (!$booking) {
            return $this->returnError([helperTrans('api.booking not found')]);
        }

        $replay = ReplyingBooking::with(['replyingBookingDiagnoses'])->where('booking_id', $request->booking_id)->where('patient_id', $booking->patient_id)->where('doctor_id', $doctor->id)->first();


        if (!$replay) {

            return $this->returnError([helperTrans('api.Main Replaying not found')]);
        }


        return $this->returnData(ReplayingBookingResource::make($replay), [helperTrans('api.Booking Replay Data')], 200);

    }

    public function show_replying(Request $request)
    {


        $validator = Validator::make($request->all(),
            [
                'booking_id' => 'required|exists:bookings,id',

            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }

        $doctor = auth('doctor')->user();

        $booking = Booking::where('status', 'active')->where('doctor_id', $doctor->id)->find($request->booking_id);

        if (!$booking) {
            return $this->returnError([helperTrans('api.booking not found')]);
        }

        $replay = ReplyingBooking::where('booking_id', $request->booking_id)->where('patient_id', $booking->patient_id)->where('doctor_id', $doctor->id)->first();


        if (!$replay) {

            return $this->returnError([helperTrans('api.Main Replaying not found')]);
        }


        return $this->returnData(ReplayingBookingResource::make($replay), [helperTrans('api.Booking Replay Data')], 200);


    }

    public function end_booking(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
                'booking_id' => 'required|exists:bookings,id',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }

        $doctor = auth('doctor')->user();
        $booking = Booking::where('doctor_id', $doctor->id)->find($request->booking_id);
        if (!$booking) {
            return $this->returnError([helperTrans('api.Booking not Found')]);
        }

        $booking->update([
            'status' => 'complete',
        ]);

        return $this->returnSuccessMessage([helperTrans('api.booking completed')]);
    }


    public function make_agora_room(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
                'booking_id' => 'required|exists:bookings,id',
                'type' => 'required|in:audio,video',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }

        $doctor = auth('doctor')->user();
        $booking = Booking::where('doctor_id', $doctor->id)->where('status', 'active')->find($request->booking_id);
        if (!$booking) {
            return $this->returnError([helperTrans('api.Booking not Found')]);
        }

        $room = AgoraRoom::where('doctor_id', $doctor->id)->where('booking_id', $booking->id)->where('patient_id', $booking->patient_id)->where('name', '!=', null)->first();


        if (!$room) {
            $name = $doctor->id . $booking->patient_id . strtotime(now());
            $room = AgoraRoom::create([
                'booking_id' => $booking->id,
                'patient_id' => $booking->patient_id,
                'doctor_id' => $doctor->id,
                'name' => $name,
            ]);
        }

        $body = helperTrans('api.you receive ') . $request->type . 'from Doctor';
        $parent_ides = [$booking->patient_id];
        $notificationObject = [
            'notification' => [
                'title' => helperTrans('api.Room Notification'),
                'body' => $body,
                'sound' => 'default',
            ],
            'data' => [
                'title' => helperTrans('api.Room Notification'),
                'body' => $body,
                'type' => $request->type,
                'name' => $room->name,

            ],
        ];
        $this->sendFCMNotification($parent_ides, 'patient', $notificationObject);

        return $this->returnData(AgoraRoomResource::make($room), [helperTrans('api.Room Data')], 200);


    }


    public function select_providers(Request $request)
    {

        $selectProviders = SelectProvider::get();

        return $this->returnData(SelectProviderResource::collection($selectProviders), [helperTrans('api.Select Providers Data')], 200);


    }


    public function online_doctors(Request $request){

        $doctor = auth('doctor')->user();

        $mainService=MainService::where('slug','general-consultation')->first();
        if (!$mainService){

            return  $this->returnErrorNotFound([helperTrans('api.Main Service Not Found')]);
        }
        $category_ides=Category::where('main_service_id',$mainService->id)->pluck('id')->toArray();
        $online_doctor_ides=FirebaseToken::where('user_type','doctor')->pluck('user_id')->toArray();
        $online_doctors=Doctor::whereIn('id',$online_doctor_ides)->where('id','!=',$doctor->id)->where('status',true)->whereHas('categories',function ($query) use ($category_ides){
            $query->whereIn('categories.id',$category_ides);
        })->get();

        return $this->returnData(DoctorResource::collection($online_doctors),[helperTrans('api.online Doctors')]);

    }

    public function doctor_rebooking(Request $request){

        $validator = Validator::make($request->all(),
            [
                'patient_id' => 'required|exists:patients,id',
                'doctor_id'=>'required|exists:doctors,id',
                'desc'=>'nullable',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }

        $doctor = auth('doctor')->user();

        if ($doctor->id==$request->doctor_id){
            return $this->returnError([helperTrans('api.you cant not make Booking for you')]);
        }

        $mainService=MainService::where('slug','general-consultation')->first();
        if (!$mainService){

            return  $this->returnErrorNotFound([helperTrans('api.Main Service Not Found')]);
        }

        $bookingId = DB::table('bookings')->insertGetId([
            'patient_id' => $request->patient_id,
            'main_service_id' => $mainService->id,
            'operation_type' => null,
            'operation_id' => null,
            'desc' => $request->desc,
            'day' => date('Y-m-d'),
            'time' => date('H:i:s'),
            'doctor_id' =>$request->doctor_id,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);

        $body = helperTrans('api.Patient Waiting to be accept ').$mainService->name;


        $notification=Notification::create([
            'main_service_id'=>$mainService->id,
            'foreign_id'=>$bookingId,
            'is_read'=>0,
            'date'=>date('Y-m-d'),
            'type'=>'booking',
            'user_id'=>$request->doctor_id,
            'user_type'=>'doctor',
            'title'=>helperTrans('api.Patient Waiting to be accept'),
            'body'=>$body,
        ]);



        return  $this->returnSuccessMessage([helperTrans('api.rebooking successfully')]);


    }

    public function complete_bookings(Request $request){

        $validator = Validator::make($request->all(),
            [
                'patient_id' => 'required|exists:patients,id',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }

        $bookings=Booking::with(['doctor.specialization','docs','mainService'])->where('patient_id',$request->patient_id)->where('status','complete')->get();


        return  $this->returnData(BookingResource::collection($bookings),[helperTrans('api.Bookings Data')]);

    }

    public function booking_replay_by_patient_id(Request $request){


        $validator = Validator::make($request->all(),
            [
                'booking_id' => 'required|exists:bookings,id',
                'patient_id' => 'required|exists:patients,id',

            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }



        $booking=Booking::where('patient_id',$request->patient_id)->find($request->booking_id);

        if (!$booking){
            return $this->returnError([helperTrans('api.booking not found')]);
        }

        $replay=ReplyingBooking::with(['doctor','replyingBookingAnalysis','replyingBookingMedicals','replyingBookingRadiology','replyingBookingDiagnoses'])->where('booking_id',$booking->id)->first();

        if (!$replay){
            return $this->returnError([helperTrans('api.There is No Replaying')]);
        }


        return $this->returnData(ReplayingBookingResource::make($replay),[helperTrans('api.Booking Replay Data')],200);



    }

    public function test(Request $request) {
        $validator = Validator::make($request->all(),
        [
            'booking_id' => 'required|exists:bookings,id',
            'type'       => 'required',

        ], []);



        $type = $request->type;

        $booking=Booking::find($request->booking_id);

        if (!$booking){
            return $this->returnError([helperTrans('api.booking not found')]);
        }
        
        $replay=ReplyingBooking::with(['doctor','replyingBookingAnalysis','replyingBookingMedicals','replyingBookingRadiology','replyingBookingDiagnoses'])->where('booking_id',$booking->id)->first();

        if (!$replay){
            return $this->returnError([helperTrans('api.There is No Replaying')]);
        }

        // $data = ['replay'=> $replay, 'booking' => $booking, 'type'=> 'diagnoses'];
        // $pdf = PDF::loadView('Pdf.reply', $data);

        // $name = 'contract'.time().'.pdf';
        // $pdf->save(storage_path($name));
        // $link = Storage::url($name);
        // $data = [
        //     'status' => 200,
        //     'link' => $link,
        // ];
        return view('Pdf.reply', compact('replay', 'booking', 'type'));
    }
    
}
