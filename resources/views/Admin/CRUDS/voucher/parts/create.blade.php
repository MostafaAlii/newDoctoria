<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('vouchers.store')}}">
    @csrf
    <div class="row g-4">


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="code" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Code')}}</span>
                <span class="red-star">*</span>
            </label>

            <!--end::Label-->
            <input id="code" required type="text" class="form-control form-control-solid" placeholder="" name="code" value=""/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="count_consultations" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Number Of Consultations')}}</span>
                <span class="red-star">*</span>
            </label>

            <!--end::Label-->
            <input id="count_consultations" required type="number" class="form-control form-control-solid" placeholder="" name="count_consultations" value=""/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="start_at" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Start At')}}</span>
                <span class="red-star">*</span>
            </label>

            <!--end::Label-->
            <input id="start_at" required type="date" class="form-control form-control-solid" placeholder="" name="start_at" value=""/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="end_at" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.End At')}}</span>
                <span class="red-star">*</span>
            </label>

            <!--end::Label-->
            <input id="end_at" required type="date" class="form-control form-control-solid" placeholder="" name="end_at" value=""/>
        </div>


    </div>
</form>
