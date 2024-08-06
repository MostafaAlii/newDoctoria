<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DoctorRequest;
use App\Http\Requests\Admin\DoctorBranchRequest;
use App\Http\Requests\Admin\ProviderTimeRequest;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Day;
use App\Models\Doctor;
use App\Models\DoctorBranch;
use App\Models\ProviderCategory;
use App\Models\ProviderTime;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DoctorBranchController extends Controller
{
    //
    //
    use  ResponseTrait,Upload_Files;

    public function index(Request $request,$id)
    {
        $doctor = Doctor::find($id);
        if ($request->ajax()) {
            $admins = DoctorBranch::query()->where('doctor_id',$id)->latest();
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
                       ';


                })

        
                ->addColumn('doctor_branches_times', function ($row) {
                    $route=route('admin.doctor_branches_times',$row->id);
                    return "<a href='$route' class='btn btn-outline-primary'>".helperTrans('admin.Doctor Branch Time')."</a>";
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
        return view('Admin.CRUDS.doctorBranch.index', compact('doctor'));
    }


    public function create($id)
    {
        $doctor = Doctor::find($id);
        return view('Admin.CRUDS.doctorBranch.parts.create', compact('doctor'));
    }

    public function store(DoctorBranchRequest $request,$id)
    {
        $doctor_id = Doctor::find($id);
        $data = $request->validationData();
        if ($request->image)
            $data["image"] = $this->uploadFiles('doctors/doctor_branch/'.$doctor_id->id, $request->file('image'), null);

        $data['doctor_id'] = $doctor_id->id;
        $doctor=DoctorBranch::create($data);

        $category_id = Category::where('slug', 'doctor_branch')->first();
        if($category_id == null) {
            $category_id = Category::create([
                'slug'  => 'doctor_branch',
                'name'  => 'doctor_branch',
                'main_service_id'  => 2,
            ]);
        }

        if ($category_id)
            foreach ($category_id as $cat_id)
            {
                ProviderCategory::create([
                    'provider_id'=>$doctor->id,
                    'category_id'=>$category_id->id,
                    'provider_type'=>'doctor_branch',
                ]);
            }


        return $this->addResponse();

    }



    public function edit($id )
    {
        $row=DoctorBranch::findOrFail($id);

        $categoriesIdes=ProviderCategory::where('provider_id',$row->id)->where('provider_type','doctor')->pluck('category_id')->toArray();


        return view('Admin.CRUDS.doctorBranch.parts.edit', compact('row'));

    }

    public function update(DoctorBranchRequest $request, $id )
    {
        $row=DoctorBranch::findOrFail($id);
        $data = $request->validationData();

        if ($request->image)
            $data["image"] = $this->uploadFiles('doctors/doctor_branch/'.$row->doctor->id, $request->file('image'), null);

  
        $row->update($data);

        return $this->updateResponse();
    }


    public function destroy($id)
    {
        $row = DoctorBranch::findOrFail($id);
        $row->delete();
        return $this->deleteResponse();
    }//end fun

    public function doctor_times($id){

        $doctor=DoctorBranch::findOrFail($id);
        $doctorTimes=ProviderTime::where('provider_type','doctor_branch')->where('provider_id',$id)->get();
        $days=Day::get();
        $categoriesIdes=ProviderCategory::where('provider_id',$id)->where('provider_type','doctor_branch')->pluck('category_id')->toArray();
        $categories=Category::whereIn('id',$categoriesIdes)->get();
        return view('Admin.CRUDS.doctorBranch.times',compact('doctor','doctorTimes','days'));

    }


    public function update_doctor_times($id,ProviderTimeRequest $request ){
        $doctor = DoctorBranch::findOrFail($id);
        ProviderTime::where('provider_id',$id)->where('provider_type','doctor_branch')->delete();
        if ($request->day_id)
            for($i=0;$i<count($request->day_id);$i++){

                ProviderTime::create([
                    'provider_id'=>$id,
                    'day_id'=>$request->day_id[$i],
                    'from_time'=>$request->from_time[$i],
                    'to_time'=>$request->to_time[$i],
                    'type'=>'offline',
                    'provider_type'=>'doctor_branch',
                ]);


            }


        return $this->updateResponse();

    }
}
