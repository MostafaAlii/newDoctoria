@extends('Admin.layouts.inc.app')
@section('title')
    {{helperTrans('admin.Doctor Times')}}
@endsection
@section('css')



@endsection
@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1">{{helperTrans('admin.Times For Doctor')}}
                {{$doctor->name}}
            </h5>

            <div>
                <button id="addNewRow" class="btn btn-primary"> {{helperTrans('admin.Add New Time')}}</button>
            </div>

        </div>
        <form id="form" enctype="multipart/form-data" method="POST" action="{{route('admin.update_doctor_times',$doctor->id)}}">
            @csrf
            <div class="card-body" id="containerData">
                @foreach($doctorTimes as $doctorTime)
                    <div class="card" id="row_{{$doctorTime->id}}">
                        <div class="card-header text-center">
                            <span data-id="{{$doctorTime->id}}" class="text-center text-danger deleteRow"
                                  style="cursor: pointer"><i class="fa fa-trash"></i></span>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">

                                <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                                    <!--begin::Label-->
                                    <label for="category_id_{{$doctorTime->id}}"
                                           class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                        <span class="required mr-1">{{helperTrans('admin.Category')}} <span
                                                class="red-star">*</span></span>
                                    </label>
                                    <!--end::Label-->
                                    <select required name="category_id[]" id="category_id_{{$doctorTime->id}}"
                                            class="form-control">
                                        <option selected disabled>Select Category</option>

                                        @foreach($categories as $category)
                                            <option @if($category->id==$doctorTime->category_id) selected
                                                    @endif value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach

                                    </select>
                                </div>


                                <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                                    <!--begin::Label-->
                                    <label for="day_id_{{$doctorTime->id}}"
                                           class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                        <span class="required mr-1">{{helperTrans('admin.Day')}} <span class="red-star">*</span></span>
                                    </label>
                                    <!--end::Label-->
                                    <select required name="day_id[]" id="day_id_{{$doctorTime->id}}"
                                            class="form-control">
                                        <option selected disabled>Select Day</option>

                                        @foreach($days as $day)
                                            <option @if($day->id==$doctorTime->day_id) selected
                                                    @endif value="{{$day->id}}">{{$day->day}}</option>
                                        @endforeach

                                    </select>
                                </div>


                                <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                                    <!--begin::Label-->
                                    <label for="type_{{$doctorTime->id}}"
                                           class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                        <span class="required mr-1">{{helperTrans('admin.Type')}} <span
                                                class="red-star">*</span></span>
                                    </label>
                                    <!--end::Label-->
                                    <select required name="type[]" id="type_{{$doctorTime->id}}" class="form-control">
                                        <option selected disabled>Select Type</option>
                                        <option @if($doctorTime->type=='online') selected @endif value="online">Online</option>
                                        <option @if($doctorTime->type=='offline') selected @endif  value="offline">Offline</option>
                                        <option @if($doctorTime->type=='home') selected @endif  value="home">Home</option>

                                    </select>
                                </div>


                                <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                    <!--begin::Label-->
                                    <label for="from_time_{{$doctorTime->id}}"
                                           class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                        <span class="required mr-1">{{helperTrans('admin.From Time')}} <span
                                                class="red-star">*</span></span>
                                    </label>

                                    <input type="time" class="form-control" id="from_time_{{$doctorTime->id}}"
                                           name="from_time[]" value="{{$doctorTime->from_time}}">

                                </div>


                                <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                    <!--begin::Label-->
                                    <label for="to_time_{{$doctorTime->id}}"
                                           class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                        <span class="required mr-1">{{helperTrans('admin.To Time')}} <span
                                                class="red-star">*</span></span>
                                    </label>

                                    <input type="time" class="form-control" id="to_time_{{$doctorTime->id}}"
                                           name="to_time[]" value="{{$doctorTime->to_time}}">

                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mb-4">
                <button form="form" type="submit" id="submit"
                        class="btn btn-outline-primary">{{helperTrans('admin.Update')}}</button>
            </div>

        </form>
    </div>

