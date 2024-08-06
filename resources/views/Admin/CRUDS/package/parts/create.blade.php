<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('packages.store')}}">
    @csrf
    <div class="row g-4">


        @foreach(languages() as $index=>$language)

            <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                <!--begin::Label-->
                <label for="name_{{$language->abbreviation}}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1">{{helperTrans('admin.name')}}({{$language->abbreviation}})</span>
                    <span class="red-star">*</span>
                </label>

                <!--end::Label-->
                <input id="name_{{$language->abbreviation}}" required type="text" class="form-control form-control-solid"
                       placeholder="" name="name[{{$language->abbreviation}}]" value=""/>
            </div>

        @endforeach


            <div class="d-flex flex-column mb-7 fv-row col-sm-12">
                <!--begin::Label-->
                <label for="price" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1">{{helperTrans('admin.Price')}}</span>
                    <span class="red-star">*</span>
                </label>

                <!--end::Label-->
                <input id="price" required type="number" class="form-control form-control-solid"
                       placeholder="" name="price" value=""/>
            </div>


            <div id="main_service_data">
                <div class="card" id="main_service_1">
                    <div class="row g-4 card-body " >



                        <div class="d-flex flex-column mb-7 fv-row col-sm-4">

                            <label for="main_service_id_1" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                <span class="required mr-1">{{helperTrans('admin.Main Service')}}     <span class="red-star">*</span></span>
                            </label>
                            <!--end::Label-->
                              <select required class="form-control" id="main_service_id_1" name="main_service_id[]">
                              <option selected disabled>{{helperTrans('admin.Select Main Service')}}</option>
                                  @foreach($mainServices as $mainService)
                                      <option value="{{$mainService->id}}">{{$mainService->name}}</option>
                                  @endforeach
                              </select>
                        </div>

                        <div class="d-flex flex-column mb-7 fv-row col-sm-4">

                            <label for="count_1" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                <span class="required mr-1">{{helperTrans('admin.Count')}}  <span class="red-star">*</span>    </span>
                            </label>
                            <!--end::Label-->
                            <input id="count_1" min="1" required type="number" class="form-control form-control-solid" placeholder="" name="count[]"
                                   value=""/>
                        </div>




                        <div class="d-flex flex-column mb-7 fv-row col-sm-4">

                            <span  id="addMainService" class="btn btn-success mt-4"><i class="fa fa-plus mx-2"></i>Add</span>
                        </div>





                    </div>
                </div>

            </div>








    </div>
</form>
