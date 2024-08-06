<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('languages.store')}}">
    @csrf
    <div class="row g-4">



        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="title" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.name')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input id="title" required type="text" class="form-control form-control-solid" placeholder="" name="title" value=""/>
        </div>



        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="abbreviation" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.abbreviation')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input id="abbreviation" required type="text" class="form-control form-control-solid" placeholder="" name="abbreviation" value=""/>
        </div>



    </div>
</form>
