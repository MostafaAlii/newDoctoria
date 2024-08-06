<?php

namespace App\Http\Controllers\Admin\Gc;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Gc\BloodSugarUnitRequest;
use App\Http\Traits\ResponseTrait;
use App\Models\GcBloodSugarUnit;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BloodSugarUnitController extends Controller
{
    //
    use  ResponseTrait;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = GcBloodSugarUnit::query()->latest();
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
        return view('Admin.Gc.bloodSugarUnit.index');
    }


    public function create()
    {
        return view('Admin.Gc.bloodSugarUnit.parts.create');
    }

    public function store(BloodSugarUnitRequest $request)
    {
        $data = $request->validationData();
        GcBloodSugarUnit::create($data);
        return $this->addResponse();

    }


    public function show($id)
    {


        //
    }


    public function edit($id )
    {
        $row=GcBloodSugarUnit::findOrFail($id);
        return view('Admin.Gc.bloodSugarUnit.parts.edit', compact('row'));

    }

    public function update(BloodSugarUnitRequest $request, $id )
    {
        $row=GcBloodSugarUnit::findOrFail($id);
        $data = $request->validationData();
        $row->update($data);
        return $this->updateResponse();
    }


    public function destroy($id)
    {
        $row = GcBloodSugarUnit::findOrFail($id);
        $row->delete();
        return $this->deleteResponse();
    }//end fun
}
