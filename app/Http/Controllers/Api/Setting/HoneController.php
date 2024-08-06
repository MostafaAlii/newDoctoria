<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\DoctorLessResource;
use App\Http\Resources\SettingResource;
use App\Http\Resources\SliderResource;
use App\Http\Resources\SpecializationResource;
use App\Http\Traits\Api_Trait;
use App\Models\Doctor;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;

class HoneController extends Controller
{
    use Api_Trait;
    //
    public function sliders(){
        $sliders=Slider::get();
        return $this->returnData(SliderResource::collection($sliders),[helperTrans('api.sliders data')],200);

    }
    public function specialization_popular_doctors(){
        $specializations=Specialization::with(['limitPopularDoctors.specialization'])->limit(6)->get();
        return $this->returnData(SpecializationResource::collection($specializations),[helperTrans('api.specializations data')],200);

    }

    public function specializations(){

        $specializations=Specialization::whereNull('parent_id')->get();
        return $this->returnData(SpecializationResource::collection($specializations),[helperTrans('api.specializations data')],200);


    }

    public function settings(){
      $settings=Setting::firstOrCreate();

      return $this->returnData(SettingResource::make($settings),[helperTrans('api.Setting Data')]);
    }

    public function replay_pdf(Request $request){

        $data = [
            'foo' => 'bar'
        ];



        return $this->returnData(null,[helperTrans('api.pdf file')]);

    }

    public function specialization_doctors(Request $request){
        $validator = Validator::make($request->all(),
            [
                'specialization_id' => 'required|exists:specializations,id',


            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }

        if($request->page) {
            $doctors=Doctor::with(['specialization'])->where('specialization_id',$request->specialization_id)->paginate(20);  
            return $this->returnDataPaginate(DoctorLessResource::collection($doctors), [helperTrans('api.Doctors Data')] , $doctors->lastPage(), $doctors->currentPage(), $doctors->count());
        } else {
            $doctors=Doctor::with(['specialization'])->where('specialization_id',$request->specialization_id)->get();
            return $this->returnData(DoctorResource::collection($doctors),[helperTrans('api.Doctors Data')]);
        }


    }

}
