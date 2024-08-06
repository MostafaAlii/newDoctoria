<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use App\Http\Traits\Api_Trait;
use App\Http\Traits\Upload_Files;
use App\Models\RequestBooking;
use App\Models\RequestBookingDoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RequestBookingController extends Controller
{
    use Api_Trait,Upload_Files;
    //
    public function make_request_booking(Request $request){
        $validator = Validator::make($request->all(),
            [
                'governorate_id' => 'required|exists:governorates,id',
                'city_id' => 'required|exists:cities,id',
                'location' => 'required|string',
                'desc'=>'nullable|string',
                'other_phone'=>'required',
                'booking_type'  => 'nullable|in:insurance,individual',
                'doc'=>'nullable|array',
                'doc.*'=>'nullable|file',
                'type'=>'required|in:visit_doctor,nursing,physical_therapy',
                // 'from_price' => $request->input('type') === 'visit_doctor' ? 'required|regex:/^\d+(\.\d{1,2})?$/' : 'nullable|regex:/^\d+(\.\d{1,2})?$/',
                // 'to_price' => $request->input('type') === 'visit_doctor' ? 'required|regex:/^\d+(\.\d{1,2})?$/' : 'nullable|regex:/^\d+(\.\d{1,2})?$/',
                'from_price' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
                'to_price' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
                'day' => 'required',
                'from_time' => 'required',
                'to_time' => 'required',
                'insurance_company_id' => $request->input('booking_type') === 'insurance' ? 'required|exists:insurance_companies,id' : 'nullable',
                'specialization_id' => $request->input('type') === 'visit_doctor' ? 'required|exists:specializations,id' : 'nullable'
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }
        $patient = auth('patient')->user();


        $request_booking=RequestBooking::create([
         'governorate_id'=>$request->governorate_id,
         'city_id'=>$request->city_id,
         'location'=>$request->location,
         'desc'=>$request->desc,
         'other_phone'=>$request->other_phone,
         'patient_id'=>$patient->id,
         'type'=>$request->type,
         'from_price'=>$request->from_price,
         'to_price'=>$request->to_price,
         'day'=>$request->day,
         'from_time'=>$request->from_time,
         'to_time'=>$request->to_time,
         'specialization_id'=>$request->specialization_id,
         'insurance_company_id'=>$request->insurance_company_id,
         'booking_type'=>'individual',
        ]);

        if ($request->doc)
            foreach ($request->doc as $doc){
                $doc_file = $this->uploadFiles('request_bookings', $doc, null);

                RequestBookingDoc::create([
                    'request_booking_id'=>$request_booking->id,
                    'doc'=>$doc_file,
                ]);
            }


        return $this->returnSuccessMessage([helperTrans('api.Success Operation')]);

    }
}
