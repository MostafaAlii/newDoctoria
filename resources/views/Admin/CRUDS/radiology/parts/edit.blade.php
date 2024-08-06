<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('radiology.update',$row->id)}}">
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
            <label for="radiology_center_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Radiology Center')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <select class="form-control" id="radiology_center_id" name="radiology_center_id">
                <option selected disabled>{{helperTrans('admin.Select Radiology')}}</option>

                @foreach($radiology_centers as $radiology_center)
                    <option @if($row->radiology_center_id==$radiology_center->id) selected @endif value="{{$radiology_center->id}}">{{$radiology_center->name}}</option>
                @endforeach

            </select>
        </div>







    </div>
</form>


<script>
    $('.dropify').dropify();

</script>
