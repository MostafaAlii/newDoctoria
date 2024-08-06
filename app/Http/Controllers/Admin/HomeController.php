<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\NotificationFirebaseTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Admin;

use App\Models\Analysis;
use App\Models\Booking;
use App\Models\Doctor;
use App\Models\Laboratory;
use App\Models\Language;
use App\Models\MedicalBagPatient;
use App\Models\MedicalFilePatient;
use App\Models\Patient;
use App\Models\PatientSubscribe;
use Illuminate\Http\Request;
use TomatoPHP\LaravelAgora\Services\Token\AccessToken;

class HomeController extends Controller
{
    use Upload_Files,NotificationFirebaseTrait;

    public function index()
    {

        $admins=Admin::count();
        $languages=Language::where('status',true)->count();
        $medical_bags=MedicalBagPatient::count();
        $medical_files=MedicalFilePatient::count();
        $doctors=Doctor::count();
        $patients=Patient::count();
        $laboratories=Laboratory::count();
        $analysis=Analysis::count();

        return view('Admin.home.index',compact('admins','analysis','laboratories','patients','doctors','medical_files','medical_bags','languages'));
    }//end fun



    public function calender(Request $request)
    {
        $arrResult =[];
        $orders = Booking::get();
        //get count of orders by days
        foreach ($orders as $row) {
            $date = date('Y-m-d', strtotime($row->created_at));
            if (isset($arrResult[$date])) {
                $arrResult[$date]["counter"] += 1;
                $arrResult[$date]["id"][]  = $row->id;
            } else {
                $arrResult[$date]["counter"] = 1;
                $arrResult[$date]["id"][]  = $row->id;

            }
        }
        //  dd($arrResult);
        //make format of calender
        $Events = [];
        if (count($arrResult)>0) {
            $i = 0;
            foreach ($arrResult as $item => $value) {
                $title= $value['counter'];
                $Events[$i] = array(
                    'id' => $i,
                    'title' => $title,
                    'start' => $item,
                    'ids' => $value['id'],
                );
                $i++;
            }
        }
        //return to calender
        return $Events ;
    }//end fun






    public function requests_calenders(){
      return view('Admin.requests.calenders.index');
    }




}//end clas
