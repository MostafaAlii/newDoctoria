<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CityRequest;
use App\Http\Traits\ResponseTrait;
use App\Models\City;
use App\Models\Governorate;
use App\Models\Nationality;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CityController extends Controller
{
    //

    use  ResponseTrait;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = City::query()->latest();
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

                ->editColumn('nationality_id', function ($row) {
                    return $row->nationality->name??'';
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
        return view('Admin.CRUDS.city.index');
    }


    public function create()
    {

        $governorates=Governorate::get();


        return view('Admin.CRUDS.city.parts.create',compact('governorates'));
    }

    public function store(CityRequest $request)
    {
        $data = $request->validationData();
        $governorate=Governorate::findOrFail($request->governorate_id);
        $data['nationality_id']=$governorate->nationality_id;
        City::create($data);
        return $this->addResponse();

    }


    public function show($id)
    {


        //
    }


    public function edit($id )
    {


        $row=City::findOrFail($id);

        $governorates=Governorate::get();



        return view('Admin.CRUDS.city.parts.edit', compact('row','governorates'));

    }

    public function update(CityRequest $request, $id )
    {

        $row=City::findOrFail($id);
        $data = $request->validationData();
        $governorate=Governorate::findOrFail($request->governorate_id);
        $data['nationality_id']=$governorate->nationality_id;
        $row->update($data);
        return $this->updateResponse();

    }


    public function destroy($id)
    {
        $row = City::findOrFail($id);

        $row->delete();

        return $this->deleteResponse();
    }//end fun

}
