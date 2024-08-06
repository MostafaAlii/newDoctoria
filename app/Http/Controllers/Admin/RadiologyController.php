<?php

namespace App\Http\Controllers\Admin;

use App\Exports\RadiologyExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RadiologyReequest;
use App\Http\Traits\ResponseTrait;
use App\Imports\RadiologyImport;
use App\Models\Radiology;
use App\Models\RadiologyCenter;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class RadiologyController extends Controller
{
    //
    use  ResponseTrait;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = Radiology::query()->latest();
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

                ->editColumn('name', function ($row) {
                    return $row->name;
                })

                ->editColumn('radiology_center_id', function ($row) {
                    return $row->radiologyCenter->name??'';
                })

                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }
        return view('Admin.CRUDS.radiology.index');
    }


    public function create()
    {

        $radiology_centers=RadiologyCenter::get();
        return view('Admin.CRUDS.radiology.parts.create',compact('radiology_centers'));
    }

    public function store(RadiologyReequest $request)
    {
        $data = $request->validationData();

        Radiology::create($data);
        return $this->addResponse();

    }


    public function show($id)
    {


        //
    }


    public function edit($id )
    {


        $row=Radiology::findOrFail($id);
        $radiology_centers=RadiologyCenter::get();



        return view('Admin.CRUDS.radiology.parts.edit', compact('row','radiology_centers'));

    }

    public function update(RadiologyReequest $request, $id )
    {

        $row=Radiology::findOrFail($id);
        $data = $request->validationData();
        $row->update($data);
        return $this->updateResponse();

    }


    public function destroy($id)
    {
        $row = Radiology::findOrFail($id);


        $row->delete();

        return $this->deleteResponse();
    }//end fun


    public function export()
    {
        return Excel::download(new RadiologyExport, 'radiology.xlsx');
    }

    public function import(){
        return view('Admin.CRUDS.radiology.parts.import');
    }

    public function update_import(Request $request){

        $file = $request->file('file');

        Excel::import(new RadiologyImport, $request->file('file'));
        return $this->addResponse();
    }

}
