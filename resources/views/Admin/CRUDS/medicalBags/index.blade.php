@extends('Admin.layouts.inc.app')
@section('title')
    {{helperTrans('admin.Medical Bag')}}
@endsection
@section('css')



@endsection
@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1">{{helperTrans('admin.Medical Bag')}}</h5>




        </div>
        <div class="card-body">

            <div class="row g-4 my-4">


                <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                    <!--begin::Label-->
                    <label for="category_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                        <span class="required mr-1">{{helperTrans('admin.Category')}} </span>
                    </label>
                    <!--end::Label-->
                      <select class="form-control" name="category_id"  id="category_id">

                          <option selected disabled>{{helperTrans('admin.filter by category')}}</option>

                          @foreach($categories as $category)
                              <option value="{{$category->id}}">{{$category->name}}</option>
                          @endforeach
                      </select>
                </div>

            </div>




            <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                   style="width:100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{helperTrans('admin.Category')}}</th>
                    <th>{{helperTrans('admin.Patient')}}</th>
                    <th>{{helperTrans('admin.Unit')}}</th>
                    <th>{{helperTrans('admin.Value')}}</th>
                    <th>  {{helperTrans('admin.created at')}}</th>
                    <th>{{helperTrans('admin.actions')}}</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal fade" id="Modal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered modal-lg mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content" id="modalContent">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2><span id="operationType"></span> {{helperTrans('admin.Medical Bag')}} </h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" style="cursor: pointer"
                         data-bs-dismiss="modal" aria-label="Close">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                      transform="rotate(-45 6 17.3137)"
                                      fill="black"/>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                      fill="black"/>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7" id="form-load">

                </div>
                <!--end::Modal body-->
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="reset" data-bs-dismiss="modal" aria-label="Close" class="btn btn-light me-3">
                            {{helperTrans('admin.cancel')}}
                        </button>
                        <button form="form" type="submit" id="submit" class="btn btn-primary">
                            <span class="indicator-label">{{helperTrans('admin.ok')}}</span>
                        </button>
                    </div>
                </div>
            </div>

            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>

@endsection
@section('js')
    <script>
        var columns = [
            {data: 'id', name: 'id'},
            {data: 'category_id', name: 'category_id'},
            {data: 'patient_id', name: 'patient_id'},
            {data: 'unit', name: 'unit'},
            {data: 'value', name: 'value'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ];
    </script>
    @include('Admin.CRUDS.medicalBags.parts.ajax',['url'=>'medical_bags'])



@endsection
