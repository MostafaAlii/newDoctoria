<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
use App\Http\Traits\Api_Trait;
use App\Models\Category;
use App\Models\Doctor;
use App\Models\MainService;
use App\Models\ProviderCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    //
    use Api_Trait;
    public function doctors_by_category(Request $request){

        $validator = Validator::make($request->all(),
            [
                'category_id' => 'required|exists:categories,id',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }

        $category=Category::find($request->category_id);

        return $this->returnData(DoctorResource::collection($category->doctors),[helperTrans('api.doctors data')],200);


    }

    public function doctor_details(Request $request){

        $validator = Validator::make($request->all(),
            [
                'category_id' => 'nullable|exists:categories,id',
                'doctor_id'=>'required|exists:doctors,id',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }

        //$doctor = Doctor::find($request->doctor_id);

        // $category_id=$request->category_id;

        // if (!$request->category_id){
        //     $category=MainService::where('slug','specialized-consultation')->first();
        //     if (!$category)
        //         return  $this->returnError([helperTrans('api.Category Not Found')]);
        //     $category_id=$category->id;
        // }


         $doctor=Doctor::with(['specialization','times', 'doctor_branch'])->where('status',true)->find($request->doctor_id);
        // if (!$doctor){
        //     return  $this->returnError([helperTrans('api.This Doctor May Blocked')]);
        // }

        // $doctor_category=ProviderCategory::where('provider_type','doctor')->where('provider_id',$request->doctor_id)->where('category_id',$category_id)->pluck('category_id')->toArray();
        // if (!$doctor_category){
        //     return  $this->returnError([helperTrans('api.this category not belong to This Doctor')]);
        // }

        // $doctor->times=$doctor->times->where('category_id',$category_id);

        return $this->returnData(DoctorResource::make($doctor),[helperTrans('api.doctor data')],200);

    }

    public function get_popular() {
        $doctors = Doctor::with(['specialization','times', 'doctor_branch'])->where('status',true)->where('is_popular', 1)->get();
        return $this->returnData(DoctorResource::collection($doctors),[helperTrans('api.doctors popular data')],200);

    }

    public function fliter_doctor(Request $request) {
        $doctors = Doctor::whenGender($request->gender)
                    ->whenSpecialization($request->specialization)
                    ->whenCity($request->city)
                    ->whenGovernorate($request->governorate)
                    ->whenPriceHome($request->priceFromHome, $request->priceToHome)
                    ->whenPriceOnline($request->priceFromOnline, $request->priceToOnline)
                    ->with(['specialization','times', 'doctor_branch'])->where('status',true)->get();
        return $this->returnData(DoctorResource::collection($doctors),[helperTrans('api.doctors popular data')],200);
    }
}