@endsection
@section('js')

    <script>
        $(document).on('click', '.deleteRow', function () {

            var row_id = $(this).attr('data-id');

            $(`#row_${row_id}`).remove();

        })
    </script>

    <script>
        $(document).on('click', '#addNewRow', function () {


            var random = Math.floor(Math.random() * (999999999999 - 999 + 1)) + 999999999;

            var html = `


                            <div class="card" id="row_${random}">
                    <div class="card-header text-center">
                        <span data-id="${random}" class="text-center text-danger deleteRow" style="cursor: pointer"><i  class="fa fa-trash"></i></span>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">

                            <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                                <!--begin::Label-->
                                <label for="category_id_${random}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span class="required mr-1">{{helperTrans('admin.Category')}} <span class="red-star">*</span></span>
                                </label>
                                <!--end::Label-->
                                <select required name="category_id[]" id="category_id_${random}" class="form-control">
                                    <option selected disabled>Select Category</option>

                                    @foreach($categories as $category)
            <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach

            </select>
       </div>



       <div class="d-flex flex-column mb-7 fv-row col-sm-6">
        <!--begin::Label-->
           <label for="day_id_${random}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span class="required mr-1">{{helperTrans('admin.Day')}} <span class="red-star">*</span></span>
                                </label>
                                <!--end::Label-->
                                <select required name="day_id[]" id="day_id_${random}" class="form-control">
                                    <option selected disabled>Select Day</option>

                                    @foreach($days as $day)
            <option  value="{{$day->id}}">{{$day->day}}</option>
                                    @endforeach

            </select>
         </div>



         <div class="d-flex flex-column mb-7 fv-row col-sm-6">
          <!--begin::Label-->
            <label for="type_${random}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span class="required mr-1">{{helperTrans('admin.Type')}} <span class="red-star">*</span></span>
                                </label>
                                <!--end::Label-->
                                <select required name="type[]" id="type_${random}" class="form-control">
                                    <option selected disabled>Select Type</option>
                                    <option  value="online">On Line</option>
                                    <option  value="offline">Off Line</option>
                                    <option  value="home">Home</option>
                                </select>
                            </div>



                            <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                <!--begin::Label-->
                                <label for="from_time_${random}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span class="required mr-1">{{helperTrans('admin.From Time')}} <span class="red-star">*</span></span>
                                </label>

                                <input type="time" class="form-control" id="from_time_${random}" name="from_time[]" value="">

                            </div>


                            <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                <!--begin::Label-->
                                <label for="to_time_${random}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span class="required mr-1">{{helperTrans('admin.To Time')}} <span class="red-star">*</span></span>
                                </label>

                                <input type="time" class="form-control" id="to_time_${random}" name="to_time[]" value="">

                            </div>

                        </div>
                    </div>
                </div>



            `;

            $('#containerData').append(html);


        });

    </script>


    <script>
        $(document).on('submit', "form#form", function (e) {
            e.preventDefault();

            var formData = new FormData(this);

            var url = $('#form').attr('action');
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                beforeSend: function () {


                    $('#submit').html('<span class="spinner-border spinner-border-sm mr-2" ' +
                        ' ></span> <span style="margin-left: 4px;">{{helperTrans('admin.Work is underway')}}</span>').attr('disabled', true);
                },
                complete: function () {
                },
                success: function (data) {

                    window.setTimeout(function () {

// $('#product-model').modal('hide')
                        if (data.code == 200) {
                            toastr.success(data.message)
                            $('#submit').html('Update').attr('disabled', false);

                        } else {
                            toastr.error(data.message)
                            $('#submit').html('{{helperTrans('admin.Update')}}').attr('disabled', false);

                        }
                    }, 1000);


                },
                error: function (data) {
                    $('#submit').html('Update').attr('disabled', false);
                    if (data.status === 500) {
                        toastr.error('{{helperTrans('admin.there is an error')}}')
                    }

                    if (data.status === 422) {
                        var errors = $.parseJSON(data.responseText);

                        $.each(errors, function (key, value) {
                            if ($.isPlainObject(value)) {
                                $.each(value, function (key, value) {
                                    toastr.error(value)
                                });

                            } else {

                            }
                        });
                    }
                    if (data.status == 421) {
                        toastr.error(data.message)
                    }

                },//end error method

                cache: false,
                contentType: false,
                processData: false
            });
        });

    </script>

@endsection
