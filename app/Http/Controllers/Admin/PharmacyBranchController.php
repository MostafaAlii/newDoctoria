<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PharmacyBranchRequest;
use App\Http\Traits\ResponseTrait;
use App\Models\City;
use App\Models\Governorate;
use App\Models\Pharmacy;
use App\Models\PharmacyBranch;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PharmacyBranchController extends Controller
{
    //
    use  ResponseTrait;

    public function index(Request $request)
    {
        $pharmacy=Pharmacy::findOrFail($request->pharmacy_id);

        if ($request->ajax()) {
            $admins = PharmacyBranch::query()->where('pharmacy_id',$request->pharmacy_id)->latest();
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
        return view('Admin.CRUDS.pharmacyBranch.index',compact('pharmacy'));
    }


    public function create(Request $request)
    {

        $governorates=Governorate::get();
        $pharmacy=Pharmacy::findOrFail($request->pharmacy_id);



        return view('Admin.CRUDS.pharmacyBranch.parts.create',compact('governorates','pharmacy'));
    }

    public function store(PharmacyBranchRequest $request)
    {
        $data = $request->validationData();

        PharmacyBranch::create($data);

        return $this->addResponse();

    }


    public function show($id)
    {


        //
    }


    public function edit($id )
    {


        $row=PharmacyBranch::findOrFail($id);

        $governorates=Governorate::get();
        $cities=City::where('governorate_id',$row->governorate_id)->get();




        return view('Admin.CRUDS.pharmacyBranch.parts.edit', compact('row','governorates','cities'));

    }

    public function update(PharmacyBranchRequest $request, $id )
    {

        $row=PharmacyBranch::findOrFail($id);
        $data = $request->validationData();

        $row->update($data);

        return $this->updateResponse();

    }


    public function destroy($id)
    {
        $row = PharmacyBranch::findOrFail($id);

        $row->delete();

        return $this->deleteResponse();
    }//end fun
}
