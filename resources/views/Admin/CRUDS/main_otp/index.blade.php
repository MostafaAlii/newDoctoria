@extends('Admin.layouts.inc.app')
@section('title')
    OTP Providers
@endsection
@section('css')
<style>
    .badge-success {
    background-color: #28a745;
    color: #fff;
    padding: 0.5em 1em;
    border-radius: 0.25em;
}

.badge-danger {
    background-color: #dc3545;
    color: #fff;
    padding: 0.5em 1em;
    border-radius: 0.25em;
}

</style>

@endsection
@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1">OTP Providers</h5>

                <div>
                    <button class="btn btn-primary" id="addBtn"> OTP Providers Create</button>
                </div>


        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                   style="width:100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>{{helperTrans('admin.status')}}</th>
                    <th>  {{helperTrans('admin.created at')}}</th>
                    <th>{{helperTrans('admin.actions')}}</th>
                </tr>
                </thead>
            </table>
            <!-- Start Create -->
            <div class="modal fade" data-bs-backdrop="static" id="Modal" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered modal-lg mw-650px">
                    <!--begin::Modal content-->
                    <div class="modal-content" id="modalContent">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2><span id="otpProvider"></span>Otp Provider</h2>
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
                        <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                            <form id="form" method="POST" action="{{route('main_otp.store')}}">
                                @csrf
                                <div class="row">
                                    <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                                        <!--begin::Label-->
                                        <label for="title" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                            <span class="required mr-1">{{helperTrans('admin.name')}} <span class="red-star">*</span></span>
                                        </label>
                                        <!--end::Label-->
                                        <input id="name" required type="text" class="form-control form-control-solid" placeholder="" name="name" value=""/>
                                    </div>
                                    <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                                        <!--begin::Label-->
                                        <label for="status" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                            <span class="required mr-1">Status <span class="red-star">*</span></span>
                                        </label>
                                        <!--end::Label-->
                                        <select id="status" name="status" class="form-select form-select-solid" required>
                                            <option value="1">Active</option>
                                            <option value="0">Not Active</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
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
            <!-- End Create -->
            <div class="modal fade" data-bs-backdrop="static" id="Modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg mw-650px"></div>
            </div>
        </div>
    </div>

@endsection
@section('js')

<script>
    var columns = [
        {data: 'id', name: 'id'},
        {data: 'name', name: 'name'},
        {
            data: 'status',
            name: 'status',
            render: function(data, type, row) {
                var statusText = $(data).text().trim();
                var checked = statusText === 'Active' ? 'checked' : '';
                return `
                    <div class="form-check form-switch">
                        <input class="form-check-input activeBtn" data-id="${row.id}" type="checkbox" role="switch" id="flexSwitchCheckChecked${row.id}" ${checked}>
                    </div>`;
            }
        },
        {data: 'created_at', name: 'created_at'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ];
    $(document).on('change', '.activeBtn', function() {
        var id = $(this).data('id');
        var status = $(this).is(':checked') ? 'Active' : 'Inactive';

        $.ajax({
            url: '{{ route("otp_update_status", ["id" => ":id"]) }}'.replace(':id', id),
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                status: status
            },
            success: function(response) {
                toastr.success(
                            "{{ helperTrans('admin.Update Provider Successfully') }}");
                console.log('Status updated successfully');
            },
            error: function(xhr) {
                console.log('Failed to update status');
            }
        });
    });
</script>
@include('Admin.layouts.inc.ajax',['url'=>'main_otp'])

@endsection
