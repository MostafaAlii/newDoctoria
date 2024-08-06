<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('pharmacy_branches.update',$row->id)}}">
    @csrf
    @method('PUT')
    <div class="row g-4">


        <input type="hidden" name="id" value="{{$row->id}}">


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="phone" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.phone')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input type="text" id="phone" class="form-control" name="phone" value="{{$row->phone}}">
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="mobile" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.mobile')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input type="text" id="mobile" class="form-control" name="mobile" value="{{$row->mobile}}">
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="email" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.email')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input type="email" id="email" class="form-control" name="email" value="{{$row->email}}">
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="whatsapp" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.whatsapp')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input type="text" id="whatsapp" class="form-control" name="whatsapp" value="{{$row->whatsapp}}">
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="governorate_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Governorate')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <select name="governorate_id" id="governorate_id" class="form-control">
                <option selected disabled>Select governorate</option>
                @foreach($governorates as $governorate)
                    <option @if($row->governorate_id==$governorate->id) selected @endif value="{{$governorate->id}}">{{$governorate->name}}</option>
                @endforeach

            </select>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="city_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.City')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <select name="city_id" id="city_id" class="form-control">
                <option selected disabled>Select Governorate First</option>

                @foreach($cities as $city)
                    <option @if($city->id==$row->city_id) selected @endif value="{{$city->id}}">{{$city->name}}</option>
                @endforeach


            </select>
        </div>



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


        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <!--begin::Label-->
            <label for="location" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.location')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input type="text" id="location" class="form-control" name="location" value="{{$row->location}}">
        </div>




    </div>
</form>

