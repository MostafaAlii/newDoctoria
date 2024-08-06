<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PharmacyExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PharmacyRequest;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\Upload_Files;
use App\Imports\PharmacyImport;
use App\Models\Category;
use App\Models\Pharmacy;
use App\Models\ProviderCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class PharmacyController extends Controller
{
    //
    use  ResponseTrait,Upload_Files;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = Pharmacy::query()->latest();
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

                ->addColumn('pharmacy_branches', function ($row) {
                    $route=route('pharmacy_branches.index').'?pharmacy_id='.$row->id;
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
        return view('Admin.CRUDS.pharmacy.index');
    }


    public function create()
    {

        $categories=Category::get();


        return view('Admin.CRUDS.pharmacy.parts.create',compact('categories'));
    }

    public function store(PharmacyRequest $request)
    {
        $data = $request->validationData();
        unset($data['category_id']);

        if ($request->image)
            $data["image"] = $this->uploadFiles('pharmacies', $request->file('image'), null);

        $pharmacy=Pharmacy::create($data);

        if ($request->category_id)
            foreach ($request->category_id as $category_id)
            {
                ProviderCategory::create([
                    'provider_id'=>$pharmacy->id,
                    'category_id'=>$category_id,
                    'provider_type'=>'pharmacy',
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


        $row=Pharmacy::findOrFail($id);

        $categories=Category::get();
        $categoriesIdes=ProviderCategory::where('provider_id',$row->id)->where('provider_type','pharmacy')->pluck('category_id')->toArray();





        return view('Admin.CRUDS.pharmacy.parts.edit', compact('row','categories','categoriesIdes'));

    }

    public function update(PharmacyRequest $request, $id )
    {

        $row=Pharmacy::findOrFail($id);
        $data = $request->validationData();
        unset($data['category_id']);

        if ($request->image)
            $data["image"] = $this->uploadFiles('pharmacies', $request->file('image'), $row->image);

        $row->update($data);

        if ($request->category_id) {
            ProviderCategory::where('provider_id',$id)->where('provider_type','pharmacy')->whereNotIn('category_id',$request->category_id)->delete();

            foreach ($request->category_id as $category_id) {
                ProviderCategory::updateOrCreate([
                    'category_id' => $category_id,
                    'provider_id' => $id,
                    'provider_type'=>'pharmacy',
                ]);
            }
        }
        else{
            ProviderCategory::where('provider_id',$id)->where('provider_type','pharmacy')->delete();
        }
        return $this->updateResponse();

    }


    public function destroy($id)
    {
        $row = Pharmacy::findOrFail($id);

        if (file_exists($row->image)) {
            unlink($row->image);
        }

        $row->delete();

        return $this->deleteResponse();
    }//end fun


    public function export()
    {
        return Excel::download(new PharmacyExport, 'pharmacies.xlsx');
    }

    public function import(){
        return view('Admin.CRUDS.pharmacy.parts.import');
    }

    public function update_import(Request $request){

        $file = $request->file('file');

        Excel::import(new PharmacyImport, $request->file('file'));

        return $this->addResponse();
    }
}
