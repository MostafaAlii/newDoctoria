<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('solution_types.update',$row->id)}}">
    @csrf
    @method('PUT')
    <div class="row g-4">


        <input type="hidden" name="id" value="{{$row->id}}">


        @foreach(languages() as $index=>$language)

            <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                <!--begin::Label-->
                <label for="type_{{$language->abbreviation}}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1">{{helperTrans('admin.type')}}({{$language->abbreviation}})</span>
                    <span class="red-star">*</span>
                </label>

                <!--end::Label-->
                <input id="type_{{$language->abbreviation}}" required type="text" class="form-control form-control-solid"
                       placeholder="" name="type[{{$language->abbreviation}}]" value="{{$row->getTranslation('type', $language->abbreviation)}}"/>
            </div>

        @endforeach


    </div>
</form>

