<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SliderRequest;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Slider;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SliderController extends Controller
{

    use  ResponseTrait,Upload_Files;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = Slider::query()->latest();
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

                ->editColumn('image', function ($admin) {
                    return '
                            <a data-fancybox="" href="' . get_file($admin->image) . '">
                                <img height="60px" src="' . get_file($admin->image) . '">
                            </a>
                             ';
                })
                ->editColumn('name', function ($row) {

                    return $row->name ?? '';

                })

                ->editColumn('desc', function ($row) {

                    return $row->desc ?? '';

                })



                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }
        return view('Admin.CRUDS.slider.index');
    }


    public function create()
    {

        return view('Admin.CRUDS.slider.parts.create');
    }

    public function store(SliderRequest $request)
    {
        $data = $request->validationData();
        if ($request->image)
            $data["image"] = $this->uploadFiles('sliders', $request->file('image'), null);

        Slider::create($data);


        return $this->addResponse();
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $row = Slider::findOrFail($id);


        return view('Admin.CRUDS.slider.parts.edit', compact('row'));

    }

    public function update(SliderRequest $request, $id)
    {
        $data = $request->validationData();

        if ($request->image)
            $data["image"] = $this->uploadFiles('sliders', $request->file('image'), null);

        $row = Slider::findOrFail($id);

        $row->update($data);

        return $this->updateResponse();

    }


    public function destroy($id)
    {
        $row = Slider::findOrFail($id);
        $row->delete();
        return $this->deleteResponse();
    }//end
}
