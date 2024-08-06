<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\PatientResource;
use App\Http\Traits\Api_Trait;
use App\Models\Doctor;
use App\Models\FirebaseToken;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    use Api_Trait;
    //

    public function show_patient_profile(Request $request){
        $validator = Validator::make($request->all(),
            [
                'patient_id' => 'required|exists:patients,id',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }

        $patient=Patient::find($request->patient_id);

        return  $this->returnData(PatientResource::make($patient),[helperTrans('api.Profile Data')]);
    }

    public function show_doctor_profile(Request $request){

        $validator = Validator::make($request->all(),
            [
                'doctor_id' => 'required|exists:doctors,id',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }

        $doctor=Doctor::with(['categories','times'])->find($request->doctor_id);

        return  $this->returnData(DoctorResource::make($doctor),[helperTrans('api.Profile Data')]);

    }

    public function delete_account(Request $request) {
        $validator = Validator::make($request->all(),
        [
            'patient_id' => 'required|exists:patients,id',
        ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }
        $patient=Patient::find($request->patient_id);
        $patient->delete();

        return $this->returnSuccessMessage([helperTrans('api.Success Delete Account')]);

    }


}
