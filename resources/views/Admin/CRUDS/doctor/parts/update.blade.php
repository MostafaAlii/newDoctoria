@extends('Admin.layouts.inc.app')
@section('title')
    {{helperTrans('admin.Doctors')}}
@endsection
@section('css')

    <style>
        .select2-container {
            z-index: 10000; /* Adjust the value as needed */
        }

    </style>

@endsection
@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1">{{helperTrans('admin.Doctors')}}</h5>

                <div>
                    <button id="addBtn" class="btn btn-primary"> {{helperTrans('admin.Request Update Doctor')}}</button>
                </div>


        </div>
        <div class="card-body">
           
            <form id="form" enctype="multipart/form-data" method="POST" action="{{route('update.doctor.approved',$row->id)}}">
                @csrf
                @method('post')
                <div class="row g-4">


                    <input type="hidden" name="id" value="{{$row->id}}">


                    <div class="form-group">
                        <label for="image" class="form-control-label">{{helperTrans('admin.image')}} </label>
                        <input id="image" type="file" class="dropify" name="image" data-default-file="{{get_file($row->image)}}" accept="image/*"/>
                        <span
                            class="form-text text-muted text-center">{{helperTrans('admin.Only the following formats are allowed: jpeg, jpg, png, gif, svg, webp, avif.')}}</span>
                    </div>



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
                            name="email" value="{{$row->email}}"/>
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
                        <label for="lang" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="required mr-1"> {{helperTrans('admin.lang')}}</span>
                            <span class="red-star">*</span>
                        </label>
                        <!--end::Label-->
                        <input id="lang" type="text" class="form-control form-control-solid" placeholder=" " name="lang"
                            value="{{$row->lang}}"/>
                    </div>

                    <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                        <!--begin::Label-->
                        <label for="latitude" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="required mr-1"> {{helperTrans('admin.Latitude')}}</span>
                            <span class="red-star">*</span>
                        </label>
                        <!--end::Label-->
                        <input id="latitude" type="text" class="form-control form-control-solid" placeholder=" " name="latitude"
                            value="{{$row->latitude}}"/>
                    </div>

                    <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                        <!--begin::Label-->
                        <label for="longitude" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="required mr-1"> {{helperTrans('admin.Longitude')}}</span>
                            <span class="red-star">*</span>
                        </label>
                        <!--end::Label-->
                        <input id="longitude" type="text" class="form-control form-control-solid" placeholder=" " name="longitude"
                            value="{{$row->longitude}}"/>
                    </div>


                    <div class="d-flex flex-column mb-7 fv-row col-sm-4">
                        <!--begin::Label-->
                        <label for="location" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="required mr-1"> {{helperTrans('admin.Location')}}</span>
                            <span class="red-star">*</span>
                        </label>
                        <!--end::Label-->
                        <input id="location" type="text" class="form-control form-control-solid" placeholder=" " name="location"
                            value="{{$row->location}}"/>
                    </div>








                    @foreach(languages() as $index=>$language)


                        <div class="col-sm-6 pb-3 p-2">
                            <label for="about_{{$language->abbreviation}}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                <span class="required mr-1">  {{helperTrans('admin.About')}}  ({{$language->abbreviation}})     </span>
                            </label>
                            <textarea name="about[{{$language->abbreviation}}]" id="about_{{$language->abbreviation}}" class="form-control " rows="5"
                                    placeholder="">{{$row->getTranslation('about', $language->abbreviation)}}</textarea>
                        </div>

                    @endforeach


                    <div class="text-center">
        
                        <input type="submit" id="submit" class="btn btn-danger" name="submit" value="{{helperTrans('admin.Reject')}}">

                        <input type="submit" id="submit" class="btn btn-success" name="submit" value="{{helperTrans('admin.Approved')}}">
                    </div>


                </div>
            </form>
        </div>
    </div>

   

@endsection
@section('js')

    <link href="{{url('assets/dashboard/css/select2.css')}}" rel="stylesheet"/>
    <script src="{{url('assets/dashboard/js/select2.js')}}"></script>

 
@endsection


<script>
    $('.dropify').dropify();
    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();
    });
</script>

