<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SpecializationRequest;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SubSpecializationController extends Controller
{
    //
    use  ResponseTrait,Upload_Files;

    public function index(Request $request)
    {
        $parent=Specialization::where('parent_id',null)->findOrFail($request->parent_id);

        if ($request->ajax()) {
            $admins = Specialization::query()->where('parent_id',$parent->id)->latest();
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
        return view('Admin.CRUDS.subSpecialization.index',compact('parent'));
    }


    public function create(Request $request)
    {

        $parent=Specialization::where('parent_id',null)->findOrFail($request->parent_id);

        return view('Admin.CRUDS.subSpecialization.parts.create',compact('parent'));
    }

    public function store(SpecializationRequest $request)
    {
        $data = $request->validationData();

        if ($request->image)
            $data["image"] = $this->uploadFiles('specializations', $request->file('image'), null);
        if ($request->icon)
            $data["icon"] = $this->uploadFiles('specializations', $request->file('icon'), null);

        $parent=Specialization::where('parent_id',null)->findOrFail($request->parent_id);

        $data['parent_id']=$parent->id;

        Specialization::create($data);
        return $this->addResponse();
    }


    public function show($id)
    {
        //
    }


    public function edit($id )
    {
        $row=Specialization::findOrFail($id);

        return view('Admin.CRUDS.subSpecialization.parts.edit', compact('row'));

    }

    public function update(SpecializationRequest $request, $id )
    {

        $row=Specialization::findOrFail($id);
        $data = $request->validationData();
        if ($request->image) {
            $data["image"] = $this->uploadFiles('specializations', $request->file('image'), null);

            if (file_exists($row->image)) {
                unlink($row->image);
            }
        }
        if ($request->icon) {

            if (file_exists($row->icon)) {
                unlink($row->icon);
            }
            $data["icon"] = $this->uploadFiles('specializations', $request->file('icon'), null);

        }

        $row->update($data);
        return $this->updateResponse();

    }


    public function destroy($id)
    {
        $row = Specialization::findOrFail($id);

        if (file_exists($row->image)) {
            unlink($row->image);
        }

        $row->delete();

        return $this->deleteResponse();
    }//end fun
}
