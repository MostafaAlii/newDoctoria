<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('governorates.store')}}">
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










    </div>
</form>
