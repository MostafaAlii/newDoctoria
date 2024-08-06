<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\MainServiceResource;
use App\Http\Traits\Api_Trait;
use App\Models\MainService;
use Illuminate\Http\Request;

class MainServiceController extends Controller
{
    //
    use Api_Trait;

    public function index(){
        $mainServices=MainService::with(['categories'])->get();
        return $this->returnData(MainServiceResource::collection($mainServices),[helperTrans('api.Main Services data')],200);

    }
}
