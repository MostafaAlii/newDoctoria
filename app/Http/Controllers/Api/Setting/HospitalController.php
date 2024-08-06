<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\HospitalResource;
use App\Http\Traits\Api_Trait;
use App\Models\Hospital;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    //
    use  Api_Trait;
    public function hospitals(){

        $hospitals=Hospital::get();
        return $this->returnData(HospitalResource::collection($hospitals),[helperTrans('api.Hospital Data')]);

    }
}
