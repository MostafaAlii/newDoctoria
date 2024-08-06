<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('medication_units.store')}}">
    @csrf
    <div class="row g-4">


        @foreach(languages() as $index=>$language)

            <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                <!--begin::Label-->
                <label for="unit_{{$language->abbreviation}}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1">{{helperTrans('admin.unit')}}({{$language->abbreviation}})</span>
                    <span class="red-star">*</span>
                </label>

                <!--end::Label-->
                <input id="unit_{{$language->abbreviation}}" required type="text" class="form-control form-control-solid"
                       placeholder="" name="unit[{{$language->abbreviation}}]" value=""/>
            </div>

        @endforeach






    </div>
</form>


