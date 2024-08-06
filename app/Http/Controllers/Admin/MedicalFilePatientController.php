<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MedicalFilePatientRequest;
use App\Http\Traits\ResponseTrait;
use App\Models\Category;
use App\Models\MainService;
use App\Models\MedicalFilePatient;
use App\Models\Patient;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MedicalFilePatientController extends Controller
{
    //
    use  ResponseTrait;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = MedicalFilePatient::query()->latest();
            if ($request->patient_id){
                $admins->where('patient_id',$request->patient_id);
            }
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

                ->editColumn('patient_id', function ($row) {

                    return Patient::find($row->patient_id)->name??'';
                })

                ->editColumn('category_id', function ($row) {
                    return $row->category->name??'';
                })

                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->filter(
                    function ($instance) use ($request) {


                        if ($request->get('category_id') !== null) {
                            $category_id = $request->get('category_id');
                            $instance->where('category_id',$category_id);
                        }


                    }
                )
                ->make(true);


        }
        $medical_file_main_service=MainService::where('slug','medical-file')->first();

        $categories=Category::where('main_service_id',$medical_file_main_service->id)->get();


        return view('Admin.CRUDS.medicalFilePatient.index',compact('categories'));
    }





    public function show($id)
    {


        //
    }


    public function edit($id )
    {
        $row=MedicalFilePatient::findOrFail($id);
        return view('Admin.CRUDS.medicalFilePatient.parts.edit', compact('row'));

    }

    public function update(MedicalFilePatientRequest $request, $id )
    {
        $row=MedicalFilePatient::findOrFail($id);
        $data = $request->validationData();
        $row->update($data);
        return $this->updateResponse();
    }


    public function destroy($id)
    {
        $row = MedicalFilePatient::findOrFail($id);
        $row->delete();
        return $this->deleteResponse();
    }//end fun
}
