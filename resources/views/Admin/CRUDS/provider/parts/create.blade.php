<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('providers.store')}}">
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


        <div class="col-sm-6 pb-3 p-2">
            <label for="desc_{{$language->abbreviation}}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.description')}}<span class="red-star">*</span></span>
            </label>
            <textarea name="desc[{{$language->abbreviation}}]" id="desc_{{$language->abbreviation}}" class="form-control " rows="5" placeholder=""></textarea>
        </div>

        @endforeach



            <div class="d-flex flex-column mb-7 fv-row col-sm-12">
                <!--begin::Label-->
                <label for="provider_type_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1">{{helperTrans('admin.Provider Types')}} <span class="red-star">*</span></span>
                </label>
                <!--end::Label-->
                <select name="provider_type_id" id="nationality_id" class="form-control">
                    <option selected disabled>Provider Types</option>
                    @foreach($provider_types as $provider_type)
                        <option value="{{$provider_type->id}}">{{$provider_type->name}}</option>
                    @endforeach

                </select>
            </div>


            <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                <!--begin::Label-->
                <label for="work_from" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1">{{helperTrans('admin.work from')}} <span class="red-star">*</span></span>
                </label>
                <!--end::Label-->
                <input type="time" id="work_from" class="form-control" name="work_from" value="">
            </div>



            <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                <!--begin::Label-->
                <label for="work_to" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1">{{helperTrans('admin.work to')}} <span class="red-star">*</span></span>
                </label>
                <!--end::Label-->
                <input type="time" id="work_to" class="form-control" name="work_to" value="">
            </div>





            <div class="d-flex flex-column mb-7 fv-row col-sm-12">
                <!--begin::Label-->
                <label for="location" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1">{{helperTrans('admin.location')}} <span class="red-star">*</span></span>
                </label>
                <!--end::Label-->
                <input type="text" id="location" class="form-control" name="location" value="">
            </div>


            @foreach(languages() as $index=>$language)


                <div class="col-sm-6 pb-3 p-2">
                    <label for="about_us_{{$language->abbreviation}}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                        <span class="required mr-1">{{helperTrans('admin.About Us')}}<span class="red-star">*</span></span>
                    </label>
                    <textarea name="about_us[{{$language->abbreviation}}]" id="about_us_{{$language->abbreviation}}" class="form-control " rows="5" placeholder=""></textarea>
                </div>

            @endforeach

            <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                <!--begin::Label-->
                <label for="latitude" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1">{{helperTrans('admin.latitude')}} <span class="red-star">*</span></span>
                </label>
                <!--end::Label-->
                <input type="text" id="latitude" class="form-control" name="latitude" value="">
            </div>


            <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                <!--begin::Label-->
                <label for="longitude" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1">{{helperTrans('admin.longitude')}} <span class="red-star">*</span></span>
                </label>
                <!--end::Label-->
                <input type="text" id="longitude" class="form-control" name="longitude" value="">
            </div>

            <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                <!--begin::Label-->
                <label for="phone" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1">{{helperTrans('admin.phone')}} <span class="red-star">*</span></span>
                </label>
                <!--end::Label-->
                <input type="text" id="longitude" class="form-control" name="phone" value="">
            </div>

            <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                <!--begin::Label-->
                <label for="website_link" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1">{{helperTrans('admin.Website link')}} <span class="red-star">*</span></span>
                </label>
                <!--end::Label-->
                <input type="text" id="website_link" class="form-control" name="website_link" value="">
            </div>


            <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                <!--begin::Label-->
                <label for="rating_value" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1">{{helperTrans('admin.rating value')}} <span class="red-star">*</span></span>
                </label>
                <!--end::Label-->
                <input type="number" id="rating_value" class="form-control" name="rating_value" value="">
            </div>

            <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                <!--begin::Label-->
                <label for="num_of_raters" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1">{{helperTrans('admin.number of raters')}} <span class="red-star">*</span></span>
                </label>
                <!--end::Label-->
                <input type="number" id="num_of_raters" class="form-control" name="num_of_raters" value="">
            </div>

            <div class="form-group">
                <label for="image" class="form-control-label">{{helperTrans('admin.image')}} </label>
                <input id="image" type="file" class="dropify" name="image" data-default-file="{{get_file()}}" accept="image/*"/>
                <span class="form-text text-muted text-center">{{helperTrans('admin.Only the following formats are allowed: jpeg, jpg, png, gif, svg, webp, avif.')}}</span>
            </div>



    </div>
</form>


<script>
    $('.dropify').dropify();

</script>

