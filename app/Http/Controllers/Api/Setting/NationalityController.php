<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\NationalityResource;
use App\Http\Traits\Api_Trait;
use App\Models\Nationality;
use Illuminate\Http\Request;

class NationalityController extends Controller
{
    //
    use Api_Trait;
    public function index(){
        $nationalities=Nationality::get();
        return $this->returnData(NationalityResource::collection($nationalities),[helperTrans('api.nationalities data')],200);

    }
}
