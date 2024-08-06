<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('solution_priorities.update',$row->id)}}">
    @csrf
    @method('PUT')
    <div class="row g-4">


        <input type="hidden" name="id" value="{{$row->id}}">


        @foreach(languages() as $index=>$language)


            <div class="col-sm-6 pb-3 p-2">
                <label for="value_{{$language->abbreviation}}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1">  {{helperTrans('admin.Value')}}  ({{$language->abbreviation}})      <span class="red-star">*</span></span>
                </label>
                <textarea name="value[{{$language->abbreviation}}]" id="value_{{$language->abbreviation}}" class="form-control " rows="5"
                          placeholder="">{{$row->getTranslation('value', $language->abbreviation)}}</textarea>
            </div>

        @endforeach


    </div>
</form>

