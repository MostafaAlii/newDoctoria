<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('sliders.update',$row->id)}}">
    @csrf
    @method('PUT')
    <div class="row g-4">


        <input type="hidden" name="id" value="{{$row->id}}">



        <div class="form-group">
            <label for="image" class="form-control-label">{{helperTrans('admin.image')}} </label>
            <input id="image" type="file" class="dropify" name="image" data-default-file="{{get_file($row->image)}}" accept="image/*"/>
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
                <label for="desc_{{$language->abbreviation}}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1">  {{helperTrans('admin.description')}}       <span class="red-star">*</span></span>
                </label>
                <textarea name="desc[{{$language->abbreviation}}]" id="desc_{{$language->abbreviation}}" class="form-control " rows="5"
                          placeholder="">{{$row->getTranslation('desc', $language->abbreviation)}}</textarea>
            </div>

        @endforeach



    </div>
</form>



<script>
    $('.dropify').dropify();

</script>
