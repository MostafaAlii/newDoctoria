<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('analysis.update',$row->id)}}">
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
            <label for="laboratory_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.laboratory')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <select class="form-control" id="laboratory_id" name="laboratory_id">
                <option selected disabled>{{helperTrans('admin.Select Laboratory')}}</option>

                @foreach($laboratories as $laboratory)
                    <option @if($row->laboratory_id==$laboratory->id) selected @endif value="{{$laboratory->id}}">{{$laboratory->name}}</option>
                @endforeach

            </select>
        </div>




    </div>
</form>


<script>
    $('.dropify').dropify();

</script>
