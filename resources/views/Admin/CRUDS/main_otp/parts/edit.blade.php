<!--begin::Form-->

<form id="form" method="POST" action="{{ route('main_otp.update', $mainOtpProvider->id) }}">
    @csrf
    @method('PUT')
    <div class="row">
        <input type="hidden" name="id" value="{{ $mainOtpProvider->id }}">
        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="title" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{ helperTrans('admin.name') }} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input id="name" required type="text" class="form-control form-control-solid" placeholder=""
                name="name" value="{{ $mainOtpProvider->name }}" />
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="status" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">Status <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <select id="status" required class="form-control form-control-solid" name="status">
                <option value="1" {{ $mainOtpProvider->status == '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ $mainOtpProvider->status == '0' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>



    </div>
</form>
