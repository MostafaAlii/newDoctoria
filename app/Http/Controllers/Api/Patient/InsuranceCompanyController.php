<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use App\Http\Resources\InsuranceCompanyResource;
use App\Http\Traits\Api_Trait;
use App\Models\InsuranceCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InsuranceCompanyController extends Controller
{
    //

    use Api_Trait;

    public function index(Request $request){
        $campanies=InsuranceCompany::get();
        return $this->returnData(InsuranceCompanyResource::collection($campanies),[helperTrans('api.Insurace campanies data')],200);

    }
}
