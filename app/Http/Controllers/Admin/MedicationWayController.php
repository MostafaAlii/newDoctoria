<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MedicationWayRequest;
use App\Http\Traits\ResponseTrait;
use App\Models\MedicationWay;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MedicationWayController extends Controller
{
    use  ResponseTrait;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = MedicationWay::query()->latest();
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

                ->editColumn('way', function ($row) {
                    return $row->way??'';
                })




                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }
        return view('Admin.CRUDS.medicationWay.index');
    }


    public function create()
    {
        return view('Admin.CRUDS.medicationWay.parts.create');
    }

    public function store(MedicationWayRequest $request)
    {
        $data = $request->validationData();
        MedicationWay::create($data);
        return $this->addResponse();
    }


    public function show($id)
    {


        //
    }


    public function edit($id )
    {
        $row=MedicationWay::findOrFail($id);
        return view('Admin.CRUDS.medicationWay.parts.edit', compact('row'));

    }

    public function update(MedicationWayRequest $request, $id )
    {
        $row=MedicationWay::findOrFail($id);
        $data = $request->validationData();
        $row->update($data);
        return $this->updateResponse();
    }


    public function destroy($id)
    {
        $row = MedicationWay::findOrFail($id);
        $row->delete();
        return $this->deleteResponse();
    }//end fun
}
