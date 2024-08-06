<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Traits\Api_Trait;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //
    use Api_Trait;
    public function index(Request $request){
        $validator = Validator::make($request->all(),
            [
                'main_service_id' => 'required|exists:main_services,id',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }

        $categories=Category::where('main_service_id',$request->main_service_id)->get();

        return $this->returnData(CategoryResource::collection($categories),[helperTrans('api.categories data')],200);

    }
}
