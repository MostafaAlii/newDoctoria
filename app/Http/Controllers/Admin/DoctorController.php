<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DoctorRequest;
use App\Http\Requests\Admin\ProviderTimeRequest;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Category;
use App\Models\City;
use App\Models\Day;
use App\Models\Doctor;
use App\Models\DoctorUpdate;
use App\Models\DoctorCategory;
use App\Models\Experience;
use App\Models\Governorate;
use App\Models\ProviderCategory;
use App\Models\ProviderTime;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DoctorController extends Controller
{
    //
    //
    use  ResponseTrait,Upload_Files;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = Doctor::query()->latest();
            return DataTables::of($admins)
                ->addColumn('action', function ($admin) {

                    $edit = '';
                    $delete = '';


                    return '
                            <button ' . $edit . '  class="editBtn btn rounded-pill btn-primary waves-effect waves-light"
                                    data-id="' . $admin->id . '"
                            <span class="svg-icon svg-icon-3">
                                <span class="svg-icon svg-icon-3">
                                    <i class="las la-edit"></i>
                                </span>
                            </span>
                            </button>
                            <button ' . $delete . '  class="btn rounded-pill btn-danger waves-effect waves-light delete"
                                    data-id="' . $admin->id . '">
                            <span class="svg-icon svg-icon-3">
                                <span class="svg-icon svg-icon-3">
                                    <i class="las la-trash-alt"></i>
                                </span>
                            </span>
                            </button>
                            <a href="'.route('admin.doctors_branches.index', $admin->id).'" class="btn rounded-pill btn-info waves-effect waves-light">Branches</a>
                       ';


                })


                ->editColumn('specialization_id', function ($row) {
                    return $row->specialization->name??'';
                })


        
                ->addColumn('doctor_times', function ($row) {
                    $route=route('admin.doctor_times',$row->id);
                    return "<a href='$route' class='btn btn-outline-primary'>".helperTrans('admin.Doctor Time')."</a>";


                })
                ->addColumn('update', function ($row) {
                    $doctorUpdate = DoctorUpdate::where('doctor_id', $row->id)->latest()->first();
                    if(isset($doctorUpdate)) {
                        if($doctorUpdate->status == 'pending') {
                            $route=route('admin.update.doctor',$doctorUpdate->id);
                            return '<a href="'.$route.'" class="btn btn-warning ">Show Update</a>';    
                        } elseif($doctorUpdate->status == 'reject') {
                            return '<span class="btn btn-danger">Reject</span>';    
                        } elseif($doctorUpdate->status == 'approved') {
                            return '<span class="btn btn-success">Approved</span>';    
                        }
                    } else {
                        return '<span class="btn btn-info">Not Needed</span>';    
                    }
                })


                ->editColumn('status', function ($row) {
                    $active = '';
                    $operation = '';
                    $operation = '';

                    if ($row->status == 1)
                        $active = 'checked';

                    return '<div class="form-check form-switch">
                               <input ' . $operation . '  class="form-check-input activeBtn" data-id="' . $row->id . ' " type="checkbox" role="switch" id="flexSwitchCheckChecked" ' . $active . '  >
                            </div>';
                })



                    ->editColumn('image', function ($admin) {
                    return '
                              <a data-fancybox="" href="' . get_file($admin->image) . '">
                                <img height="60px" src="' . get_file($admin->image) . '">
                            </a>
                             ';
                })




                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }
        return view('Admin.CRUDS.doctor.index');
    }


    public function create()
    {
        $categories=Category::whereIn('slug', ['doctors', 'visit_doctor', 'consultation'])->get();

        $specializations=Specialization::get();

        $governorates=Governorate::get();
        $experiences=Experience::get();

        return view('Admin.CRUDS.doctor.parts.create',compact('specializations','categories','governorates','experiences'));
    }

    public function store(DoctorRequest $request)
    {
        $data = $request->validationData();
        unset($data['category_id']);
        if ($request->image)
            $data["image"] = $this->uploadFiles('doctors', $request->file('image'), null);

        $data['password'] = bcrypt($request->password);

        $doctor=Doctor::create($data);
        if ($request->category_id)
        foreach ($request->category_id as $category_id)
        {
            ProviderCategory::create([
                'provider_id'=>$doctor->id,
                'category_id'=>$category_id,
                'provider_type'=>'doctor',
            ]);
        }

        return $this->addResponse();

    }


    public function show($id)
    {
        //
    }


    public function edit($id )
    {
        $row=Doctor::findOrFail($id);
        $specializations=Specialization::get();
        $sub_specializations=Specialization::where('parent_id',$row->specialization_id)->get();

        $categories=Category::whereIn('slug', ['doctors', 'visit_doctor', 'consultation'])->get();
        $governorates=Governorate::get();
        $cities=City::where('governorate_id',$row->governorate_id)->get();
        $experiences=Experience::get();


        $categoriesIdes=ProviderCategory::where('provider_id',$row->id)->where('provider_type','doctor')->pluck('category_id')->toArray();


        return view('Admin.CRUDS.doctor.parts.edit', compact('row','specializations','categories','categoriesIdes','governorates','cities','experiences','sub_specializations'));

    }

    public function update(DoctorRequest $request, $id )
    {
        $row=Doctor::findOrFail($id);

        $data = $request->validationData();

        unset($data['category_id']);

        if ($request->image)
            $data["image"] = $this->uploadFiles('doctors', $request->file('image'), null);

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }

        $row->update($data);

       if ($request->category_id) {
           ProviderCategory::where('provider_id',$id)->where('provider_type','doctor')->whereNotIn('category_id',$request->category_id)->delete();
           ProviderTime::where('provider_id',$id)->where('provider_type','doctor')->whereNotIn('category_id',$request->category_id)->delete();

           foreach ($request->category_id as $category_id) {
               ProviderCategory::updateOrCreate([
                   'category_id' => $category_id,
                   'provider_id' => $id,
                   'provider_type'=>'doctor',
               ]);
           }
       }
       else{
           ProviderCategory::where('provider_id',$id)->where('provider_type','doctor')->delete();
           ProviderTime::where('provider_id',$id)->where('provider_type','doctor')->delete();
       }
        return $this->updateResponse();
    }


    public function destroy($id)
    {
        $row = Doctor::findOrFail($id);
        $row->delete();
        return $this->deleteResponse();
    }//end fun

    public function doctor_times($id){

        $doctor=Doctor::findOrFail($id);
        $doctorTimes=ProviderTime::where('provider_type','doctor')->where('provider_id',$id)->get();
        $days=Day::get();
        $categoriesIdes=ProviderCategory::where('provider_id',$id)->where('provider_type','doctor')->pluck('category_id')->toArray();
        $categories=Category::whereIn('id',$categoriesIdes)->get();
        return view('Admin.CRUDS.doctor.times',compact('doctor','doctorTimes','categories','days'));

    }


    public function update_doctor_times($id,ProviderTimeRequest $request ){
        $doctor=Doctor::findOrFail($id);
          ProviderTime::where('provider_id',$id)->where('provider_type','doctor')->delete();
        if ($request->category_id)
            for($i=0;$i<count($request->category_id);$i++){

                ProviderTime::create([
                    'provider_id'=>$id,
                    'category_id'=>$request->category_id[$i],
                    'day_id'=>$request->day_id[$i],
                    'type'=>$request->type[$i],
                    'from_time'=>$request->from_time[$i],
                    'to_time'=>$request->to_time[$i],
                    'provider_type'=>'doctor',
                ]);


            }


        return $this->updateResponse();

    }

    public function get_city_by_governorate(Request $request){

        $governorate=Governorate::findOrFail($request->governorate_id);

        $cities=City::where('governorate_id',$governorate->id)->get();


        return view('Admin.CRUDS.doctor.parts.cities',compact('cities'));


    }

    public function get_sub_specialization(Request $request){
        $specialization=Specialization::findOrFail($request->specialization_id);
        $sub_specializations=Specialization::where('parent_id',$specialization->id)->get();

        return view('Admin.CRUDS.doctor.parts.sub_specializations',compact('sub_specializations'));

    }

    public function activate(Request $request)
    {

        $admin = Doctor::findOrFail($request->id);
        if ($admin->status == true) {
            $admin->status = 0;
            $admin->save();
        } else {
            $admin->status = 1;
            $admin->save();
        }

        return $this->successResponse();
    }//end fun

    public function approved($id) {
        $row=DoctorUpdate::findOrFail($id);
        $specializations=Specialization::get();
        $sub_specializations=Specialization::where('parent_id',$row->specialization_id)->get();
        $categories=Category::get();
        $governorates=Governorate::get();
        $cities=City::where('governorate_id',$row->governorate_id)->get();
        $experiences=Experience::get();
        $categoriesIdes=ProviderCategory::where('provider_id',$row->id)->where('provider_type','doctor')->pluck('category_id')->toArray();
    
        return view('Admin.CRUDS.doctor.parts.update',compact('row','specializations','categories','categoriesIdes','governorates','cities','experiences','sub_specializations'));
    } 

    public function approvedUpdate(Request $request, $id) {
        $row=DoctorUpdate::findOrFail($id);
        if($request->submit == 'Reject') {
            $row->update(['status'=>'reject']);
            session()->flash('success', 'Reject Update Doctor Successfully');
        } else {
            $doctor = Doctor::findOrFail($row->doctor_id);
            $doctor->update([
                'name'                  => $row->name,
                'email'                 => $row->email,
                'image'                 => $row->image,
                'phone'                 => $row->phone,
                'location'              => $row->location,
                'gender'                => $row->gender,
                'nickname'              => $row->nickname,
            ]);
            $row->update(['status'=>'approved']);
            session()->flash('success', 'Approved Update Doctor Successfully');
        }
        return redirect()->route('doctors.index');
    }
}
