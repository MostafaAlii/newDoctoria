<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LaboratoryExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LaboratoryRequest;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\Upload_Files;
use App\Imports\LaboratoryImport;
use App\Models\Category;
use App\Models\Laboratory;
use App\Models\ProviderCategory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class LaboratoryController extends Controller
{
    //
    use  ResponseTrait,Upload_Files;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = Laboratory::query()->latest();
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


                ->addColumn('laboratory_branches', function ($row) {
                    $route=route('laboratory_branches.index').'?laboratory_id='.$row->id;
                    return "<a href='$route' class='form-control'>".helperTrans('api.Show Branches')."</a>";
                })

                ->editColumn('name', function ($row) {
                    return $row->name;
                })

                ->editColumn('desc', function ($row) {
                    return $row->desc;
                })

                ->editColumn('image', function ($admin) {
                    return '
                              <a data-fancybox="" href="' . get_file($admin->image) . '">
                                <img height="60px" src="' . get_file($admin->image) . '">
                            </a>
                             ';
                })



                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }
        return view('Admin.CRUDS.laboratory.index');
    }


    public function create()
    {

        $categories=Category::get();


        return view('Admin.CRUDS.laboratory.parts.create',compact('categories'));
    }

    public function store(LaboratoryRequest $request)
    {
        $data = $request->validationData();
        unset($data['category_id']);

        if ($request->image)
            $data["image"] = $this->uploadFiles('laboratories', $request->file('image'), null);

         $laboratory=Laboratory::create($data);

        if ($request->category_id)
            foreach ($request->category_id as $category_id)
            {
                ProviderCategory::create([
                    'provider_id'=>$laboratory->id,
                    'category_id'=>$category_id,
                    'provider_type'=>'laboratory',
                ]);
            }


        return $this->addResponse();

    }


    public function show($id)
    {


        //
    }


    public function edit($id )
    {


        $row=Laboratory::findOrFail($id);

        $categories=Category::get();
        $categoriesIdes=ProviderCategory::where('provider_id',$row->id)->where('provider_type','laboratory')->pluck('category_id')->toArray();





        return view('Admin.CRUDS.laboratory.parts.edit', compact('row','categories','categoriesIdes'));

    }

    public function update(LaboratoryRequest $request, $id )
    {

        $row=Laboratory::findOrFail($id);
        $data = $request->validationData();
        unset($data['category_id']);

        if ($request->image)
            $data["image"] = $this->uploadFiles('laboratories', $request->file('image'), $row->image);

        $row->update($data);

        if ($request->category_id) {
            ProviderCategory::where('provider_id',$id)->where('provider_type','laboratory')->whereNotIn('category_id',$request->category_id)->delete();

            foreach ($request->category_id as $category_id) {
                ProviderCategory::updateOrCreate([
                    'category_id' => $category_id,
                    'provider_id' => $id,
                    'provider_type'=>'laboratory',
                ]);
            }
        }
        else{
            ProviderCategory::where('provider_id',$id)->where('provider_type','laboratory')->delete();
        }
        return $this->updateResponse();

    }


    public function destroy($id)
    {
        $row = Laboratory::findOrFail($id);

        if (file_exists($row->image)) {
            unlink($row->image);
        }

        $row->delete();

        return $this->deleteResponse();
    }//end fun

    public function export()
    {
        return Excel::download(new LaboratoryExport, 'laboratories.xlsx');
    }

    public function import(){
        return view('Admin.CRUDS.laboratory.parts.import');
    }

    public function update_import(Request $request){

        $file = $request->file('file');

        Excel::import(new LaboratoryImport, $request->file('file'));

        return $this->addResponse();
    }

}
