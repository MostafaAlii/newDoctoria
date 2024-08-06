<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('patients.store')}}">
    @csrf
    <div class="row g-4">


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
            <label for="postcode" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.postcode')}} </span>
            </label>
            <!--end::Label-->
            <input id="postcode" required type="text" class="form-control form-control-solid" placeholder=" {{helperTrans('admin.postcode')}}"
                   name="postcode" value=""/>
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
            <label for="refer_code" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Refer Code')}}</span>
            </label>
            <!--end::Label-->
            <input type="text" id="refer_code" class="form-control form-control-solid" placeholder=" " name="refer_code" value=""/>
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

        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <!--begin::Label-->
            <label for="package_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Package')}}</span>
            </label>
            <!--end::Label-->
            <select name="package_id" id="package_id" class="form-control">
                <option selected disabled>Select package</option>
                    @foreach($packages as $package)
                        <option value="{{$package->id}}">{{$package->name}}</option>
                    @endforeach
            </select>
        </div>



        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="email" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Email')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input type="email" name="email" id="email" class="form-control">
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="password" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Password')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input type="password" name="password" id="password" class="form-control">
        </div>









        <div class="d-flex flex-column mb-7 fv-row col-sm-4">
            <!--begin::Label-->
            <label for="status_data" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Status')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <select name="status" id="status_data" class="form-control">
                <option selected disabled>Select Status</option>
                    <option value="1">Active</option>
                <option value="0">Not Active</option>

            </select>
        </div>




        <div class="d-flex flex-column mb-7 fv-row col-sm-4">
            <!--begin::Label-->
            <label for="nationality_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Nationality')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <select name="nationality_id" id="nationality_id" class="form-control">
                <option selected disabled>Select Nationality</option>
                @foreach($nationalities as $nationality)
                    <option value="{{$nationality->id}}">{{$nationality->name}}</option>
                @endforeach

            </select>
        </div>





        <div class="d-flex flex-column mb-7 fv-row col-sm-4">
            <!--begin::Label-->
            <label for="city_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.City')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <select name="city_id" id="city_id" class="form-control">
            <option selected disabled>First Select Nationality</option>
            </select>
        </div>




        <div class="col-sm-12 pb-3 p-2">
            <label for="address" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">  {{helperTrans('admin.Address')}}       <span class="red-star">*</span></span>
            </label>
            <textarea name="address" id="address" class="form-control " rows="5"
                      placeholder=""></textarea>
        </div>






    </div>
</form>
