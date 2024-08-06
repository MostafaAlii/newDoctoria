<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('doctors_branches.update',$row->id)}}">
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



        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="name" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.name')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input id="name" required type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{$row->name}}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="phone" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> {{helperTrans('admin.Phone')}}</span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <input id="phone" type="text" class="form-control form-control-solid" placeholder=" " name="phone" value="{{$row->phone}}"/>
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="latitude" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> {{helperTrans('admin.Latitude')}}</span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <input id="latitude" type="text" class="form-control form-control-solid" placeholder=" " name="latitude" value="{{$row->latitude}}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="longitude" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> {{helperTrans('admin.Longitude')}}</span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <input id="longitude" type="text" class="form-control form-control-solid" placeholder=" " name="longitude" value="{{$row->longitude}}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6 ">
            <!--begin::Label-->
            <label for="location" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> {{helperTrans('admin.Location')}}</span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <input id="location" type="text" class="form-control form-control-solid" placeholder=" " name="location" value="{{$row->location}}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="price" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> {{helperTrans('admin.Price')}}</span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <input id="price" type="number" class="form-control form-control-solid" placeholder=" " name="price" value="{{$row->price}}"/>
        </div>


        @foreach(languages() as $index=>$language)


            <div class="col-sm-6 pb-3 p-2">
                <label for="about_{{$language->abbreviation}}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1">  {{helperTrans('admin.About')}}  ({{$language->abbreviation}})     </span>
                </label>
                <textarea name="about[{{$language->abbreviation}}]" id="about_{{$language->abbreviation}}" class="form-control " rows="5"
                          placeholder="">{{$row->getTranslation('about', $language->abbreviation)}}</textarea>
            </div>

        @endforeach

    </div>
</form>


<script>
    $('.dropify').dropify();
    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();
    });
</script>
