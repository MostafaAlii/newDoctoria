@extends('Admin.layouts.inc.app')
@section('title')
    {{ helperTrans('admin.Doctors') }}
@endsection
@section('css')
    <style>
        .select2-container {
            z-index: 10000;
            /* Adjust the value as needed */
        }
    </style>
@endsection
@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1">{{ helperTrans('admin.Doctors') }}</h5>
            @if (auth()->guard('admin')->user()->hasPermission('doctors_create'))
                <div>
                    <button id="addBtn" class="btn btn-primary"> {{ helperTrans('admin.Add Doctor') }}</button>
                </div>
            @endif

        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ helperTrans('admin.Image') }}</th>
                        <th>{{ helperTrans('admin.name') }}</th>
                        <th>{{ helperTrans('admin.nickname') }}</th>
                        <th>{{ helperTrans('admin.email') }}</th>
                        <th>{{ helperTrans('admin.phone') }}</th>
                        <th>{{ helperTrans('admin.specialization') }}</th>
                        <th>{{ helperTrans('admin.lang') }}</th>
                        <th>{{ helperTrans('admin.weight') }}</th>
                        <th>{{ helperTrans('admin.Status') }}</th>
                        <th>{{ helperTrans('admin.Doctor Times') }}</th>
                        <th>{{ helperTrans('admin.Update') }}</th>
                        <th>{{ helperTrans('admin.created at') }}</th>
                        <th>{{ helperTrans('admin.actions') }}</th>
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
                    <h2><span id="operationType"></span> {{ helperTrans('admin.Doctor') }} </h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" style="cursor: pointer"
                        data-bs-dismiss="modal" aria-label="Close">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                    transform="rotate(-45 6 17.3137)" fill="black" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                    transform="rotate(45 7.41422 6)" fill="black" />
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
                            {{ helperTrans('admin.cancel') }}
                        </button>
                        <button form="form" type="submit" id="submit" class="btn btn-primary">
                            <span class="indicator-label">{{ helperTrans('admin.ok') }}</span>
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
        var columns = [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'image',
                name: 'image'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'nickname',
                name: 'nickname'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'phone',
                name: 'phone'
            },
            {
                data: 'specialization_id',
                name: 'specialization_id'
            },
            {
                data: 'lang',
                name: 'lang'
            },
            {
                data: 'weight',
                name: 'weight'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'doctor_times',
                name: 'doctor_times'
            },
            {
                data: 'update',
                name: 'update'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ];
    </script>
    @include('Admin.layouts.inc.ajax', ['url' => 'doctors'])


    <link href="{{ url('assets/dashboard/css/select2.css') }}" rel="stylesheet" />
    <script src="{{ url('assets/dashboard/js/select2.js') }}"></script>

    <script>
        $(document).on('change', '#governorate_id', function() {
            var governorate_id = $(this).val();
            var route = "{{ route('admin.get_city_by_governorate') }}?governorate_id=" + governorate_id;
            setTimeout(function() {
                $('#city_id').load(route)
            }, 1000)
        })
    </script>

    <script>
        $(document).on('change', '#specialization_id', function() {
            var specialization_id = $(this).val();
            var route = "{{ route('admin.get_sub_specialization') }}?specialization_id=" + specialization_id;
            setTimeout(function() {
                $('#sub_specialization_id').load(route)
            }, 1000)
        })
    </script>

    <script>
        $(document).on('change', '.activeBtn', function() {
            var id = $(this).attr('data-id');

            $.ajax({
                type: 'GET',
                url: "{{ route('admin.active.doctor') }}",
                data: {
                    id: id,
                },

                success: function(res) {
                    if (res['status'] == true) {

                        toastr.success(
                            "{{ helperTrans('admin.operation accomplished successfully') }}")
                        // $('#table').DataTable().ajax.reload(null, false);
                    } else {
                        // location.reload();

                    }
                },
                error: function(data) {
                    // location.reload();
                }
            });


        })
    </script>
@endsection
