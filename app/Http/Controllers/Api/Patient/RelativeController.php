<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use App\Http\Resources\RelativeResource;
use App\Http\Traits\Api_Trait;
use App\Models\Relative;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RelativeController extends Controller
{
    use Api_Trait;
    //
    public function relatives(Request $request){
        $patient = auth('patient')->user();
         $relatives=Relative::with(['city','nationality','country'])->where('patient_id',$patient->id)->get();
         return $this->returnData(RelativeResource::collection($relatives),[helperTrans('api.Relatives Data')]);
    }
    public function add_relative(Request $request){

        $validator = Validator::make($request->all(),
            [
                'type'=>'required|in:father,mother,son,daughter,other',
                'gender'=>'required|in:male,female',
                'is_alcoholic'=>'required|in:0,1',
                'is_smoking'=>'required|in:0,1',
                'birth_date'=>'required|date',
                'first_name'=>'required|string',
                'last_name'=>'required|string',
                'id_number'=>'required|unique:relatives,id_number',
                'address'=>'required',
                'nationality_id'=>'required|exists:nationalities,id',
                'country_id'=>'required|exists:nationalities,id',
                'city_id'=>'required|exists:cities,id',


            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }

        $patient = auth('patient')->user();

        $row=Relative::create([
            'type'=>$request->type,
            'gender'=>$request->gender,
            'is_alcoholic'=>$request->is_alcoholic,
            'is_smoking'=>$request->is_smoking,
            'birth_date'=>$request->birth_date,
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'id_number'=>$request->id_number,
            'address'=>$request->address,
            'nationality_id'=>$request->nationality_id,
            'country_id'=>$request->country_id,
            'city_id'=>$request->city_id,
            'patient_id'=>$patient->id,
        ]);

        $relative=Relative::with(['city','nationality','country'])->where('patient_id',$patient->id)->find($row->id);


        return $this->returnData(RelativeResource::make($relative),[helperTrans('api.Relative added successfully')]);

    }

    public function update_relative(Request $request){
        $validator = Validator::make($request->all(),
            [
                'type'=>'required|in:father,mother,son,daughter,other',
                'gender'=>'required|in:male,female',
                'is_alcoholic'=>'required|in:0,1',
                'is_smoking'=>'required|in:0,1',
                'birth_date'=>'required|date',
                'first_name'=>'required|string',
                'last_name'=>'required|string',
                'id_number'=>'required|unique:relatives,id_number,'.$request->relative_id,
                'address'=>'required',
                'nationality_id'=>'required|exists:nationalities,id',
                'country_id'=>'required|exists:nationalities,id',
                'city_id'=>'required|exists:cities,id',
                'relative_id'=>'required|exists:relatives,id',


            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }

        $patient = auth('patient')->user();

        $relative=Relative::where('patient_id',$patient->id)->find($request->relative_id);

        if (!$relative){
        return    $this->returnError([helperTrans('api.relative not found')]);
        }

        $relative->update([
            'type'=>$request->type,
            'gender'=>$request->gender,
            'is_alcoholic'=>$request->is_alcoholic,
            'is_smoking'=>$request->is_smoking,
            'birth_date'=>$request->birth_date,
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'id_number'=>$request->id_number,
            'address'=>$request->address,
            'nationality_id'=>$request->nationality_id,
            'country_id'=>$request->country_id,
            'city_id'=>$request->city_id,

        ]);

        $relative=Relative::with(['city','nationality','country'])->where('patient_id',$patient->id)->find($request->relative_id);


        return $this->returnData(RelativeResource::make($relative),[helperTrans('api.Relative updated successfully')]);


    }

    public function delete_relative(Request $request){
        $validator = Validator::make($request->all(),
            [
                'relative_id'=>'required|exists:relatives,id',

            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }

        $patient = auth('patient')->user();

        $relative=Relative::where('patient_id',$patient->id)->find($request->relative_id);

        if (!$relative){
         return   $this->returnError([helperTrans('api.relative not found')]);
        }
        $relative->delete();

        return $this->returnData(null,[helperTrans('api.Relative deleted successfully')]);

    }
}
