<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('sc_types.store')}}">
    @csrf
    <div class="row g-4">


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label for="image" class="form-control-label">{{helperTrans('admin.image')}} </label>
            <input id="image" type="file" class="dropify" name="image" data-default-file="{{get_file()}}" accept="image/*"/>
            <span
                class="form-text text-muted text-center">{{helperTrans('admin.Only the following formats are allowed: jpeg, jpg, png, gif, svg, webp, avif.')}}</span>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label for="icon" class="form-control-label">{{helperTrans('admin.Icon')}} </label>
            <input id="icon" type="file" class="dropify" name="icon" data-default-file="{{get_file()}}" accept="image/*"/>
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
                       placeholder="" name="name[{{$language->abbreviation}}]" value=""/>
            </div>

        @endforeach


        @foreach(languages() as $index=>$language)


        <div class="col-sm-6 pb-3 p-2">
            <label for="details_{{$language->abbreviation}}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">  {{helperTrans('admin.Details')}}       <span class="red-star">*</span></span>
            </label>
            <textarea name="details[{{$language->abbreviation}}]" id="details_{{$language->abbreviation}}" class="form-control " rows="5"
                      placeholder=""></textarea>
        </div>

        @endforeach



        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="color" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Color')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input type="color" id="color" class="form-control" name="color">
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="sc_category_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Sc Category')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <select class="form-control" id="sc_category_id" name="sc_category_id">
                <option selected disabled>Select Sc Category</option>

                @foreach( $scCategories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach

            </select>
        </div>




        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="have_experience" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Have Experience')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input type="text" id="have_experience" class="form-control" name="have_experience" value="">
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="status_data" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Status')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <select class="form-control" id="status_data" name="status">

                <option selected disabled>Select Status</option>

                <option value="1">Active</option>
                <option value="0">InActive</option>

            </select>
        </div>




    </div>
</form>


<script>
    $('.dropify').dropify();

</script>
