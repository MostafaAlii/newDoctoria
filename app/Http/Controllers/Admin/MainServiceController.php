<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MainServiceRequest;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\Upload_Files;
use App\Models\MainService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MainServiceController extends Controller
{
    //
    use  ResponseTrait,Upload_Files;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = MainService::query()->latest();
            return DataTables::of($admins)
                ->addColumn('action', function ($admin) {

                    $edit = '';


                    return '
                            <button ' . $edit . '  class="editBtn btn rounded-pill btn-primary waves-effect waves-light"
                                    data-id="' . $admin->id . '"
                            <span class="svg-icon svg-icon-3">
                                <span class="svg-icon svg-icon-3">
                                    <i class="las la-edit"></i>
                                </span>
                            </span>
                            </button>

                       ';


                })


                ->editColumn('name', function ($row) {
                    return $row->name;
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
        return view('Admin.CRUDS.mainServices.index');
    }




    public function edit($id )
    {


        $row=MainService::findOrFail($id);



        return view('Admin.CRUDS.mainServices.parts.edit', compact('row'));

    }

    public function update(MainServiceRequest $request, $id )
    {

        $row=MainService::findOrFail($id);
        $data = $request->validationData();
        if ($request->image)
            $data["image"] = $this->uploadFiles('main_services', $request->file('image'), null);
        $row->update($data);
        return $this->updateResponse();

    }



}
