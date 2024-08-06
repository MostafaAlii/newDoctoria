<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LaboratorybranchRequest;
use App\Http\Traits\ResponseTrait;
use App\Models\City;
use App\Models\Governorate;
use App\Models\Laboratory;
use App\Models\LaboratoryBranch;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LaboratoryBranchController extends Controller
{
    //
    //
    use  ResponseTrait;

    public function index(Request $request)
    {
        $laboratory=Laboratory::findOrFail($request->laboratory_id);

        if ($request->ajax()) {
            $admins = LaboratoryBranch::query()->where('laboratory_id',$request->laboratory_id)->latest();
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

                ->editColumn('governorate_id', function ($row) {
                    return $row->governorate->name??'';
                })


                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }
        return view('Admin.CRUDS.laboratoryBranch.index',compact('laboratory'));
    }


    public function create(Request $request)
    {

        $laboratory=Laboratory::findOrFail($request->laboratory_id);

        $governorates=Governorate::get();



        return view('Admin.CRUDS.laboratoryBranch.parts.create',compact('laboratory','governorates'));
    }

    public function store(LaboratorybranchRequest $request)
    {
        $data = $request->validationData();


        LaboratoryBranch::create($data);


        return $this->addResponse();

    }


    public function show($id)
    {


        //
    }


    public function edit($id )
    {


        $row=LaboratoryBranch::findOrFail($id);

        $governorates=Governorate::get();
        $cities=City::where('governorate_id',$row->governorate_id)->get();


        return view('Admin.CRUDS.laboratoryBranch.parts.edit', compact('row','cities','governorates'));

    }

    public function update(LaboratorybranchRequest $request, $id )
    {

        $row=LaboratoryBranch::findOrFail($id);
        $data = $request->validationData();
        $row->update($data);

        return $this->updateResponse();

    }


    public function destroy($id)
    {
        $row = LaboratoryBranch::findOrFail($id);


        $row->delete();

        return $this->deleteResponse();
    }//end fun
}
