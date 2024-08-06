<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('sc_services.update',$row->id)}}">
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
                <label for="description_{{$language->abbreviation}}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1">  {{helperTrans('admin.description')}}       <span class="red-star">*</span></span>
                </label>
                <textarea name="description[{{$language->abbreviation}}]" id="description_{{$language->abbreviation}}" class="form-control " rows="5"
                          placeholder="">{{$row->getTranslation('description', $language->abbreviation)}}</textarea>
            </div>

        @endforeach





        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="price" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Price')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input type="number" id="price" class="form-control" name="price" value="{{$row->price}}">
        </div>



        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="sessions_non" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.sessions non')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input type="text" id="sessions_non" class="form-control" name="sessions_non" value="{{$row->sessions_non}}">
        </div>



        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="have_request" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Have Request')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input type="text" id="have_request" class="form-control" name="have_request" value="{{$row->have_request}}">
        </div>




        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="experience_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Experience')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <select class="form-control" id="experience_id" name="experience_id">
                <option selected disabled>Select Experience</option>

                @foreach( $experiences as $experience)
                    <option  @if($experience->id==$row->experience_id) selected @endif value="{{$experience->id}}">{{$experience->name}}</option>
                @endforeach

            </select>
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="sc_type_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Sc Type')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <select class="form-control" id="sc_type_id" name="sc_type_id">
                <option selected disabled>Select Sc Type</option>

                @foreach( $scTypes as $scType)
                    <option @if($scType->id==$row->sc_type_id) selected @endif value="{{$scType->id}}">{{$scType->name}}</option>
                @endforeach

            </select>
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="addon_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Addon')}}</span>
                <span class="red-star">*</span>
            </label>
            <select id="addon_id" class="js-example-basic-multiple" name="addon_id[]" multiple="multiple">
                @foreach($scAddons as $scAddon)
                    <option @foreach($addon_ides as $addon_id) @if($addon_id==$scAddon->id) selected @endif @endforeach value="{{$scAddon->id}}">{{$scAddon->name??''}}</option>
                @endforeach
            </select>

        </div>







    </div>
</form>
<script>
    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();
    });
</script>
