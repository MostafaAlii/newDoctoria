<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Upload_Files;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use Upload_Files;




    public function index()
    {


        $settings = Setting::firstOrNew();
        return view('Admin.CRUDS.settings.index', [
            'settings' => $settings,
        ]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'facebook'=>'nullable',
            'website'=>'nullable',
            'email'=>'nullable',
            'phone'=>'nullable',
            'google'=>'nullable',
            'app_name'=>'nullable',
            'logo_header'=>'nullable|image',
            'facebook_icon'=>'nullable|image',
            'website_icon'=>'nullable|image',
            'email_icon'=>'nullable|image',
            'phone_icon'=>'nullable|image',
            'google_icon'=>'nullable|image',
            'fave_icon'=>'nullable|image',
            'signature'=>'nullable|image',
            'privacy'=>'nullable|array',
            'privacy.*'=>'nullable|string',
            'about'=>'nullable|array',
            'about.*'=>'nullable|string'


        ],[]);

        if ($request->logo_header)
            $data['logo_header'] =  $this->uploadFiles('settings',$request->file('logo_header'),null );
        if ($request->fave_icon)
            $data['fave_icon'] =  $this->uploadFiles('settings',$request->file('fave_icon'),null );
        if ($request->facebook_icon)
            $data['facebook_icon'] =  $this->uploadFiles('settings',$request->file('facebook_icon'),null );
        if ($request->website_icon)
            $data['website_icon'] =  $this->uploadFiles('settings',$request->file('website_icon'),null );
        if ($request->email_icon)
            $data['email_icon'] =  $this->uploadFiles('settings',$request->file('email_icon'),null );
        if ($request->phone_icon)
            $data['phone_icon'] =  $this->uploadFiles('settings',$request->file('phone_icon'),null );
        if ($request->google_icon)
            $data['google_icon'] =  $this->uploadFiles('settings',$request->file('google_icon'),null );
        if ($request->signature)
            $data['signature'] =  $this->uploadFiles('settings',$request->file('signature'),null );

        Setting::firstOrNew()->update($data);

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!'
            ]);

    }


}
