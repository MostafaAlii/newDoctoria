<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('sc_categories.update',$row->id)}}">
    @csrf
    @method('PUT')
    <div class="row g-4">


        <input type="hidden" name="id" value="{{$row->id}}">


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label for="image" class="form-control-label">{{helperTrans('admin.image')}} </label>
            <input id="image" type="file" class="dropify" name="image" data-default-file="{{get_file($row->image)}}" accept="image/*"/>
            <span
                class="form-text text-muted text-center">{{helperTrans('admin.Only the following formats are allowed: jpeg, jpg, png, gif, svg, webp, avif.')}}</span>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label for="icon" class="form-control-label">{{helperTrans('admin.Icon')}} </label>
            <input id="icon" type="file" class="dropify" name="icon" data-default-file="{{get_file($row->icon)}}" accept="image/*"/>
            <span
                class="form-text text-muted text-center">{{helperTrans('admin.Only the following formats are allowed: jpeg, jpg, png, gif, svg, webp, avif.')}}</span>
        </div>



    @foreach(languages() as $index=>$language)

            <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                <!--begin::Label-->
                <label for="name_{{$language->abbreviation}}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1">{{helperTrans('admin.name')}}({{$language->abbreviation}})</span>
                    <span class="red-star">*</span>
                </label>

                <!--end::Label-->
                <input id="name_{{$language->abbreviation}}" required type="text" class="form-control form-control-solid"
                       placeholder="" name="name[{{$language->abbreviation}}]" value="{{$row->getTranslation('name', $language->abbreviation)}}"/>
            </div>

        @endforeach

        @foreach(languages() as $index=>$language)


            <div class="col-sm-6 pb-3 p-2">
                <label for="details_{{$language->abbreviation}}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1">  {{helperTrans('admin.Address')}}       <span class="red-star">*</span></span>
                </label>
                <textarea name="details[{{$language->abbreviation}}]" id="details_{{$language->abbreviation}}" class="form-control " rows="5"
                          placeholder="">{{$row->getTranslation('details', $language->abbreviation)}}</textarea>
            </div>

        @endforeach




        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="color" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Color')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input type="color" id="color" class="form-control" name="color" value="{{$row->color}}">
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="main_service_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Main Service')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <select class="form-control" id="main_service_id" name="main_service_id">
                <option selected disabled>Select Main Service</option>

                @foreach($mainServices as $mainService)
                    <option @if($mainServices->id==$row->main_service_id) selected @endif value="{{$mainService->id}}">{{$mainService->name}}</option>
                @endforeach

            </select>
        </div>


    </div>
</form>

<script>
    $('.dropify').dropify();

</script>
