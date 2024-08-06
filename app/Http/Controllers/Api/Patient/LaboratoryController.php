<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use App\Http\Resources\LaboratoryResource;
use App\Http\Traits\Api_Trait;
use App\Models\Category;
use App\Models\Laboratory;
use App\Models\ProviderCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LaboratoryController extends Controller
{
    //

    use Api_Trait;

    public function index(Request $request){

        $validator = Validator::make($request->all(),
            [
                'category_id' => 'required|exists:categories,id',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }

        $category=Category::find($request->category_id);

        return $this->returnData(LaboratoryResource::collection($category->laboratories),[helperTrans('api.laboratories data')],200);


    }

    public function show(Request $request){

        $validator = Validator::make($request->all(),
            [
                'category_id' => 'required|exists:categories,id',
                'laboratory_id'=>'required|exists:laboratories,id',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }

        $laboratory=Laboratory::find($request->laboratory_id);

        $laboratory_category=ProviderCategory::where('provider_type','laboratory')->where('provider_id',$request->laboratory_id)->where('category_id',$request->category_id)->pluck('category_id')->toArray();
        if (!$laboratory_category){
            return  $this->returnError([helperTrans('api.this category not belong to This Laboratory')]);
        }


        return $this->returnData(LaboratoryResource::make($laboratory),[helperTrans('api.laboratory data')],200);

    }
}
