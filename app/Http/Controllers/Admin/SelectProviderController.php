<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SelectProviderRequest;
use App\Http\Traits\ResponseTrait;
use App\Models\SelectProvider;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SelectProviderController extends Controller
{
    //
    use  ResponseTrait;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = SelectProvider::query()->latest();
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

                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }
        return view('Admin.CRUDS.selectProvider.index');
    }


    public function create()
    {


        return view('Admin.CRUDS.selectProvider.parts.create');
    }

    public function store(SelectProviderRequest $request)
    {
        $data = $request->validationData();
        SelectProvider::create($data);
        return $this->addResponse();

    }


    public function show($id)
    {


        //
    }


    public function edit($id )
    {


        $row=SelectProvider::findOrFail($id);




        return view('Admin.CRUDS.selectProvider.parts.edit', compact('row'));

    }

    public function update(SelectProviderRequest $request, $id )
    {

        $row=SelectProvider::findOrFail($id);
        $data = $request->validationData();
        $row->update($data);
        return $this->updateResponse();

    }


    public function destroy($id)
    {
        $row = SelectProvider::findOrFail($id);

        $row->delete();

        return $this->deleteResponse();
    }//end fun
}
