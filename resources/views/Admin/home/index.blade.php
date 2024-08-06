@extends('Admin.layouts.inc.app')
@section('title')
    {{helperTrans('admin.Home')}}
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css"/>

@endsection
@section('content')
    <div class="row">
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <a href="{{route('admins.index')}}" class="text-center bg-white d-block  rounded-3 mb-3">
                <p class="text-uppercase fw-bold text-white text-truncate rounded-3 bg-primary p-2 mb-0">
                    {{helperTrans('admin.Admins')}} </p>
                <h2 class="py-4 mb-0 text-primary"><span class="counter-value" data-target="{{$admins}}">0</span>
                </h2>
            </a>
        </div><!-- end col -->
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <a href="{{route('patients.index')}}" class="text-center bg-white d-block  rounded-3 mb-3">
                <p class="text-uppercase fw-bold text-white text-truncate rounded-3 bg-warning p-2 mb-0">
                    {{helperTrans('admin.Patients')}} </p>
                <h2 class="py-4 mb-0 text-warning"><span class="counter-value" data-target="{{$patients}}">0</span>
                </h2>
            </a>
        </div><!-- end col -->

        <div class="col-xl-3 col-lg-4 col-sm-6">
            <a href="{{route('doctors.index')}}" class="text-center bg-white d-block  rounded-3 mb-3">
                <p class="text-uppercase fw-bold text-white text-truncate rounded-3 bg-dark p-2 mb-0">
                   {{helperTrans('admin.Doctors')}} </p>
                <h2 class="py-4 mb-0 text-info"><span class="counter-value"
                                                      data-target="{{$doctors}}">0</span>
                    <span class="fs-5 text-muted">  </span>
                </h2>
            </a>
        </div><!-- end col -->
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <a href="{{route('languages.index')}}" class="text-center bg-white d-block  rounded-3 mb-3">
                <p class="text-uppercase fw-bold text-white text-truncate rounded-3 bg-danger p-2 mb-0">
                   {{helperTrans('admin.Languages')}} </p>
                <h2 class="py-4 mb-0 text-danger"><span class="counter-value"
                                                        data-target="{{$languages}}">0</span>
                    <span class="fs-5 text-muted">  </span>
                </h2>
            </a>
        </div><!-- end col -->




        <div class="col-xl-3 col-lg-4 col-sm-6">
            <a href="{{route('laboratories.index')}}" class="text-center bg-white d-block  rounded-3 mb-3">
                <p class="text-uppercase fw-bold text-white text-truncate rounded-3 bg-info p-2 mb-0">
                    {{helperTrans('admin.Laboratories')}} </p>
                <h2 class="py-4 mb-0 text-primary"><span class="counter-value" data-target="{{$laboratories}}">0</span>
                </h2>
            </a>
        </div><!-- end col -->
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <a href="{{route('medical_file_patients.index')}}" class="text-center bg-white d-block  rounded-3 mb-3">
                <p class="text-uppercase fw-bold text-white text-truncate rounded-3 bg-danger p-2 mb-0">
                    {{helperTrans('admin.Medical Files')}}    </p>
                <h2 class="py-4 mb-0 text-warning"><span class="counter-value" data-target="{{$medical_files}}">0</span>
                </h2>
            </a>
        </div><!-- end col -->

        <div class="col-xl-3 col-lg-4 col-sm-6">
            <a  href="{{route('medical_bags.index')}}" class="text-center bg-white d-block  rounded-3 mb-3">
                <p class="text-uppercase fw-bold text-white text-truncate rounded-3 bg-secondary p-2 mb-0">
                    {{helperTrans('admin.Medical Bags')}}  </p>
                <h2 class="py-4 mb-0 text-info"><span class="counter-value"
                                                      data-target="{{$medical_bags}}">0</span>
                    <span class="fs-5 text-muted">  </span>
                </h2>
            </a>
        </div><!-- end col -->
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <a href="{{route('analysis.index')}}" class="text-center bg-white d-block  rounded-3 mb-3">
                <p class="text-uppercase fw-bold text-white text-truncate rounded-3 bg-success p-2 mb-0">
                    {{helperTrans('admin.Analysis')}}  </p>
                <h2 class="py-4 mb-0 text-danger"><span class="counter-value"
                                                        data-target="{{$analysis}}">0</span>
                    <span class="fs-5 text-muted">  </span>
                </h2>
            </a >
        </div><!-- end col -->







    </div><!-- end row -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">  {{helperTrans('admin.Bookings')}}</h4>

                    <div class="row">
                        <div id="calendar"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script src="https://washsquadsa.com/admin/plugins/calendar/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/ar.min.js" integrity="sha512-gVMzWflhCRdT4UPPUzNR9gCPtBZuc77GZxVx2CqSZyv0kEPIISiZEU0hk6Sb/LLSO87j4qXH/m9Iz373K+mufw==" crossorigin="anonymous"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#calendar').fullCalendar({
            defaultView: 'month',
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            isRTL: true,
            locale: 'en',
            lang: 'en',
            editable: false,
            disableDragging: true,
            eventLimit: true, // allow "more" link when too many events
            selectable: true,
            events: '{{route('admin.calender')}}',
            eventRender: function (event, element, view) {
                var sup = element.find('.fc-content');
                var con = sup.closest('span');
                var day_title = 'Number Of Booking';
                var eventInfo = `<div class="clickable-content">${day_title}<br>${event.title}<br><br><button  data-date="${event.start.format('YYYY-MM-DD')}" id="${event.ids}" class="click_me btn btn-outline-danger text-white d-none">{{helperTrans('admin.Details')}}</button></div>`;
                sup.html(eventInfo);
            }
        });


        // Add click event for clickable content
        $(document).on('click', '.clickable-content', function (e) {
            e.preventDefault();
            var date = $(this).find('.click_me').data('date');
            var route="{{route('bookings.index')}}?date="+date;

            window.location.href=route;
        });
    </script>



@endsection
