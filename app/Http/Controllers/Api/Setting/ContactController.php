<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactResource;
use App\Http\Traits\Api_Trait;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    //
    use Api_Trait;
    public function index(Request $request){
        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required',
                'message' => 'required',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }

        $contact = Contact::create($request->all());

        return $this->returnData(ContactResource::make($contact),[helperTrans('api.message sent successfully')],200);

    }
}
