<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('employees.update',$row->id)}}">
    @csrf
    @method('PUT')
    <div class="row g-4">


        <input type="hidden" name="id" value="{{$row->id}}">



        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="name" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.name')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input id="name" required type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{$row->name}}"/>
        </div>



        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="nickname" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.nickname')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <input id="nickname" required type="text" class="form-control form-control-solid" placeholder="" name="nickname" value="{{$row->nickname}}"/>
        </div>

        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="email" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.email')}} </span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <input id="email" required type="email" class="form-control form-control-solid" placeholder=" {{helperTrans('admin.email')}}"
                   name="email" value="{{$row->employee}}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="phone" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> {{helperTrans('admin.Phone')}}</span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <input id="phone" type="text" class="form-control form-control-solid" placeholder=" " name="phone"
                   value="{{$row->phone}}"/>
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.password')}}</span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <input type="password" class="form-control form-control-solid" placeholder=" " name="password" value=""/>
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="gender" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Gender')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <select name="gender" id="gender" class="form-control">
                <option selected disabled>Select Gender</option>
                <option @if($row->gender=='male') selected @endif value="male">Male</option>
                <option @if($row->gender=='female') selected @endif value="female">Female</option>

            </select>
        </div>






        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="type_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Type')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <select name="type_id" id="type_id" class="form-control">
                <option selected disabled>Select Type</option>
                @foreach($types as $type)
                    <option @if($row->type_id==$type->id) selected @endif value="{{$type->id}}">{{$type->name}}</option>
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
                <option selected disabled>Select City</option>
                @foreach($cities as $city)
                    <option @if($row->city_id==$city->id) selected @endif value="{{$city->id}}">{{$city->name}}</option>
                @endforeach

            </select>
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="experience_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{helperTrans('admin.Experience')}} <span class="red-star">*</span></span>
            </label>
            <!--end::Label-->
            <select name="experience_id" id="experience_id" class="form-control">
                <option selected disabled>Select Experience</option>
                @foreach($experiences as $experience)
                    <option @if($row->experience_id==$experience->id) selected @endif value="{{$experience->id}}">{{$experience->name}}</option>
                @endforeach

            </select>
        </div>








    </div>
</form>

