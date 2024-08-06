<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('medical_bags.update',$row->id)}}">
    @csrf
    @method('PUT')
    <div class="row g-4">


        <input type="hidden" name="id" value="{{$row->id}}">

        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <!--begin::Label-->
            <label for="value" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Value')}}</span>
                <span class="red-star">*</span>
            </label>

            <!--end::Label-->
            <input id="value" required type="number" step="any" class="form-control form-control-solid"
                   placeholder="" name="value" value="{{$row->value}}"/>
        </div>





    </div>
</form>

