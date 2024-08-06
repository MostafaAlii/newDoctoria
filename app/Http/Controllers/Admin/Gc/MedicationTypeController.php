<?php

namespace App\Http\Controllers\Admin\Gc;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Gc\MedicationTypeRequest;
use App\Http\Traits\ResponseTrait;
use App\Models\GcMedicationType;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MedicationTypeController extends Controller
{
    //
    use  ResponseTrait;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = GcMedicationType::query()->latest();
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

                ->editColumn('type', function ($row) {
                    return $row->type??'';
                })




                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }
        return view('Admin.Gc.medicationType.index');
    }


    public function create()
    {
        return view('Admin.Gc.medicationType.parts.create');
    }

    public function store(MedicationTypeRequest $request)
    {
        $data = $request->validationData();
        GcMedicationType::create($data);
        return $this->addResponse();

    }


    public function show($id)
    {


        //
    }


    public function edit($id )
    {
        $row=GcMedicationType::findOrFail($id);
        return view('Admin.Gc.medicationType.parts.edit', compact('row'));

    }

    public function update(MedicationTypeRequest $request, $id )
    {
        $row=GcMedicationType::findOrFail($id);
        $data = $request->validationData();
        $row->update($data);
        return $this->updateResponse();
    }


    public function destroy($id)
    {
        $row = GcMedicationType::findOrFail($id);
        $row->delete();
        return $this->deleteResponse();
    }//end fun
}
