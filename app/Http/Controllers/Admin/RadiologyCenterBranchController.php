<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RadiologyCenterBranchRequest;
use App\Http\Traits\ResponseTrait;
use App\Models\City;
use App\Models\Governorate;
use App\Models\RadiologyCenter;
use App\Models\RadiologyCenterBranch;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RadiologyCenterBranchController extends Controller
{
    //
    use  ResponseTrait;

    public function index(Request $request)
    {

        $radiology_center=RadiologyCenter::findOrFail($request->radiology_center_id);
        if ($request->ajax()) {
            $admins = RadiologyCenterBranch::query()->where('radiology_center_id',$request->radiology_center_id)->latest();
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
        return view('Admin.CRUDS.radiologyCenterBranch.index',compact('radiology_center'));
    }


    public function create(Request $request)
    {


        $radiology_center=RadiologyCenter::findOrFail($request->radiology_center_id);

        $governorates=Governorate::get();



        return view('Admin.CRUDS.radiologyCenterBranch.parts.create',compact('radiology_center','governorates'));
    }

    public function store(RadiologyCenterBranchRequest $request)
    {
        $data = $request->validationData();


             RadiologyCenterBranch::create($data);


        return $this->addResponse();
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $row = RadiologyCenterBranch::findOrFail($id);

        $governorates=Governorate::get();

        $cities=City::where('governorate_id',$row->governorate_id)->get();




        return view('Admin.CRUDS.radiologyCenterBranch.parts.edit', compact('row','governorates','cities'));

    }

    public function update(RadiologyCenterBranchRequest $request, $id)
    {

        $row = RadiologyCenterBranch::findOrFail($id);
        $data = $request->validationData();

        $row->update($data);

        return $this->updateResponse();

    }


    public function destroy($id)
    {
        $row = RadiologyCenterBranch::findOrFail($id);
        $row->delete();
        return $this->deleteResponse();
    }//end
}
