<?php

namespace App\Http\Controllers\Admin\Sc;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Sc\SymptomRequest;
use App\Http\Traits\ResponseTrait;
use App\Models\ScSymptom;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SymptomController extends Controller
{
    //
    use  ResponseTrait;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = ScSymptom::query()->latest();
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
        return view('Admin.Sc.symptom.index');
    }


    public function create()
    {


        return view('Admin.Sc.symptom.parts.create');
    }

    public function store(SymptomRequest $request)
    {
        $data = $request->validationData();

        ScSymptom::create($data);
        return $this->addResponse();
    }


    public function show($id)
    {
        //
    }


    public function edit($id )
    {
        $row=ScSymptom::findOrFail($id);

        return view('Admin.Sc.symptom.parts.edit', compact('row'));

    }

    public function update(SymptomRequest $request, $id )
    {

        $row=ScSymptom::findOrFail($id);
        $data = $request->validationData();

        $row->update($data);
        return $this->updateResponse();

    }


    public function destroy($id)
    {
        $row = ScSymptom::findOrFail($id);

        $row->delete();

        return $this->deleteResponse();
    }//end

}
