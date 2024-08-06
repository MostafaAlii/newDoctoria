<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\RequestBooking;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RequestBookController extends Controller
{
    //
    use  ResponseTrait;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = RequestBooking::query()->latest();
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

                ->editColumn('governorate_id', function ($row) {

                    return $row->governorate->name??'';

                })


                ->editColumn('city_id', function ($row) {

                    return $row->city->name??'';

                })


                    ->addColumn('docs', function ($row) {

                    $route=route('admin.request_booking_docs',$row->id);

                    return "<a href='$route' class=''><i class='fa fa-file'></i></a>";

                })





                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }
        return view('Admin.CRUDS.requestBooking.index');
    }




    public function destroy($id)
    {
        $row = RequestBooking::findOrFail($id);

        $row->delete();

        return $this->deleteResponse();
    }//end fun


    public function request_booking_docs($id){

        $row = RequestBooking::with(['docs'])->findOrFail($id);

        return view('Admin.CRUDS.requestBooking.docs',compact('row'));

    }

}
