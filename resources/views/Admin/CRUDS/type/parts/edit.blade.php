<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('types.update',$row->id)}}">
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



        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <!--begin::Label-->
            <label for="category_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Category')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <select name="category_id" id="category_id" class="form-control">
                <option selected disabled>Select Category</option>
                @foreach($categories as $category)
                    <option @if($row->category_id==$category->id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                @endforeach

            </select>
        </div>



    </div>
</form>

