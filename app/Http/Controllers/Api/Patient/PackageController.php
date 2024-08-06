<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use App\Http\Resources\PackageResource;
use App\Http\Traits\Api_Trait;
use App\Models\Package;
use App\Models\PatientSubscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{
    use Api_Trait;
    //
    public function index(Request $request){


        $packages=Package::with(['mainServicesPackage.mainService'])->get();

        return $this->returnData(PackageResource::collection($packages),[helperTrans('api.packages data')],200);


    }

    public function subscribe(Request $request){

        $validator = Validator::make($request->all(),
            [
                'package_id' => 'required|exists:packages,id',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }

        $patient=auth('patient')->user();

        PatientSubscribe::create([
            'package_id'=>$request->package_id,
            'patient_id'=>$patient->id,
            'status'=>'active',
        ]);

        return $this->returnSuccessMessage([helperTrans('api.subscribed successfully')],200);


    }
}
