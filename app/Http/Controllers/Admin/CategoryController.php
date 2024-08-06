<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Category;
use App\Models\MainService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    //
    use  ResponseTrait,Upload_Files;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = Category::query()->latest();
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

                ->editColumn('icon', function ($admin) {
                    return '
                              <a data-fancybox="" href="' . get_file($admin->icon) . '">
                                <img height="60px" src="' . get_file($admin->icon) . '">
                            </a>
                             ';
                })


                ->editColumn('name', function ($row) {
                    return $row->name;
                })



                ->editColumn('main_service_id', function ($row) {
                    return $row->mainService->name??'';
                })


                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }
        return view('Admin.CRUDS.category.index');
    }


    public function create()
    {

        $mainServices=MainService::get();

        return view('Admin.CRUDS.category.parts.create',compact('mainServices'));
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->validationData();
        if ($request->icon)
            $data["icon"] = $this->uploadFiles('categories', $request->file('icon'), null);

        Category::create($data);
        return $this->addResponse();

    }


    public function show($id)
    {


        //
    }


    public function edit($id )
    {


        $row=Category::findOrFail($id);

        $mainServices=MainService::get();



        return view('Admin.CRUDS.category.parts.edit', compact('row','mainServices'));

    }

    public function update(CategoryRequest $request, $id )
    {

        $row=Category::findOrFail($id);
        $data = $request->validationData();
        if ($request->icon)
            $data["icon"] = $this->uploadFiles('categories', $request->file('icon'), null);

        $row->update($data);

        return $this->updateResponse();


    }


    public function destroy($id)
    {
        $row = Category::findOrFail($id);

        $row->delete();

        return $this->deleteResponse();
    }//end fun

}
