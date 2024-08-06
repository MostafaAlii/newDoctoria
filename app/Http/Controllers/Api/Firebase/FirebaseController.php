<?php

namespace App\Http\Controllers\Api\Firebase;

use App\Http\Controllers\Controller;
use App\Http\Traits\Api_Trait;
use App\Models\FirebaseToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FirebaseController extends Controller
{
    use Api_Trait;

    //
    public function update_firebase_token(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
                'user_type' => 'required|in:patient,doctor',
                'type' => 'required|in:ios,android',
                'token' => 'required',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }

        if ($request->user_type == 'doctor') {
            $user = auth('doctor')->user();
        } else {
            $user = auth('patient')->user();
        }
        if (!$user) {
            return $this->returnError([helperTrans('api.Unauthorized')], 401);
        }

        $token = FirebaseToken::where('type', $request->type)->where('user_type', $request->user_type)->where('user_id', $user->id)->where('token', $request->token)->first();

        if (!$token) {
            $token = FirebaseToken::create([
                'user_id' => $user->id,
                'user_type' => $request->user_type,
                'type' => $request->type,
                'token' => $request->token,
            ]);
        }


        return  $this->returnSuccessMessage([helperTrans('api.token updated successfully')]);
    }
}
