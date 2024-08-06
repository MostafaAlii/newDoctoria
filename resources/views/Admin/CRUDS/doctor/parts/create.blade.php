<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('doctors.store')}}">
    @csrf
    <div class="row g-4">


        <div class="form-group">
            <label for="image" class="form-control-label">{{helperTrans('admin.image')}} </label>
            <input id="image" type="file" class="dropify" name="image" data-default-file="{{get_file()}}" accept="image/*"/>
            <span
                class="form-text text-muted text-center">{{helperTrans('admin.Only the following formats are allowed: jpeg, jpg, png, gif, svg, webp, avif.')}}</span>
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="name" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.name')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input id="name" required type="text" class="form-control form-control-solid" placeholder="" name="name" value=""/>
        </div>



        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="nickname" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.nickname')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input id="nickname" required type="text" class="form-control form-control-solid" placeholder="" name="nickname" value=""/>
        </div>

        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="email" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.email')}} </span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <input id="email" required type="email" class="form-control form-control-solid" placeholder=" {{helperTrans('admin.email')}}"
                   name="email" value=""/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="phone" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> {{helperTrans('admin.Phone')}}</span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <input id="phone" type="text" class="form-control form-control-solid" placeholder=" " name="phone"
                   value=""/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="private_number" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> {{helperTrans('admin.Priavte Phone Number')}}</span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <input id="private_number" type="text" class="form-control form-control-solid" placeholder=" " name="private_number"
                   value=""/>
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.password')}}</span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <input type="password" class="form-control form-control-solid" placeholder=" " name="password" value=""/>
        </div>



        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="gender" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Gender')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <select name="gender" id="gender" class="form-control">
                <option selected disabled>Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>

            </select>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="specialization_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.specialization')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <select name="specialization_id" id="specialization_id" class="form-control">
                <option selected disabled>Select Specialization</option>
                @foreach($specializations as $specialization)
                    <option value="{{$specialization->id}}">{{$specialization->name}}</option>
                @endforeach

            </select>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="sub_specialization_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Sub Specialization')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <select name="sub_specialization_id" id="sub_specialization_id" class="form-control">
                <option selected disabled>Select Specialization First</option>


            </select>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="governorate_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Governorate')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <select name="governorate_id" id="governorate_id" class="form-control">
                <option selected disabled>Select governorate</option>
                @foreach($governorates as $governorate)
                    <option value="{{$governorate->id}}">{{$governorate->name}}</option>
                @endforeach

            </select>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="city_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.City')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <select name="city_id" id="city_id" class="form-control">
                <option selected disabled>Select Governorate First</option>

            </select>
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="experience_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Experience')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <select name="experience_id" id="experience_id" class="form-control">
                <option selected disabled>Select Experience</option>
                @foreach($experiences as $experience)
                    <option value="{{$experience->id}}">{{$experience->name}}</option>
                @endforeach

            </select>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="experience_years" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> Experience Years</span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <input id="lang" type="text" class="form-control form-control-solid" placeholder=" " name="experience_years" value=""/>
        </div>




        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="lang" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> {{helperTrans('admin.lang')}}</span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <input id="lang" type="text" class="form-control form-control-solid" placeholder=" " name="lang"
                   value=""/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="latitude" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> {{helperTrans('admin.Latitude')}}</span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <input id="latitude" type="text" class="form-control form-control-solid" placeholder=" " name="latitude"
                   value=""/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="longitude" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> {{helperTrans('admin.Longitude')}}</span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <input id="longitude" type="text" class="form-control form-control-solid" placeholder=" " name="longitude"
                   value=""/>
        </div>




        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="weight" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> {{helperTrans('admin.weight')}}</span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <input id="weight" type="number" class="form-control form-control-solid" placeholder=" " name="weight"
                   value=""/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="location" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> {{helperTrans('admin.Location')}}</span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <input id="location" type="text" class="form-control form-control-solid" placeholder=" " name="location"
                   value=""/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="service_price_online" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> {{helperTrans('admin.Service Online Price')}}</span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <input id="service_price_online" type="number" class="form-control form-control-solid" placeholder=" " name="service_price_online"
                   value=""/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="service_price_home" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> {{helperTrans('admin.Service Home Price')}}</span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <input id="service_price_home" type="number" class="form-control form-control-solid" placeholder=" " name="service_price_home"
                   value=""/>
        </div>



        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="category_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Category')}}</span>
                <span class="red-star">*</span>
            </label>
            <select id="category_id" class="js-example-basic-multiple" name="category_id[]" multiple="multiple">
                @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name??''}}</option>
                @endforeach
            </select>

        </div>



        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <!--begin::Label-->
            <label for="is_popular" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Popular')}}</span>
                <span class="red-star">*</span>
            </label>
            <select id="is_popular" class="form-control" name="is_popular" >
               <option selected disabled>{{helperTrans('admin.Select')}}</option>
                <option value="1">{{helperTrans('admin.yes')}}</option>
                <option value="0" >{{helperTrans('admin.No')}}</option>
            </select>

        </div>


        @foreach(languages() as $index=>$language)


            <div class="col-sm-6 pb-3 p-2">
                <label for="about_{{$language->abbreviation}}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1">  {{helperTrans('admin.About')}}  ({{$language->abbreviation}})      </span>
                </label>
                <textarea name="about[{{$language->abbreviation}}]" id="about_{{$language->abbreviation}}" class="form-control " rows="5"
                          placeholder=""></textarea>
            </div>

        @endforeach





    </div>
</form>

<script>
    $('.dropify').dropify();
    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();
    });
</script>
