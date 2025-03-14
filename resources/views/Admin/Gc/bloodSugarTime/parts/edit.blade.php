<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('gc_blood_sugar_times.update',$row->id)}}">
    @csrf
    @method('PUT')
    <div class="row g-4">


        <input type="hidden" name="id" value="{{$row->id}}">

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="time" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Time')}}</span>
                <span class="red-star">*</span>
            </label>

            <!--end::Label-->
            <input id="time" required type="time" class="form-control form-control-solid"
                   placeholder="" name="time" value="{{$row->time}}"/>
        </div>


    </div>
</form>

