<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProviderRequest;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Provider;
use App\Models\ProviderType;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProviderController extends Controller
{
    //
    use  ResponseTrait,Upload_Files;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = Provider::query()->latest();
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
        return view('Admin.CRUDS.provider.index');
    }


    public function create()
    {

        $provider_types = ProviderType::get();

        return view('Admin.CRUDS.provider.parts.create', compact('provider_types'));
    }

    public function store(ProviderRequest $request)
    {
        $data = $request->validationData();

        if ($request->image)
            $data["image"] = $this->uploadFiles('providers', $request->file('image'), null);

        Provider::create($data);


        return $this->addResponse();

    }


    public function show($id)
    {


        //
    }


    public function edit($id )
    {

        $provider_types = ProviderType::get();
        $row=Provider::findOrFail($id);

        return view('Admin.CRUDS.provider.parts.edit', compact('row', 'provider_types'));

    }

    public function update(ProviderRequest $request, $id )
    {

        $row=Provider::findOrFail($id);
        $data = $request->validationData();

        if ($request->image)
            $data["image"] = $this->uploadFiles('providers', $request->file('image'), $row->image);

        $row->update($data);


        return $this->updateResponse();

    }


    public function destroy($id)
    {
        $row = Provider::findOrFail($id);

        if (file_exists($row->image)) {
            unlink($row->image);
        }

        $row->delete();

        return $this->deleteResponse();
    }//end fun


}
