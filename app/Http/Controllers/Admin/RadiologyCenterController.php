<?php

namespace App\Http\Controllers\Admin;

use App\Exports\RadiologyCenterExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RadiologyCenterRequest;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\Upload_Files;
use App\Imports\RadiologyCenterImport;
use App\Models\Category;
use App\Models\ProviderCategory;
use App\Models\RadiologyCenter;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class RadiologyCenterController extends Controller
{
    //
    use  ResponseTrait,Upload_Files;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = RadiologyCenter::query()->latest();
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

                    return $row->name ?? '';

                })


                ->addColumn('radiology_center_branches', function ($row) {
                    $route=route('radiology_center_branches.index').'?radiology_center_id='.$row->id;
                    return "<a href='$route' class='form-control'>".helperTrans('api.Show Branches')."</a>";
                })

                ->editColumn('desc', function ($row) {

                    return $row->desc ?? '';

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
        return view('Admin.CRUDS.radiologyCenter.index');
    }


    public function create()
    {

        $categories=Category::get();


        return view('Admin.CRUDS.radiologyCenter.parts.create',compact('categories'));
    }

    public function store(RadiologyCenterRequest $request)
    {
        $data = $request->validationData();

        if ($request->image)
            $data["image"] = $this->uploadFiles('radiology_centers', $request->file('image'), null);

        unset($data['category_id']);

        $row=RadiologyCenter::create($data);

        if ($request->category_id)
            foreach ($request->category_id as $category_id)
            {
                ProviderCategory::create([
                    'provider_id'=>$row->id,
                    'category_id'=>$category_id,
                    'provider_type'=>'radiology_center',
                ]);
            }


        return $this->addResponse();
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $row = RadiologyCenter::findOrFail($id);

        $categories=Category::get();
        $categoriesIdes=ProviderCategory::where('provider_id',$row->id)->where('provider_type','radiology_center')->pluck('category_id')->toArray();



        return view('Admin.CRUDS.radiologyCenter.parts.edit', compact('row','categories','categoriesIdes'));

    }

    public function update(RadiologyCenterRequest $request, $id)
    {

        $row = RadiologyCenter::findOrFail($id);
        $data = $request->validationData();
        if ($request->image)
            $data["image"] = $this->uploadFiles('radiology_centers', $request->file('image'), null);
        unset($data['category_id']);

        $row->update($data);
        if ($request->category_id) {
            ProviderCategory::where('provider_id',$id)->where('provider_type','radiology_center')->whereNotIn('category_id',$request->category_id)->delete();

            foreach ($request->category_id as $category_id) {
                ProviderCategory::updateOrCreate([
                    'category_id' => $category_id,
                    'provider_id' => $id,
                    'provider_type'=>'radiology_center',
                ]);
            }
        }
        else{
            ProviderCategory::where('provider_id',$id)->where('provider_type','radiology_center')->delete();
        }
        return $this->updateResponse();

    }


    public function destroy($id)
    {
        $row = RadiologyCenter::findOrFail($id);
        $row->delete();
        return $this->deleteResponse();
    }//end

    public function export()
    {
        return Excel::download(new RadiologyCenterExport, 'radiology_centers.xlsx');
    }

    public function import(){
        return view('Admin.CRUDS.radiologyCenter.parts.import');
    }

    public function update_import(Request $request){

        $file = $request->file('file');

        Excel::import(new RadiologyCenterImport, $request->file('file'));

        return $this->addResponse();
    }
}
