<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use App\Http\Resources\FavoriteResource;
use App\Http\Traits\Api_Trait;
use App\Models\Doctor;
use App\Models\PatientFavorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FavoriteController extends Controller
{
    //
    use Api_Trait;

    public function add_favorite(Request $request) {
        $validator = Validator::make($request->all(),
        [
            'doctor_id'=>'required|exists:doctors,id',
        ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }

        $patient=auth('patient')->user();

        PatientFavorite::create([
            'patient_id' => $patient->id,
            'doctor_id'  => $request->id,
        ]);

        return $this->returnSuccessMessage([helperTrans('api.Success Add To Favorite')]);

    }

    public function list_favorite() {
        $patient=auth('patient')->user();
        $favorites=PatientFavorite::with(['doctor'])->where('patient_id', $patient->id)->get();
        return $this->returnData(FavoriteResource::collection($favorites),[helperTrans('api.favorites data')],200);


    }

    public function delete_favorite(Request $request) {
        $validator = Validator::make($request->all(),
        [
            'favorite_id'=>'required|exists:patient_favorites,id',
        ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }
        
        $patient=auth('patient')->user();

        $favorite = PatientFavorite::find($request->favorite_id);
        $favorite->delete();

        return $this->returnSuccessMessage([helperTrans('api.Success Delete item form Favorite')]);
    }

}
