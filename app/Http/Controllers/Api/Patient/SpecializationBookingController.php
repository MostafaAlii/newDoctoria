<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use App\Http\Resources\SpecializationBookingResource;
use App\Http\Resources\ProviderSpecializationBookingResource;
use App\Http\Traits\Api_Trait;
use App\Http\Traits\Upload_Files;
use App\Models\SpecializationBookingDocs;
use App\Models\SpecializationBooking;
use App\Models\ProviderSpecializationBooking;
use App\Models\ProviderSpecializationBookingDocs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpecializationBookingController extends Controller
{
    use Api_Trait,Upload_Files;
    //
    public function make_booking(Request $request){

        $patient=auth('patient')->user();

        if($request->visit == 'home') {

            $validator = Validator::make($request->all(),
            [
                'date'          => 'required',
                'time'          => 'required',
                'description'   => 'nullable',
                'location'      => 'required',
                'booking_type'  => 'required|in:insurance,individual',
            ], []);
            if ($validator->fails()) {
                return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
            }


            $booking= SpecializationBooking::create([
                'patient_id'    =>$patient->id,
                'date'          =>$request->date,
                'time'          =>$request->time,
                'description'   =>$request->description,
                'location'      =>$request->location,
                'booking_type'  =>$request->booking_type,
                'visit'         =>$request->visit,
                'doctor_id'     =>$request->doctor,
                'referral_code' =>$request->referral_code,
            ]);
    
            return $this->returnData(SpecializationBookingResource::make($booking),[helperTrans('api.Specialization booking successfully')]);


        } elseif($request->visit == 'online') {

            $validator = Validator::make($request->all(),
            [
                'date'          => 'required',
                'time'          => 'required',
                'description'   => 'nullable',
                'location'      => 'nullable',
                'booking_type'  => 'required|in:insurance,individual',
                'doc'           =>'nullable|array',
                'doc.*'         =>'required|file',

            ], []);
            if ($validator->fails()) {
                return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
            }

            $booking= SpecializationBooking::create([
                'patient_id'    =>$patient->id,
                'date'          =>$request->date,
                'time'          =>$request->time,
                'description'   =>$request->description,
                'location'      =>$request->location,
                'booking_type'  =>$request->booking_type,
                'visit'         =>$request->visit,
                'doctor_id'     =>$request->doctor,
                'branch_id'     =>$request->branch_id,
                'referral_code' =>$request->referral_code,
            ]);
    
            $booking_id=$booking->id;
    
            if ($request->doc)
                foreach ($request->doc as $doc){
                    $doc_file = $this->uploadFiles('specialization_bookings', $doc, null);
    
                    SpecializationBookingDocs::create([
                        'booking_id'=>$booking->id,
                        'doc'=>$doc_file,
                    ]);
                }
            
            return $this->returnData(SpecializationBookingResource::make($booking),[helperTrans('api.Specialization booking successfully')]);
    

        } elseif($request->visit == 'offline') {

            $validator = Validator::make($request->all(),
            [
                'date'          => 'required',
                'time'          => 'required',
                'branch_id'     => 'required',
                'booking_type'  => 'required|in:insurance,individual',
            ], []);
            if ($validator->fails()) {
                return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
            }


            $booking= SpecializationBooking::create([
                'patient_id'    =>$patient->id,
                'date'          =>$request->date,
                'time'          =>$request->time,
                'booking_type'  =>$request->booking_type,
                'visit'         =>$request->visit,
                'doctor_id'     =>$request->doctor,
                'referral_code' =>$request->referral_code,
            ]);
    
            return $this->returnData(SpecializationBookingResource::make($booking),[helperTrans('api.Specialization booking successfully')]);


        } else {
            $validator = Validator::make($request->all(),
            [
                'visit' => 'required',
            ], []);
            if ($validator->fails()) {
                return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
            }
        }
 
    }

    public function make_provider_specialization_booking(Request $request) {
        $patient=auth('patient')->user();
        //date from_time to_time descriptions location laboratory_id pharmacy_id radiology_center_id hospital_id
        if ($request->laboratory_id == null && $request->pharmacy_id == null && $request->radiology_center_id == null && $request->hospital_id == null) {
            $validator = Validator::make($request->all(),
            [
                'laboratory_id' => 'required',
                'pharmacy_id' => 'required',
                'radiology_center_id' => 'required',
                'hospital_id' => 'required',
            ], []);
            if ($validator->fails()) {
                return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
            }
        }
        $laboratory_id = $request->laboratory_id ?? null;
        $pharmacy_id = $request->pharmacy_id ?? null;
        $radiology_center_id = $request->radiology_center_id ?? null;
        $hospital_id = $request->hospital_id ?? null;

        $validator = Validator::make($request->all(),
        [
            'date'                      => 'required',
            'from_time'                 => 'required',
            'to_time'                   => 'required',
            'description'               => 'nullable',
            'insurance_company_id'      => 'nullable',
            'other_phone_num'           => 'required',
            'location'                  => 'required',
            'booking_type'              => 'required|in:insurance,individual,cash_on_delivery',
            'doc'                       => 'nullable|array',
            'doc.*'                     => 'required|file',
        ], []);

        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }
        
        $booking = ProviderSpecializationBooking::create([
            'patient_id'            =>  $patient->id,
            'date'                  =>  $request->date,
            'from_time'             =>  $request->from_time,
            'to_time'               =>  $request->to_time,
            'description'           =>  $request->description,
            'location'              =>  $request->location,
            'other_phone_num'       =>  $request->other_phone_num,
            'insurance_company_id'  =>  $request->insurance_company_id ?? null,
            'laboratory_id'         =>  $laboratory_id,
            'pharmacy_id'           =>  $pharmacy_id,
            'radiology_center_id'   =>  $radiology_center_id,
            'hospital_id'           =>  $hospital_id,
        ]);

        if ($request->doc)
            foreach ($request->doc as $doc){
                $doc_file = $this->uploadFiles('provider_specialization_bookings', $doc, null);

                ProviderSpecializationBookingDocs::create([
                    'booking_id'=>$booking->id,
                    'doc'=>$doc_file,
                ]);
            }
    
        return $this->returnData(ProviderSpecializationBookingResource::make($booking),[helperTrans('api.Provider Specialization booking successfully')]);
    }


}
