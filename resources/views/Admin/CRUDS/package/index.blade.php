@extends('Admin.layouts.inc.app')
@section('title')
    {{helperTrans('admin.Packages')}}
@endsection
@section('css')



@endsection
@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1">{{helperTrans('admin.Packages')}}</h5>

                <div>
                    <button id="addBtn" class="btn btn-primary"> {{helperTrans('admin.Add Package')}}</button>
                </div>


        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                   style="width:100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{helperTrans('admin.name')}}</th>
                    <th>{{helperTrans('admin.price')}}</th>
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
                    <h2><span id="operationType"></span> {{helperTrans('admin.Package')}} </h2>
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
            {data: 'price', name: 'price'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ];
    </script>
    @include('Admin.layouts.inc.ajax',['url'=>'packages'])

    <script>
            $(document).on('click', '#addMainService', function () {


                var random = Math.floor(Math.random() * (999999999 - 2 + 1)) + 999999999;

               var html=`


                                    <div class="card" id="main_service_${random}">
                                      <div class="row g-4 card-body " >



                                         <div class="d-flex flex-column mb-7 fv-row col-sm-4">

                                          <label for="main_service_id_1" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                            <span class="required mr-1">{{helperTrans('admin.Main Service')}}     <span class="red-star">*</span></span>
                                          </label>
                                           <!--end::Label-->
                                          <select required class="form-control" id="main_service_id_${random}" name="main_service_id[]">
                                             <option selected disabled>{{helperTrans('admin.Select Main Service')}}</option>
                                             @foreach($mainServices as $mainService)
                                              <option value="{{$mainService->id}}">{{$mainService->name}}</option>
                                             @endforeach
                                          </select>
                                      </div>

                                       <div class="d-flex flex-column mb-7 fv-row col-sm-4">

                                             <label for="count_${random}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                 <span class="required mr-1">{{helperTrans('admin.Count')}}  <span class="red-star">*</span>    </span>
                                             </label>
                                             <!--end::Label-->
                                             <input id="count_${random}" min="1" required type="number" class="form-control form-control-solid" placeholder="" name="count[]"
                                             value=""/>
                                        </div>




                                         <div class="d-flex flex-column mb-7 fv-row col-sm-4">

                                           <span data-id="${random}"   class="btn btn-danger mt-4 deleteMainService"><i class="fa fa-trash"></i></span>
                                          </div>





                                        </div>
                                 </div>

               `;

                                                 $('#main_service_data').append(html);


            });

            $(document).on('click','.deleteMainService',function (){
                var rowId=$(this).attr('data-id');
                $(`#main_service_${rowId}`).remove();
            })

    </script>


@endsection
