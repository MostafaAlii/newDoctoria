<?php

namespace App\Http\Controllers\Admin\Sc;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Sc\ServiceRequest;
use App\Http\Traits\ResponseTrait;
use App\Models\Experience;
use App\Models\ScAddon;
use App\Models\ScService;
use App\Models\ScServiceAddon;
use App\Models\ScType;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ServiceController extends Controller
{
    //
    use  ResponseTrait;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = ScService::query()->latest();
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
                ->editColumn('sc_type_id', function ($row) {

                    return $row->type->name ?? '';

                })

                ->editColumn('experience_id', function ($row) {

                    return $row->experience->name ?? '';

                })

                ->editColumn('name', function ($row) {
                    return $row->name;
                })
                ->editColumn('description', function ($row) {
                    return $row->description;
                })

                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }
        return view('Admin.Sc.service.index');
    }


    public function create()
    {

        $scTypes = ScType::get();

        $scAddons=ScAddon::get();
        $experiences = Experience::get();

        return view('Admin.Sc.service.parts.create', compact('scTypes','experiences','scAddons'));
    }

    public function store(ServiceRequest $request)
    {
        $data = $request->validationData();
        unset($data['addon_id']);
     $service= ScService::create($data);

     foreach ($request->addon_id as $addon_id)
     {
         ScServiceAddon::create([
             'sc_service_id'=>$service->id,
             'sc_addon_id'=>$addon_id,
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
        $row = ScService::findOrFail($id);

        $scTypes = ScType::get();
        $experiences = Experience::get();

        $scAddons=ScAddon::get();

        $addon_ides=ScServiceAddon::where('sc_service_id',$id)->pluck('sc_addon_id')->toArray();


        return view('Admin.Sc.service.parts.edit', compact('row', 'scTypes','experiences','scAddons','addon_ides'));

    }

    public function update(ServiceRequest $request, $id)
    {

        $row = ScService::findOrFail($id);
        $data = $request->validationData();
        unset($data['addon_id']);
        $row->update($data);
        ScServiceAddon::where('sc_service_id',$id)->whereNotIn('sc_addon_id',$request->addon_id)->delete();
        foreach ($request->addon_id as $addon_id)
        {
            ScServiceAddon::updateOrCreate([
                'sc_service_id'=>$id,
                'sc_addon_id'=>$addon_id,
            ]);
        }
        return $this->updateResponse();

    }


    public function destroy($id)
    {
        $row = ScService::findOrFail($id);
        $row->delete();
        return $this->deleteResponse();
    }//end
}
