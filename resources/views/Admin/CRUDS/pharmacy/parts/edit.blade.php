<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('pharmacies.update',$row->id)}}">
    @csrf
    @method('PUT')
    <div class="row g-4">


        <input type="hidden" name="id" value="{{$row->id}}">



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





        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="work_from" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.work from')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input type="time" id="work_from" class="form-control" name="work_from" value="{{$row->work_from}}">
        </div>



        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="work_to" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.work to')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input type="time" id="work_to" class="form-control" name="work_to" value="{{$row->work_to}}">
        </div>



        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="service_price" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Service Price')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input type="text" id="service_price" class="form-control" name="service_price" value="{{$row->phone}}">
        </div>
        
        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="discount" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.discount')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input type="text" id="discount" class="form-control" name="discount" value="{{$row->discount}}">
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="cashback" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.cashback')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input type="text" id="cashback" class="form-control" name="cashback" value="{{$row->cashback}}">
        </div>






        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="location" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.location')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input type="text" id="location" class="form-control" name="location" value="{{$row->location}}">
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="category_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Category')}}</span>
                <span class="red-star">*</span>
            </label>
            <select id="category_id" class="js-example-basic-multiple" name="category_id[]" multiple="multiple">
                @foreach($categories as $category)
                    <option   @foreach($categoriesIdes as $categoryId) @if($categoryId==$category->id) selected @endif @endforeach value="{{$category->id}}">{{$category->name??''}}</option>
                @endforeach
            </select>

        </div>




        @foreach(languages() as $index=>$language)


            <div class="col-sm-6 pb-3 p-2">
                <label for="about_us_{{$language->abbreviation}}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1">{{helperTrans('admin.About Us')}}<span class="red-star">*</span></span>
                </label>
                <textarea name="about_us[{{$language->abbreviation}}]" id="about_us_{{$language->abbreviation}}" class="form-control " rows="5" placeholder=""></textarea>
            </div>

        @endforeach

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="latitude" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.latitude')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input type="text" id="latitude" class="form-control" name="latitude" value="{{$row->latitude}}">
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="longitude" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.longitude')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input type="text" id="longitude" class="form-control" name="longitude" value="{{$row->longitude}}">
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="phone" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.phone')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input type="text" id="longitude" class="form-control" name="phone" value="{{$row->phone}}">
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="website_link" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Website link')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input type="text" id="website_link" class="form-control" name="website_link" value="{{$row->website_link}}">
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="rating_value" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.rating value')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input type="number" id="rating_value" class="form-control" name="rating_value" value="{{$row->rating_value}}">
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="num_of_raters" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.number of raters')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input type="number" id="num_of_raters" class="form-control" name="num_of_raters" value="{{$row->num_of_raters}}">
        </div>


        <div class="form-group">
            <label for="image" class="form-control-label">{{helperTrans('admin.image')}} </label>
            <input id="image" type="file" class="dropify" name="image" data-default-file="{{get_file($row->image)}}" accept="image/*"/>
            <span
                class="form-text text-muted text-center">{{helperTrans('admin.Only the following formats are allowed: jpeg, jpg, png, gif, svg, webp, avif.')}}</span>
        </div>




    </div>
</form>

<script>
    $('.dropify').dropify();
    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();
    });
</script>

