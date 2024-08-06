@extends('Admin.layouts.inc.app')
@section('title')
    {{helperTrans('admin.Patients')}}
@endsection
@section('css')



@endsection
@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1">{{helperTrans('admin.Patients')}}</h5>

                <div>
                    <button id="addBtn" class="btn btn-primary"> {{helperTrans('admin.Add Patient')}}</button>
                </div>


        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                   style="width:100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{helperTrans('admin.name')}}</th>
                    <th>{{helperTrans('admin.nickname')}}</th>
                    <th>{{helperTrans('admin.gender')}}</th>
                    <th>{{helperTrans('admin.postcode')}}</th>
                    <th>{{helperTrans('admin.phone')}}</th>
                    <th>{{helperTrans('admin.refer_code')}}</th>
                    <th>{{helperTrans('admin.medical')}}</th>
                    <th>{{helperTrans('admin.status')}}</th>
                    <th>{{helperTrans('admin.nationality_id')}}</th>
                    <th>{{helperTrans('admin.city_id')}}</th>
                    <th>{{helperTrans('admin.address')}}</th>
                    <th>  {{helperTrans('admin.created at')}}</th>
                    <th>{{helperTrans('admin.actions')}}</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal fade" data-bs-backdrop="static" id="Modal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered modal-lg mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content" id="modalContent">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2><span id="operationType"></span> {{helperTrans('admin.Patient')}} </h2>
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
            {data: 'name', name: 'name'},
            {data: 'nickname', name: 'nickname'},
            {data: 'gender', name: 'gender'},
            {data: 'postcode', name: 'postcode'},
            {data: 'phone', name: 'phone'},
            {data: 'refer_code', name: 'refer_code'},
            {data: 'medical_data', name: 'medical_data'},
            {data: 'status', name: 'status'},
            {data: 'nationality_id', name: 'nationality_id'},
            {data: 'city_id', name: 'city_id'},
            {data: 'address', name: 'address'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ];
    </script>
    @include('Admin.layouts.inc.ajax',['url'=>'patients'])


    <script>
        $(document).on('change','#nationality_id',function (){
            var nationality_id=$(this).val();


            var url = "{{route("admin.getCityByNationality")}}?nationality_id="+nationality_id;



            setTimeout(function (){
                $('#city_id').load(url)
            },1000)


        })
    </script>



@endsection
