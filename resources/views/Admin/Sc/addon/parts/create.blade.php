<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('sc_addons.store')}}">
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
                    <span class="required mr-1">{{helperTrans('admin.Price')}} <span class="red-star">*</span></span>
                </label>
                <!--end::Label-->
                <input type="number" id="price" class="form-control" name="price" step="any">
            </div>


    </div>
</form>

