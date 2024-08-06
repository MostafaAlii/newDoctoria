<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AnalysisExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AnalysisRequest;
use App\Http\Traits\ResponseTrait;
use App\Imports\AnalysisImport;
use App\Models\Analysis;
use App\Models\Laboratory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class AnalysisController extends Controller
{
    //
    use  ResponseTrait;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = Analysis::query()->latest();
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

                ->editColumn('laboratory_id', function ($row) {
                    return $row->laboratory->name??'';
                })

                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }
        return view('Admin.CRUDS.analysis.index');
    }


    public function create()
    {

        $laboratories=Laboratory::get();
        return view('Admin.CRUDS.analysis.parts.create',compact('laboratories'));
    }

    public function store(AnalysisRequest $request)
    {
        $data = $request->validationData();

        Analysis::create($data);
        return $this->addResponse();

    }


    public function show($id)
    {


        //
    }


    public function edit($id )
    {


        $row=Analysis::findOrFail($id);
        $laboratories=Laboratory::get();



        return view('Admin.CRUDS.analysis.parts.edit', compact('row','laboratories'));

    }

    public function update(AnalysisRequest $request, $id )
    {

        $row=Analysis::findOrFail($id);
        $data = $request->validationData();
        $row->update($data);
        return $this->updateResponse();

    }


    public function destroy($id)
    {
        $row = Analysis::findOrFail($id);
        $row->delete();
        return $this->deleteResponse();
    }//end fun

    public function export()
    {
        return Excel::download(new AnalysisExport, 'analysis.xlsx');
    }

    public function import(){
        return view('Admin.CRUDS.analysis.parts.import');
    }

    public function update_import(Request $request){

        $file = $request->file('file');

        Excel::import(new AnalysisImport, $request->file('file'));
        return $this->addResponse();
    }

}
