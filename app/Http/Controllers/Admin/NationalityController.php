<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NationalityRequest;
use App\Http\Traits\ResponseTrait;
use App\Models\Nationality;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class NationalityController extends Controller
{
    //
    use  ResponseTrait;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = Nationality::query()->latest();
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

                ->editColumn('country_name', function ($row) {
                    return $row->country_name;
                })

                ->editColumn('nickname', function ($row) {
                   return $row->nickname;
                })


                    ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }
        return view('Admin.CRUDS.nationality.index');
    }


    public function create()
    {


        return view('Admin.CRUDS.nationality.parts.create');
    }

    public function store(NationalityRequest $request)
    {
        $data = $request->validationData();
        Nationality::create($data);
        return $this->addResponse();

    }


    public function show($id)
    {


        //
    }


    public function edit($id )
    {


        $row=Nationality::findOrFail($id);


        return view('Admin.CRUDS.nationality.parts.edit', compact('row'));

    }

    public function update(NationalityRequest $request, $id )
    {

        $row=Nationality::findOrFail($id);
        $data = $request->validationData();
        $row->update($data);

        return $this->updateResponse();


    }


    public function destroy($id)
    {
        $row = Nationality::findOrFail($id);

        $row->delete();

        return $this->deleteResponse();
    }//end fun

}
