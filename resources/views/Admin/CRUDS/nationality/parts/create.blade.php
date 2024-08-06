<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('nationalities.store')}}">
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


            @foreach(languages() as $index=>$language)

                <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                    <!--begin::Label-->
                    <label for="nickname_{{$language->abbreviation}}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                        <span class="required mr-1">{{helperTrans('admin.nickname')}}({{$language->abbreviation}})</span>
                        <span class="red-star">*</span>
                    </label>

                    <!--end::Label-->
                    <input id="nickname_{{$language->abbreviation}}" required type="text" class="form-control form-control-solid"
                           placeholder="" name="nickname[{{$language->abbreviation}}]" value=""/>
                </div>

            @endforeach




            @foreach(languages() as $index=>$language)

                <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                    <!--begin::Label-->
                    <label for="country_name_{{$language->abbreviation}}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                        <span class="required mr-1">{{helperTrans('admin.country name')}}({{$language->abbreviation}})</span>
                        <span class="red-star">*</span>
                    </label>

                    <!--end::Label-->
                    <input id="country_name_{{$language->abbreviation}}" required type="text" class="form-control form-control-solid"
                           placeholder="" name="country_name[{{$language->abbreviation}}]" value=""/>
                </div>

            @endforeach












            <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="phone_code" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.phone_code')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input id="phone_code" required type="text" class="form-control form-control-solid" placeholder="" name="phone_code" value=""/>
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="country_code" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.country_code')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input id="country_code" required type="text" class="form-control form-control-solid" placeholder="" name="country_code" value=""/>
        </div>
    </div>
</form>

