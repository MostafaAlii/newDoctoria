<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PackageRequest;
use App\Http\Traits\ResponseTrait;
use App\Models\MainService;
use App\Models\MainServicePackage;
use App\Models\Package;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PackageController extends Controller
{
    //
    use  ResponseTrait;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = Package::query()->latest();
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
                    return $row->name??'';
                })


                ->editColumn('gc_specialization_id', function ($row) {
                    return $row->specialization->name??'';
                })




                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }
        $mainServices=MainService::get();

        return view('Admin.CRUDS.package.index',compact('mainServices'));
    }


    public function create()
    {
        $mainServices=MainService::get();
        return view('Admin.CRUDS.package.parts.create',compact('mainServices'));
    }

    public function store(PackageRequest $request)
    {
        $data = $request->validationData();
        unset($data['count']);
        unset($data['main_service_id']);
       $package= Package::create($data);
       if ($request->main_service_id)
           for($i=0;$i<count($request->main_service_id);$i++){
               MainServicePackage::create([
                   'package_id'=>$package->id,
                   'main_service_id'=>$request->main_service_id[$i],
                   'count'=>$request->count[$i],
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
        $row=Package::findOrFail($id);
        $mainServices=MainService::get();
        $packageMainServices=MainServicePackage::where('package_id',$id)->get();

        return view('Admin.CRUDS.package.parts.edit', compact('row','mainServices','packageMainServices'));

    }

    public function update(PackageRequest $request, $id )
    {
        $row=Package::findOrFail($id);
        $data = $request->validationData();
        unset($data['count']);
        unset($data['main_service_id']);
        $row->update($data);

        if ($request->main_service_id) {
            MainServicePackage::where('package_id',$id)->delete();

            for ($i = 0; $i < count($request->main_service_id); $i++) {
                MainServicePackage::updateOrCreate([
                    'package_id' => $id,
                    'main_service_id' => $request->main_service_id[$i],
                    'count' => $request->count[$i],
                ]);
            }

        }
        else{
            MainServicePackage::where('package_id',$id)->delete();
        }
        return $this->updateResponse();
    }


    public function destroy($id)
    {
        $row = Package::findOrFail($id);
        $row->delete();
        return $this->deleteResponse();
    }//end fun

}
