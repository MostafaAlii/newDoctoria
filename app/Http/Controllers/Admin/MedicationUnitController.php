<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MedicationUnitExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MedicationUnitRequest;
use App\Http\Traits\ResponseTrait;
use App\Imports\MedicationUnitImport;
use App\Models\MedicationUnit;
use App\Models\MedicationUnitPharmacy;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class MedicationUnitController extends Controller
{
    //
    use  ResponseTrait;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = MedicationUnit::query()->latest();
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

                ->editColumn('unit', function ($row) {
                    return $row->unit??'';
                })




                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }
        return view('Admin.CRUDS.medicationUnit.index');
    }


    public function create()
    {
        return view('Admin.CRUDS.medicationUnit.parts.create');
    }

    public function store(MedicationUnitRequest $request)
    {
        $data = $request->validationData();
        MedicationUnit::create($data);
        return $this->addResponse();

    }


    public function show($id)
    {


        //
    }


    public function edit($id )
    {
        $row=MedicationUnit::findOrFail($id);

        return view('Admin.CRUDS.medicationUnit.parts.edit', compact('row'));

    }

    public function update(MedicationUnitRequest $request, $id )
    {
        $row=MedicationUnit::findOrFail($id);
        $data = $request->validationData();
        $row->update($data);

        return $this->updateResponse();
    }


    public function destroy($id)
    {
        $row = MedicationUnit::findOrFail($id);
        $row->delete();

        return $this->deleteResponse();
    }//end fun

    public function export()
    {
        return Excel::download(new MedicationUnitExport, 'medication_units.xlsx');
    }

    public function import(){
        return view('Admin.CRUDS.medicationUnit.parts.import');
    }

    public function update_import(Request $request){

        $file = $request->file('file');

        Excel::import(new MedicationUnitImport, $request->file('file'));

        return $this->addResponse();
    }
}
