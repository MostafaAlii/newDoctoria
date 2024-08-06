<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\Booking;
use App\Models\Notification;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BookingController extends Controller
{
    //
    use  ResponseTrait;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = Booking::query()->latest();
               if ($request->date){
                   $admins->where('day',$request->date);
               }
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

                ->editColumn('patient_id', function ($row) {
                    return $row->patient->name??'';
                })

                ->editColumn('status', function ($row) {
                    $status='';
                     if ($row->status=='pending')
                         $status="<span class='badge bg-primary'>".helperTrans('admin.Pending')."</span>";
                     elseif ($row->status=='active')
                         $status="<span class='badge bg-success'>".helperTrans('admin.active with Dr')." </br>".$row->doctor->name??''." </span>";
                         elseif ($row->status=='complete')
                             $status="<span></span>";
                         return $status;
                })

                ->editColumn('price', function ($row) {

                    $price=$row->price;
                    if ($row->operation_type=='package')
                        $price='<span class="badge bg-secondary">'.helperTrans('admin.Package').'</span>';

                    return $price;

                })


                ->addColumn('docs', function ($row) {

                    $route=route('admin.booking_docs',$row->id);

                    return "<a href='$route' class=''><i class='fa fa-file'></i></a>";

                })



                    ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }
        return view('Admin.CRUDS.booking.index');
    }




    public function destroy($id)
    {
        $row = Booking::findOrFail($id);

        Notification::where('type','booking')->where('foreign_id',$id)->delete();

        $row->delete();

        return $this->deleteResponse();
    }//end fun

    public function booking_docs($id){

        $row = Booking::with(['docs'])->findOrFail($id);

        return view('Admin.CRUDS.booking.docs',compact('row'));

    }

}
