<?php
namespace App\Http\Controllers\Admin\GeneralMainSetting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseTrait;
use App\Models\MainOtpProvider;
use Yajra\DataTables\DataTables;
class MainOtpController extends Controller {
    use  ResponseTrait;
    public function index(Request $request) {
        if ($request->ajax()) {
            $mainOtpProviders = MainOtpProvider::query()->latest();
            return DataTables::of($mainOtpProviders)
                ->addColumn('action', function ($mainOtpProvider) {
                    $delete = '';
                    return '
                            <button ' . $delete . '  class="btn rounded-pill btn-danger waves-effect waves-light delete"
                                    data-id="' . $mainOtpProvider->id . '">
                            <span class="svg-icon svg-icon-3">
                                <span class="svg-icon svg-icon-3">
                                    <i class="las la-trash-alt"></i>
                                </span>
                            </span>
                            </button>
                       ';
                })
                ->editColumn('status', function ($mainOtpProvider) {
                    $status = $mainOtpProvider->status;
                    $badgeClass = $status === 'Active' ? 'badge-success' : 'badge-danger';
                    return '<span class="badge ' . $badgeClass . '">' . $status . '</span>';
                })
                ->editColumn('created_at', function ($mainOtpProvider) {
                    return date('Y/m/d', strtotime($mainOtpProvider->created_at));
                })
                ->escapeColumns([])
                ->make(true);
        }
        return view('Admin.CRUDS.main_otp.index');
    }

    public function store(Request $request) {
        try {
            $this->validate($request, [
                'name' => 'required',
                'status' => 'required',
            ]);
            $data = $request->except('_token');
            MainOtpProvider::create($data);
            return $this->addResponse('Main OTP Provider created successfully.');
        } catch (\Exception $e) {
            return $this->returnError('An error occurred while creating the Main OTP Provider. Please try again later.', 500);
        }
    }

    public function update(Request $request, $id )
    {

        $row=MainOtpProvider::findOrFail($id);
        dd($row);
        //$row->update($data);
        return $this->updateResponse();

    }

    public function updateStatus(Request $request, $id) {
        $provider = MainOtpProvider::findOrFail($id);
        $status = $request->input('status') === 'Active';
        $provider->status = $status;
        $provider->save();
        return response()->json(['message' => 'Status updated successfully']);
    }

    public function destroy($id) {
        $row = MainOtpProvider::findOrFail($id);
        $row->delete();
        return $this->deleteResponse('Main OTP Provider deleted successfully.');
    }
}
