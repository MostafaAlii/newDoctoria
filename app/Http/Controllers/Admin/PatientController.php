<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PatientRequest;
use App\Http\Traits\ResponseTrait;
use App\Models\City;
use App\Models\Nationality;
use App\Models\Patient;
use App\Models\Package;
use App\Models\PatientSubscribe;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PatientController extends Controller
{
    //
    //
    use  ResponseTrait;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = Patient::query()->latest();
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

                ->editColumn('city_id', function ($row) {
                    return $row->city->name??'';
                })

                ->addColumn('medical_data', function ($row) {
                    $medical_file_route=route('medical_file_patients.index').'?patient_id='.$row->id;
                    $medical_bag_route=route('medical_bags.index').'?patient_id='.$row->id;
                  return "

                          <a href='$medical_bag_route' class='btn btn-outline-primary w-100'>Show Medical bags</a>
                           <br>
                          <a href='$medical_file_route' class='btn btn-outline-success w-100 mt-2'>Show Medical Files</a>

                        ";
                })


                ->editColumn('nationality_id', function ($row) {
                    return $row->nationality->name??'';
                })



                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }
        return view('Admin.CRUDS.patient.index');
    }


    public function create()
    {
        $nationalities=Nationality::get();
        $packages=Package::get();

        return view('Admin.CRUDS.patient.parts.create',compact('nationalities', 'packages'));
    }

    public function store(PatientRequest $request)
    {
        $data = $request->validationData();
        $data['password'] = bcrypt($request->password);
        $patient = Patient::create($data);
        if($request->package_id) {
            PatientSubscribe::create([
                'package_id'=>$request->package_id,
                'patient_id'=>$patient->id,
                'status'=>'active',
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
        $row=Patient::findOrFail($id);
        $cities=City::where('nationality_id',$row->nationality_id)->get();
        $nationalities=Nationality::get();
        $packages=Package::get();
   
        return view('Admin.CRUDS.patient.parts.edit', compact('row','cities','nationalities', 'packages'));

    }

    public function update(PatientRequest $request, $id )
    {
        $row=Patient::findOrFail($id);
        $data = $request->validationData();
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        } else {
             unset($data['password']);
        }
        $row->update($data);
        if($request->package_id) {
            $package = PatientSubscribe::where('patient_id',$row->id)->first();
            if($package) {
                $package->delete();
            }
            PatientSubscribe::create([
                'package_id'=>$request->package_id,
                'patient_id'=>$row->id,
                'status'=>'active',
            ]);    
        }
        return $this->updateResponse();
    }


    public function destroy($id)
    {
        $row = Patient::findOrFail($id);
        $row->delete();
        return $this->deleteResponse();
    }//end fun


    public function getCityByNationality(Request $request){

        $nationality=Nationality::findOrFail($request->nationality_id);

        $cities=City::where('nationality_id',$nationality->id)->get();

        return view('Admin.CRUDS.patient.parts.cities',compact('cities'));

    }

}
