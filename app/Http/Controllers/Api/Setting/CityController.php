<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Http\Resources\GovernorateResource;
use App\Http\Traits\Api_Trait;
use App\Models\City;
use App\Models\Governorate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    use Api_Trait;
    //
    public function index(Request $request){
        $validator = Validator::make($request->all(),
            [
                'nationality_id' => 'required|exists:nationalities,id',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }

        $cities=City::where('nationality_id',$request->nationality_id)->get();

        return $this->returnData(CityResource::collection($cities),[helperTrans('api.cities data')],200);

    }
    public function governorates(){
        $governorates=Governorate::get();
        return $this->returnData(GovernorateResource::collection($governorates),[helperTrans('api.governorates data')],200);

    }

    public function cities_by_governorate(Request $request){
        $validator = Validator::make($request->all(),
            [
                'governorate_id' => 'required|exists:governorates,id',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }
        $cities=City::where('governorate_id',$request->governorate_id)->get();

        return $this->returnData(CityResource::collection($cities),[helperTrans('api.Cities data')],200);

    }

}
