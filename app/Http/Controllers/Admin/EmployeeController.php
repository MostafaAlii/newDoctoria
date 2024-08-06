<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmployeeRequest;
use App\Http\Traits\ResponseTrait;
use App\Models\City;
use App\Models\Employee;
use App\Models\Experience;
use App\Models\Type;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    //
    use  ResponseTrait;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = Employee::query()->latest();
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
                ->editColumn('experience_id', function ($row) {
                    return $row->experience->name??'';
                })

                ->editColumn('city_id', function ($row) {
                    return $row->city->name??'';
                })


                ->editColumn('type_id', function ($row) {
                    return $row->type->name??'';
                })




                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }
        return view('Admin.CRUDS.employee.index');
    }


    public function create()
    {
        $cities=City::get();
        $experiences=Experience::get();
        $types=Type::get();
        return view('Admin.CRUDS.employee.parts.create',compact('cities','experiences','types'));
    }

    public function store(EmployeeRequest $request)
    {
        $data = $request->validationData();
        Employee::create($data);
        return $this->addResponse();

    }


    public function show($id)
    {


        //
    }


    public function edit($id )
    {
        $row=Employee::findOrFail($id);
        $cities=City::get();
        $experiences=Experience::get();
        $types=Type::get();
        return view('Admin.CRUDS.employee.parts.edit', compact('row','cities','experiences','types'));

    }

    public function update(EmployeeRequest $request, $id )
    {
        $row=Employee::findOrFail($id);
        $data = $request->validationData();
        $row->update($data);
        return $this->updateResponse();
    }


    public function destroy($id)
    {
        $row = Employee::findOrFail($id);
        $row->delete();
        return $this->deleteResponse();
    }//end fun

}
