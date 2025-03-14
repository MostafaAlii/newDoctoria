@extends('Admin.layouts.inc.app')
@section('title')
    {{helperTrans('admin.Branches')}}
@endsection
@section('css')

@endsection
@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1">{{helperTrans('admin.Branches For laboratory:')}}{{$laboratory->name}}</h5>

                <div>
                    <button id="addBtn-p" data-id="{{$laboratory->id}}" class="btn btn-primary"> {{helperTrans('admin.Add Branch')}}</button>
                </div>


        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                   style="width:100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{helperTrans('admin.phone')}}</th>
                    <th>{{helperTrans('admin.mobile')}}</th>
                    <th>{{helperTrans('admin.email')}}</th>
                    <th>{{helperTrans('admin.whatsapp')}}</th>
                    <th>{{helperTrans('admin.governorate')}}</th>
                    <th>{{helperTrans('admin.city')}}</th>
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
                    <h2><span id="operationType"></span> {{helperTrans('admin.Branch')}} </h2>
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
            {data: 'phone', name: 'phone'},
            {data: 'mobile', name: 'mobile'},
            {data: 'email', name: 'email'},
            {data: 'whatsapp', name: 'whatsapp'},
            {data: 'governorate_id', name: 'governorate_id'},
            {data: 'city_id', name: 'city_id'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ];
    </script>
    @include('Admin.layouts.inc.ajax',['url'=>'laboratory_branches'])

    <script>
        $(document).on('click', '#addBtn-p', function () {
            var laboratory_id=$(this).attr('data-id');
            var route="{{route('laboratory_branches.create')}}?laboratory_id="+laboratory_id;
            $('#form-load').html(loader)
            $('#operationType').text('Add');

            $('#Modal').modal('show')

            setTimeout(function (){
                $('#form-load').load(route)
            },1000)
        });
    </script>

    <script>
        $(document).on('change','#governorate_id',function (){
            var governorate_id=$(this).val();
            var route="{{route('admin.get_city_by_governorate')}}?governorate_id="+governorate_id;
            setTimeout(function (){
                $('#city_id').load(route)
            },1000)
        })
    </script>


@endsection
