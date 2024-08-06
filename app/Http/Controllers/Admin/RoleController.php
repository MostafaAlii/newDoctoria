<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Requests\Admin\RoleRequest;

class RoleController extends Controller
{
    use Upload_Files, ResponseTrait;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = Role::whereNotIn('name', ['super_admin'])->withCount(['users']);
            return Datatables::of($admins)
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
                    
                ->editColumn('count', function ($row) {
                    return $row->users()->count();
                })
                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }
        return view('Admin.CRUDS.role.index');
    }


    public function create()
    {


        return view('Admin.CRUDS.role.parts.create');
    }

    public function store(RoleRequest $request)
    {
        $role = Role::create($request->only(['name']));
        $role->givePermissions($request->permissions);

        session()->flash('success', __('site.added_successfully'));

        return $this->addResponse();

    }

    public function show() {

    }


    public function edit(Role $role)
    {




        return view('Admin.CRUDS.role.parts.edit', compact('role'));

    }

    public function update(RoleRequest $request, Role $role)
    {

        $role->update($request->only(['name']));
        $role->syncPermissions($request->permissions);

        session()->flash('success', __('site.updated_successfully'));

        return $this->updateResponse();
    }


    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return $this->deleteResponse();
    }//end fun


}//end class
