<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SolutionPriorityRequest;
use App\Http\Traits\ResponseTrait;
use App\Models\SolutionPriority;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SolutionPriorityController extends Controller
{
    //
    use  ResponseTrait;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = SolutionPriority::query()->latest();
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

                ->editColumn('value', function ($row) {

                    return $row->value??'';

                })


                    ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }
        return view('Admin.CRUDS.solutionPriority.index');
    }


    public function create()
    {
        return view('Admin.CRUDS.solutionPriority.parts.create');
    }

    public function store(SolutionPriorityRequest $request)
    {
        $data = $request->validationData();
        SolutionPriority::create($data);
        return $this->addResponse();
    }


    public function show($id)
    {


        //
    }


    public function edit($id )
    {
        $row=SolutionPriority::findOrFail($id);
        return view('Admin.CRUDS.solutionPriority.parts.edit', compact('row'));

    }

    public function update(SolutionPriorityRequest $request, $id )
    {
        $row=SolutionPriority::findOrFail($id);
        $data = $request->validationData();
        $row->update($data);
        return $this->updateResponse();
    }


    public function destroy($id)
    {
        $row = SolutionPriority::findOrFail($id);
        $row->delete();
        return $this->deleteResponse();
    }//end fun
}
