<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TypeRequest;
use App\Http\Traits\ResponseTrait;
use App\Models\Category;
use App\Models\Type;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TypeController extends Controller
{
    //

    use  ResponseTrait;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = Type::query()->latest();
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


                ->editColumn('category_id', function ($row) {
                    return $row->category->name ?? '';
                })
                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }
        return view('Admin.CRUDS.type.index');
    }


    public function create()
    {

        $categories = Category::get();

        return view('Admin.CRUDS.type.parts.create', compact('categories'));
    }

    public function store(TypeRequest $request)
    {
        $data = $request->validationData();
        Type::create($data);
        return $this->addResponse();

    }


    public function show($id)
    {


        //
    }


    public function edit($id)
    {


        $row = Type::findOrFail($id);

        $categories = Category::get();


        return view('Admin.CRUDS.type.parts.edit', compact('row', 'categories'));

    }

    public function update(TypeRequest $request, $id)
    {

        $row = Type::findOrFail($id);
        $data = $request->validationData();
        $row->update($data);
        return $this->updateResponse();

    }


    public function destroy($id)
    {
        $row = Type::findOrFail($id);

        $row->delete();

        return $this->deleteResponse();
    }//end fun
}
