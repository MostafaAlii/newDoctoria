@extends('Admin.layouts.inc.app')
@section('title')
    {{helperTrans('admin.General Setting')}}
@endsection
@section('css')

    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" rel="stylesheet"/>

@endsection

{{--@section('page-title')--}}
{{--    General Settings--}}
{{--@endsection--}}



@section('content')

    <div class="card">
        <div class="card-header ">
            <h5 class="card-title mb-0 flex-grow-1"> {{helperTrans('admin.General Settings')}} </h5>


            <form id="form" enctype="multipart/form-data" method="POST" action="{{route('settings.store')}}">
                @csrf
                <div class="row my-4 g-4">




                    <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                        <label for="logo_header" class="form-control-label fs-6 fw-bold "> {{helperTrans('admin.Logo')}} </label>
                        <input type="file" class="dropify" name="logo_header" data-default-file="{{get_file($settings->logo_header)}}" accept="image/*"/>
                        <span class="form-text text-muted text-center">{{helperTrans('admin.Only the following formats are allowed: jpeg, jpg, png, gif, svg, webp, avif.')}}</span>
                    </div>


                    <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                        <label for="fave_icon" class="form-control-label fs-6 fw-bold ">  {{helperTrans('admin.Icon')}}  </label>
                        <input type="file" id="fave_icon" class="dropify" name="fave_icon" data-default-file="{{get_file($settings->fave_icon)}}" accept="image/*"/>
                        <span class="form-text text-muted text-center">{{helperTrans('admin.Only the following formats are allowed: jpeg, jpg, png, gif, svg, webp, avif.')}}</span>
                    </div>


                    <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                        <label for="facebook_icon" class="form-control-label fs-6 fw-bold ">  {{helperTrans('admin.facebook_icon')}}  </label>
                        <input type="file" id="facebook_icon" class="dropify" name="facebook_icon" data-default-file="{{get_file($settings->facebook_icon)}}" accept="image/*"/>
                        <span class="form-text text-muted text-center">{{helperTrans('admin.Only the following formats are allowed: jpeg, jpg, png, gif, svg, webp, avif.')}}</span>
                    </div>
                    <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                        <label for="website_icon" class="form-control-label fs-6 fw-bold ">  {{helperTrans('admin.website_icon')}}  </label>
                        <input type="file" id="website_icon" class="dropify" name="website_icon" data-default-file="{{get_file($settings->website_icon)}}" accept="image/*"/>
                        <span class="form-text text-muted text-center">{{helperTrans('admin.Only the following formats are allowed: jpeg, jpg, png, gif, svg, webp, avif.')}}</span>
                    </div>
                    <div class="d-flex flex-column mb-7 fv-row col-sm-2">
                        <label for="email_icon" class="form-control-label fs-6 fw-bold ">  {{helperTrans('admin.email_icon')}}  </label>
                        <input type="file" id="email_icon" class="dropify" name="email_icon" data-default-file="{{get_file($settings->email_icon)}}" accept="image/*"/>
                        <span class="form-text text-muted text-center">{{helperTrans('admin.Only the following formats are allowed: jpeg, jpg, png, gif, svg, webp, avif.')}}</span>
                    </div>
                    <div class="d-flex flex-column mb-7 fv-row col-sm-2">
                        <label for="phone_icon" class="form-control-label fs-6 fw-bold ">  {{helperTrans('admin.phone_icon')}}  </label>
                        <input type="file" id="phone_icon" class="dropify" name="phone_icon" data-default-file="{{get_file($settings->phone_icon)}}" accept="image/*"/>
                        <span class="form-text text-muted text-center">{{helperTrans('admin.Only the following formats are allowed: jpeg, jpg, png, gif, svg, webp, avif.')}}</span>
                    </div>

                    <div class="d-flex flex-column mb-7 fv-row col-sm-2">
                        <label for="fave_icon" class="form-control-label fs-6 fw-bold ">  {{helperTrans('admin.google_icon')}}  </label>
                        <input type="file" id="google_icon" class="dropify" name="google_icon" data-default-file="{{get_file($settings->google_icon)}}" accept="image/*"/>
                        <span class="form-text text-muted text-center">{{helperTrans('admin.Only the following formats are allowed: jpeg, jpg, png, gif, svg, webp, avif.')}}</span>
                    </div>

                    <div class="d-flex flex-column mb-7 fv-row col-sm-4">
                        <label for="facebook" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="required mr-1">  {{helperTrans('admin.Facebook')}}</span>
                        </label>
                        <input id="facebook" type="text" class="form-control form-control-solid" name="facebook" value="{{$settings->facebook}}"/>
                    </div>

                    <div class="d-flex flex-column mb-7 fv-row col-sm-4">
                        <label for="website" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="required mr-1">  {{helperTrans('admin.website')}}</span>
                        </label>
                        <input id="website" type="text" class="form-control form-control-solid" name="website" value="{{$settings->website}}"/>
                    </div>
                    
                    <div class="d-flex flex-column mb-7 fv-row col-sm-4">
                        <label for="facebook" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="required mr-1">  {{helperTrans('admin.email')}}</span>
                        </label>
                        <input id="email" type="email" class="form-control form-control-solid" name="email" value="{{$settings->email}}"/>
                    </div>

                    <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                        <label for="phone" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="required mr-1">  {{helperTrans('admin.phone')}}</span>
                        </label>
                        <input id="phone" type="text" class="form-control form-control-solid" name="phone" value="{{$settings->phone}}"/>
                    </div>


                    <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                        <label for="google" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="required mr-1">  {{helperTrans('admin.google')}}</span>
                        </label>
                        <input id="google" type="text" class="form-control form-control-solid" name="google" value="{{$settings->google}}"/>
                    </div>

                    <div class="d-flex flex-column mb-7 fv-row col-sm-12">
                        <label for="app_name" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="required mr-1">  {{helperTrans('admin.App Name')}}</span>
                        </label>
                        <input id="app_name" type="text" class="form-control form-control-solid" name="app_name" value="{{$settings->app_name}}"/>
                    </div>



                    @foreach(languages() as $index=>$language)


                        <div class="col-sm-6 pb-3 p-2">
                            <label for="privacy_{{$language->abbreviation}}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                <span class="required mr-1">  {{helperTrans('admin.Privacy')}}  ({{$language->abbreviation}})      </span>
                            </label>
                            <textarea name="privacy[{{$language->abbreviation}}]" id="privacy_{{$language->abbreviation}}" class="form-control " rows="5"
                                      placeholder="">{{$settings->getTranslation('privacy', $language->abbreviation)}}</textarea>
                        </div>

                    @endforeach
                    @foreach(languages() as $index=>$language)


                        <div class="col-sm-6 pb-3 p-2">
                            <label for="about_{{$language->abbreviation}}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                <span class="required mr-1">  {{helperTrans('admin.about')}}  ({{$language->abbreviation}})      </span>
                            </label>
                            <textarea name="about[{{$language->abbreviation}}]" id="about_{{$language->abbreviation}}" class="form-control " rows="5"
                                      placeholder="">{{$settings->getTranslation('about', $language->abbreviation)}}</textarea>
                        </div>

                    @endforeach





                    <div class="my-4">
                        <button type="submit" class="btn btn-success"> {{helperTrans('admin.Update')}}</button>
                    </div>


                </div>
            </form>

        </div>
    </div>

@endsection

@section('js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>


    <script>
        $('.dropify').dropify();

    </script>


    <script>
        // CKEDITOR.replace('privacy');


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

                complete: function () {
                },
                success: function (data) {

                    window.setTimeout(function () {

// $('#product-model').modal('hide')
                        if (data.code == 200) {
                            toastr.success(data.message)
                        } else {
                            toastr.error(data.message)
                        }
                    }, 1000);


                },
                error: function (data) {
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
