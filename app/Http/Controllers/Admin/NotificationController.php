<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\Notification;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class NotificationController extends Controller
{
    //
    use  ResponseTrait;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = Notification::query()->latest();
            return DataTables::of($admins)
                ->addColumn('action', function ($admin) {

                    $edit = '';
                    $delete = '';


                    return '

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

                ->editColumn('user_id', function ($row) {
                    if ($row->user_type=='doctor')
                        return $row->doctor->name??'';
                    elseif ($row->user_type=='patient')
                        return $row->patient->name??'';
                    else
                        return  "";
                })

                ->editColumn('is_read', function ($row) {
                   $is_read="<span class='badge bg-success'>".helperTrans('admin.Un Read')."</span>";
                    if ($row->is_read==1)
                   $is_read="<span class='badge bg-danger'>".helperTrans('admin.Read')."</span>";

                    return $is_read;

                })



                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }
        return view('Admin.CRUDS.notification.index');
    }




    public function destroy($id)
    {
        $row = Notification::findOrFail($id);


        $row->delete();

        return $this->deleteResponse();
    }//end fun
}
