<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\AnalysisResource;
use App\Http\Resources\LaboratoryResource;
use App\Http\Resources\MedicationUnitResource;
use App\Http\Resources\PharmacyResource;
use App\Http\Resources\RadiologyCenterResource;
use App\Http\Resources\HospitalResource;
use App\Http\Resources\RadiologyResource;
use App\Http\Traits\Api_Trait;
use App\Models\Analysis;
use App\Models\Laboratory;
use App\Models\Pharmacy;
use App\Models\Hospital;
use App\Models\Radiology;
use App\Models\RadiologyCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProviderController extends Controller
{
    use Api_Trait;
    //
    public function provider_regions(Request $request){

        $validator = Validator::make($request->all(),
            [
                'slug' => 'required|exists:select_providers,slug',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }

        if ($request->slug=='pharmacy') {
            $pharmacies = Pharmacy::whereHas('categories', function ($query) use ($request) {
                $query->where('categories.slug', 'provider');
            })->get();
            return $this->returnData(PharmacyResource::collection($pharmacies), [helperTrans('api.Pharmacies Data')], 200);

        }
        elseif ($request->slug=='laboratory'){
            $laboratories = Laboratory::whereHas('categories', function ($query) use ($request) {
                $query->where('categories.slug', 'laboratory');
            })->get();
            return $this->returnData(LaboratoryResource::collection($laboratories), [helperTrans('api.Laboratories Data')], 200);

        }
        elseif ($request->slug=='radiology_center'){
            $centers = RadiologyCenter::whereHas('categories', function ($query) use ($request) {
                $query->where('categories.slug', 'provider');
            })->get();
            return $this->returnData(RadiologyCenterResource::collection($centers), [helperTrans('api.Radiology Center Data')], 200);

        }
        elseif ($request->slug=='hospital') {
            $hospitals=Hospital::get();
            return $this->returnData(HospitalResource::collection($hospitals),[helperTrans('api.Hospital Data')], 200);        
        }

        else
            return  $this->returnError([helperTrans('api.Regions Not found')]);

    }


    public function provider_region_data(Request $request){
        $validator = Validator::make($request->all(),
            [
                'slug' => 'required|exists:select_providers,slug',
                'region_id'=>'required|numeric',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }

        if ($request->slug=='pharmacy') {
              $pharmacy=Pharmacy::find($request->region_id);
              if (!$pharmacy){
                  return  $this->returnError([helperTrans('pharmacy Not Found')]);
              }

            return $this->returnData(MedicationUnitResource::collection($pharmacy->medicationUnits), [helperTrans('api.Medication Units Data')], 200);

        }
        elseif ($request->slug=='laboratory'){
            $laboratory=Laboratory::find($request->region_id);
            if (!$laboratory){
                return  $this->returnError([helperTrans('Laboratory Not Found')]);
            }

            $analysis=Analysis::where('laboratory_id',$laboratory->id)->get();

            return $this->returnData(AnalysisResource::collection($analysis), [helperTrans('api.Analysis Data')], 200);

        }

        elseif ($request->slug=='radiology_center'){
            $radiology_center=RadiologyCenter::find($request->region_id);
            if (!$radiology_center){
                return  $this->returnError([helperTrans('Radiology Center Not Found')]);
            }

            $radiology=Radiology::where('radiology_center_id',$radiology_center->id)->get();
            return $this->returnData(RadiologyResource::collection($radiology), [helperTrans('api.Radiology Data')], 200);


        }

        else
            return  $this->returnError([helperTrans('api.Regions Not found')]);

    }


    public function provider_data(Request $request) {
        $validator = Validator::make($request->all(),
        [
            'slug' => 'required|exists:select_providers,slug',
            'id'   =>'required|numeric',
        ], []);

        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }

        if ($request->slug=='pharmacy') {
            $pharmacy=Pharmacy::find($request->id);
            if (!$pharmacy){
              return  $this->returnError([helperTrans('pharmacy Not Found')]);
            }

            return $this->returnData(PharmacyResource::make($pharmacy), [helperTrans('api.Pharmacy Data')], 200);

        }
        elseif ($request->slug=='laboratory'){
            $laboratory=Laboratory::find($request->id);
            if (!$laboratory){
                return  $this->returnError([helperTrans('Laboratory Not Found')]);
            }

            return $this->returnData(LaboratoryResource::make($laboratory), [helperTrans('api.Laboratory Data')], 200);

        }

        elseif ($request->slug=='radiology_center'){
            $radiology_center=RadiologyCenter::find($request->id);
            if (!$radiology_center){
                return  $this->returnError([helperTrans('Radiology Center Not Found')]);
            }

            return $this->returnData(RadiologyCenterResource::make($radiology_center), [helperTrans('api.Radiology Center Data')], 200);

        }

        else
            return  $this->returnError([helperTrans('api.Regions Not found')]);
    }



}
