<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('categories.update',$row->id)}}">
    @csrf
    @method('PUT')
    <div class="row g-4">


        <input type="hidden" name="id" value="{{$row->id}}">


        <div class="form-group">
            <label for="icon" class="form-control-label">{{helperTrans('admin.Icon')}} </label>
            <input type="file" id="icon" class="dropify" name="icon" data-default-file="{{get_file($row->icon)}}" accept="image/*"/>
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

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="main_service_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">Main Service</span>
                <span class="red-star">*</span>
            </label>

            <!--end::Label-->
            <select class="form-control" id="main_service_id" name="main_service_id">
                <option selected disabled>{{helperTrans('admin.Select Main Service')}}</option>

                @foreach($mainServices as $mainService)

                    <option @if($row->main_service_id==$mainService->id) selected @endif value="{{$mainService->id}}">{{$mainService->name}}</option>

                @endforeach

            </select>
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="slug" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">Slug</span>
                <span class="red-star">*</span>
            </label>

            <!--end::Label-->
            <input type="text" name="slug" id="slug" class="form-control" value="{{$row->slug}}"  >
        </div>


    </div>
</form>


<script>
    $('.dropify').dropify();
</script>
