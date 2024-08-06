<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthDoctorResource;
use App\Http\Resources\AuthPatientResource;
use App\Http\Resources\AuthVoucherResource;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\PatientResource;
use App\Http\Traits\Api_Trait;
use App\Http\Traits\Upload_Files;
use App\Models\Doctor;
use App\Models\DoctorUpdate;
use App\Models\FirebaseToken;
use App\Models\Patient;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\User;
use TomatoPHP\LaravelAgora\Services\Agora;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Voucher;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthController extends Controller
{
    use Api_Trait,Upload_Files;

    public function __construct()
    {
        $this->resource = AuthPatientResource::class;
        $this->model = new Patient();
    }

    //
    public function loginWithVoucher(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'voucher_code' => 'required|string|exists:vouchers,code',
            'phone' => 'required',

        ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }

        $voucher = Voucher::where('code', $request->voucher_code)->first();

        if($voucher->phone != null) {
            if($voucher->phone != $request->phone) {
                return $this->returnError([helperTrans('api.Voucher already redeemed')]);
            }
        }

        $now = Carbon::now();

        if ($voucher->start_at && $now->lt($voucher->start_at)) {
            return response()->json(['message' => 'Voucher is not valid yet'], 400);
        }

        if ($voucher->end_at && $now->gt($voucher->end_at)) {
            return response()->json(['message' => 'Voucher has expired'], 400);
        }
      
        $voucher->phone = $request->phone;
        $voucher->save();

        // Generate a token (or some identifier) for the session
        $voucher->token = Str::random(60);
        return $this->returnData(AuthVoucherResource::make($voucher),[helperTrans('api.login successfully')]);

    }

    public function login(Request $request){

        // $id = 12;
        //
        // Generate a random user ID between 999 and 1999
        // $uid = 123456;
        //
        // Create Agora instance with the provided ID and user ID
        // return $agora = Agora::make(id: 1)->uId($uid)->token();
        //         return     $token= Agora::make(id: 1)->uId(rand(999, 1999))->join()->token();
        //


        $validator = Validator::make($request->all(),
            [
                'phone' => 'required',
                'password' => 'required',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }




        if ($token = patient()->attempt($request->all(), 1)) {
            $patient = patient()->user();
            if ($patient->status==0)
                return $this->returnError([helperTrans('api.The patient Account Is Inactive')]);
            $patient->token = $token;
            $patient->type='patient';
            return $this->returnData($this->resource::make($patient),[helperTrans('api.login successfully')]);
        }



        if ($token = doctor()->attempt(array_merge($request->all(), ['status' => true]), 1)) {

            $doctor = doctor()->user();
            $doctor->token = $token;
            $doctor->type='doctor';

            return $this->returnData(AuthDoctorResource::make($doctor),[helperTrans('api.login successfully')]);
        }



        return $this->returnError([helperTrans('api.No user was found with these credentials')], 422);

    }


    public function signup(Request $request){


        $validator = Validator::make($request->all(),
            [
                'name' => 'nullable|unique:patients,name',
                'refer_code' => "nullable|unique:patients,refer_code",
                'nickname' => 'nullable|unique:patients,nickname',
                'phone' => 'required|unique:patients,phone|unique:doctors,phone',
                'gender'=>'nullable|in:male,female',
                'postcode'=>'nullable',
                'city_id'=>'nullable|exists:cities,id',
                'nationality_id'=>'nullable|exists:nationalities,id',
                'address'=>'nullable',
                'email' => 'nullable|unique:patients,email',
                'password'=>'nullable',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }

        $data = $request->all();

        $data['password'] = Hash::make($request->password);
        $store = Patient::create($data);
        $patient = Patient::find($store->id);
        $patient->token = patient()->login($store, 1);
        return $this->returnData($this->resource::make($patient),[helperTrans('api.signup successfully')]);

    }



    public function logout(Request $request){

        $validator = Validator::make($request->all(),
            [
                'user_type' => 'required|in:doctor,patient',
                'type' => "required|in:android,ios",
                'token'=>'required',

            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }

        if ($request->user_type == 'doctor') {
            $user = auth('doctor')->user();
        } else {
            $user = auth('patient')->user();
        }
        if (!$user) {
            return $this->returnError([helperTrans('api.Unauthorized')], 401);
        }

        $token = FirebaseToken::where('type', $request->type)->where('user_type', $request->user_type)->where('user_id', $user->id)->where('token', $request->token)->delete();

        if ($request->user_type == 'doctor') {

            doctor()->logout();
        }
        else{
            patient()->logout();

        }


        return $this->returnSuccessMessage([helperTrans('api.sign out successfully')]);

    }

    public function delete_app_id(Request $request){
        $validator = Validator::make($request->all(),
            [
                'user_type' => 'required|in:doctor,patient',
                'type' => "required|in:android,ios",
                'token'=>'required',

            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }

        if ($request->user_type == 'doctor') {
            $user = auth('doctor')->user();
        } else {
            $user = auth('patient')->user();
        }
        if (!$user) {
            return $this->returnError([helperTrans('api.Unauthorized')], 401);
        }

        $token = FirebaseToken::where('type', $request->type)->where('user_type', $request->user_type)->where('user_id', $user->id)->where('token', $request->token)->delete();


        return $this->returnSuccessMessage([helperTrans('api.deleted successfully')]);

    }



    public function my_profile(Request $request){

        $validator = Validator::make($request->all(),
            [
                'user_type' => 'required|in:doctor,patient',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }

        if ($request->user_type == 'doctor') {
            $user = auth('doctor')->user();
        } else {
            $user = auth('patient')->user();
        }
        if (!$user) {
            return $this->returnError([helperTrans('api.Unauthorized')], 401);
        }


        if ($request->user_type == 'doctor') {
            return  $this->returnData(DoctorResource::make($user),[helperTrans('api.profile Data')]);
        } else {
            return  $this->returnData(PatientResource::make($user),[helperTrans('api.profile Data')]);

        }

    }



    public function update_my_profile(Request $request){
        if ($request->user_type == 'doctor') {
            $user = auth('doctor')->user();
        } else {
            $user = auth('patient')->user();
        }
        if (!$user) {
            return $this->returnError([helperTrans('api.Unauthorized')], 401);
        }
        if ($request->user_type=='doctor')
        $validator = Validator::make($request->all(),
            [
                'user_type' => 'nullable|in:doctor,patient',
                'name' => 'nullable',
                'email' => "nullable|unique:patients,email|unique:doctors,email,".$user->id,
                'nickname' => 'nullable|unique:patients,nickname|unique:doctors,nickname,'.$user->id,
                'phone' => 'nullable|unique:patients,phone|unique:doctors,phone,' . $user->id,
                'password' => 'nullable|min:6',
                'gender'=>'nullable|in:male,female',
                'location'=>'nullable',
                'image' => 'nullable|file',
                'service_price_online'=>'nullable|numeric',
                'service_price_home'=>'nullable|numeric',
                'experience_years'=>'nullable|numeric',
                'medical_certification'=>'nullable|array',
                'medical_certification.*'=>'nullable',
                'specialization_id'=>'nullable|exists:specializations,id'

            ], []);
        else
            $validator = Validator::make($request->all(),
                [
                    'user_type' => 'required|in:doctor,patient',
                    'name' => 'required',
                    'email' => "required|unique:doctors,email|unique:patients,email,".$user->id,
                    'nickname' => 'required|unique:doctors,nickname|unique:patients,nickname,'.$user->id,
                    'phone' => 'required|unique:doctors,phone|unique:patients,phone,' . $user->id,
                    'password' => 'nullable|min:6',
                    'gender'=>'required|in:male,female',
                    'location'=>'required',
                    'image' => 'nullable|file',


                ], []);

        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }

        $password=$user->password;
        $image=$user->image;
        if ($request->password)
            $password = Hash::make($request->password);
        if ($request->image)
           $image = $this->uploadFiles($request->user_type.'s', $request->file('image'), null);
        if ($request->user_type=='patient') {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $password,
                'image' => $image,
                'phone' => $request->phone,
                'location' => $request->location,
                'gender' => $request->gender,
                'nickname' => $request->nickname,
            ]);

        }
        else{
            $medical_certification=serialize($request->medical_certification);
            $doctorUpdate = DoctorUpdate::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'image'     => $image,
                'phone'     => $request->phone,
                'location'  => $request->location,
                'gender'    => $request->gender,
                'nickname'  => $request->nickname,
                'doctor_id' => auth('doctor')->user()->id,
            ]);
            $user->update([
                'password'  => $password,
                'medical_certification'=>$medical_certification,
                'specialization_id'=>$request->specialization_id,
                'service_price_online'=>$request->service_price_online,
                'service_price_home'=>$request->service_price_home,
                'experience_years'=>$request->experience_years,
            ]);

        }


        if ($request->user_type == 'doctor') {
            $authUser = auth('doctor')->user();
            $user=Doctor::with(['specialization'])->find($authUser->id);
         return   $this->returnData(DoctorResource::make($user),[helperTrans('api.Waiting for approval to update the data')]);
        } else {
            $user = auth('patient')->user();

        return    $this->returnData(PatientResource::make($user),[helperTrans('api.Profile Updated Successfully')]);
        }


    }

    public function fetchAgoraToken(Request $request)
    {
        // Data to be sent in the request
        $requestData = [
            "tokenType" => "rtc",
            "uid" => "13119",
            "role" => "publisher",
            "channel" => "test"
        ];



        // Make a POST request using Guzzle HTTP client
        $client = new Client();
        $response = $client->post('https://agora-token-service-example.up.railway.app/fetchToken', [
            'json' => $requestData,
            'headers' => [
                'Content-Type' => 'application/json',
            ]
        ]);

        // Get the response body
        $body = $response->getBody();

        // Convert JSON response to an associative array
        $data = json_decode($body, true);

        // You can return the data to the client or do any processing here
        return response()->json($data);
    }

    public function check_phone_number(Request $request) {
        $validator = Validator::make($request->all(),
        [
            'phone' => 'required'
        ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }
        $row = Patient::where('phone', $request->phone)->first();
        if($row != null) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }

    public function delete_account(Request $request) {
        $validator = Validator::make($request->all(),
        [
            'patient_id' => 'required'
        ], []);

        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }
        $row = Patient::find($request->patient_id);
        if($row == null) {
            return $this->returnError([helperTrans('api.This Patient Not Exist')], 401);
        }
        $row->delete();

        return $this->returnSuccessMessage([helperTrans('api.deleted successfully')]);
    }

}
