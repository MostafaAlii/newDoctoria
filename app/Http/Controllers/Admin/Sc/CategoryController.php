<?php

namespace App\Http\Controllers\Admin\Sc;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Sc\CategoryRequest;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\Upload_Files;
use App\Models\MainService;
use App\Models\ScCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    //
    use  ResponseTrait,Upload_Files;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = ScCategory::query()->latest();
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
                ->editColumn('main_service_id', function ($row) {

                    return $row->mainService->name??'';

                })

                ->editColumn('name', function ($row) {
                    return $row->name;
                })

                ->editColumn('details', function ($row) {
                    return $row->details;
                })

                ->editColumn('color', function ($row) {
                    return '
                    <span style="width:50px ; height: 50px ;border-radius: 100% ; display: block ; background-color: '.$row->color.' "></span>
                    ';
                })

                ->editColumn('image', function ($admin) {
                    return '
                              <a data-fancybox="" href="' . get_file($admin->image) . '">
                                <img height="60px" src="' . get_file($admin->image) . '">
                            </a>
                             ';
                })


                ->editColumn('icon', function ($admin) {
                    return '
                              <a data-fancybox="" href="' . get_file($admin->icon) . '">
                                <img height="60px" src="' . get_file($admin->icon) . '">
                            </a>
                             ';
                })

                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }
        return view('Admin.Sc.category.index');
    }


    public function create()
    {

        $mainServices=MainService::get();

        return view('Admin.Sc.category.parts.create',compact('mainServices'));
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->validationData();

        if ($request->image)
            $data["image"] = $this->uploadFiles('sc_categories', $request->file('image'), null);
        if ($request->icon)
            $data["icon"] = $this->uploadFiles('sc_categories', $request->file('icon'), null);

        ScCategory::create($data);
        return $this->addResponse();
    }


    public function show($id)
    {
        //
    }


    public function edit($id )
    {
        $row=ScCategory::findOrFail($id);

        $mainServices=MainService::get();


        return view('Admin.Sc.category.parts.edit', compact('row','mainServices'));

    }

    public function update(CategoryRequest $request, $id )
    {

        $row=ScCategory::findOrFail($id);
        $data = $request->validationData();
        if ($request->image) {
            $data["image"] = $this->uploadFiles('sc_categories', $request->file('image'), null);

            if (file_exists($row->image)) {
                unlink($row->image);
            }
        }
        if ($request->icon) {

            if (file_exists($row->icon)) {
                unlink($row->icon);
            }
            $data["icon"] = $this->uploadFiles('sc_categories', $request->file('icon'), null);

        }

        $row->update($data);
        return $this->updateResponse();

    }


    public function destroy($id)
    {
        $row = ScCategory::findOrFail($id);

        if (file_exists($row->image)) {
            unlink($row->image);
        }

        if (file_exists($row->icon)) {
            unlink($row->icon);
        }

        $row->delete();

        return $this->deleteResponse();
    }//end
}
