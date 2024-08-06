<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\PatientSubscribe;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PatientSubscribeController extends Controller
{
    //
    use  ResponseTrait;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = PatientSubscribe::query()->latest();
            return DataTables::of($admins)
                ->addColumn('action', function ($admin) {

                    $edit = '';
                    $delete = '';


                    return '

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


                ->editColumn('status', function ($row) {

                    if ($row->status=='active')
                        return "<span class='badge bg-success'>".helperTrans('admin.Active')."</span>";

                    elseif ($row->status=='expire')
                        return "<span class='badge bg-danger'>".helperTrans('admin.Expire')."</span>";
                    else
                        return  null;
                })


                ->editColumn('patient_id', function ($row) {

                    return $row->patient->name??'';

                })


                ->editColumn('package_id', function ($row) {
                    return $row->package->name??'';
                })




                    ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }
        return view('Admin.CRUDS.patientSubscribe.index');
    }




    public function destroy($id)
    {
        $row = PatientSubscribe::findOrFail($id);

        $row->delete();

        return $this->deleteResponse();
    }//end fun
}
