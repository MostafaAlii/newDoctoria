<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use App\Http\Resources\MedicalBagResource;
use App\Http\Traits\Api_Trait;
use App\Models\MedicalBagPatient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MedicalBagController extends Controller
{
    use Api_Trait;
    //
    public function index(Request $request){
        $validator = Validator::make($request->all(),
            [
                'category_id' => 'required|exists:categories,id',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }

        $patient=auth('patient')->user();


        $medical_bags=MedicalBagPatient::where('category_id',$request->category_id)->where('patient_id',$patient->id)->get();

        return $this->returnData(MedicalBagResource::collection($medical_bags),[helperTrans('api.Medical Bags data')],200);

    }

    public function store (Request $request){


        $validator = Validator::make($request->all(),
            [
                'category_id' => 'required|exists:categories,id',
                'value' => 'required|regex:/^\d+(\.\d{1,2})?$/|numeric|min:0.01',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }
        $patient=auth('patient')->user();


        $medical_bag=MedicalBagPatient::create([
            'unit'=>'C',
            'value'=>$request->value,
            'category_id'=>$request->category_id,
            'patient_id'=>$patient->id,

        ]);

        return $this->returnData(MedicalBagResource::make($medical_bag),[helperTrans('api.Medical Bag data')],200);


    }
}
