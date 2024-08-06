<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('packages.update',$row->id)}}">
    @csrf
    @method('PUT')
    <div class="row g-4">


        <input type="hidden" name="id" value="{{$row->id}}">


        @foreach(languages() as $index=>$language)

            <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                <!--begin::Label-->
                <label for="name_{{$language->abbreviation}}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1">{{helperTrans('admin.name')}}({{$language->abbreviation}})</span>
                    <span class="red-star">*</span>
                </label>

                <!--end::Label-->
                <input id="name_{{$language->abbreviation}}" required type="text" class="form-control form-control-solid"
                       placeholder="" name="name[{{$language->abbreviation}}]" value="{{$row->getTranslation('name', $language->abbreviation)}}"/>
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
                   placeholder="" name="price" value="{{$row->price}}"/>
        </div>


        <div id="main_service_data">

            @forelse($packageMainServices as $index=> $packageMainService)
                <div class="card" id="main_service_{{$index}}">
                    <div class="row g-4 card-body " >



                        <div class="d-flex flex-column mb-7 fv-row col-sm-4">

                            <label for="main_service_id_{{$index}}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                <span class="required mr-1">{{helperTrans('admin.Main Service')}}     <span class="red-star">*</span></span>
                            </label>
                            <!--end::Label-->
                            <select required class="form-control" id="main_service_id_{{$index}}" name="main_service_id[]">
                                <option selected disabled>{{helperTrans('admin.Select Main Service')}}</option>
                                @foreach($mainServices as $mainService)
                                    <option @if($mainService->id==$packageMainService->main_service_id) selected @endif value="{{$mainService->id}}">{{$mainService->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex flex-column mb-7 fv-row col-sm-4">

                            <label for="count_{{$index}}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                <span class="required mr-1">{{helperTrans('admin.Count')}}  <span class="red-star">*</span>    </span>
                            </label>
                            <!--end::Label-->
                            <input id="count_{{$index}}" min="1" required type="number" class="form-control form-control-solid" placeholder="" name="count[]"
                                   value="{{$packageMainService->count}}"/>
                        </div>




                        @if($index==0)
                        <div class="d-flex flex-column mb-7 fv-row col-sm-4">

                            <span  id="addMainService" class="btn btn-success mt-4"><i class="fa fa-plus mx-2"></i>Add</span>
                        </div>

                        @else



                            <div class="d-flex flex-column mb-7 fv-row col-sm-4">

                                <span data-id="{{$index}}"   class="btn btn-danger mt-4 deleteMainService"><i class="fa fa-trash"></i></span>
                            </div>




                        @endif




                    </div>
                </div>

            @empty

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
            @endforelse
        </div>




    </div>
</form>

