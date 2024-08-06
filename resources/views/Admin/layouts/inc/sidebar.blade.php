<!-- ========== App Menu ========== -->

<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{route('admin.index')}}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{get_file(setting()->logo_header)}}" alt="" height="22">
                    </span>
            <span class="logo-lg">
                        <img src="{{get_file(setting()->logo_header)}}" alt="" height="40">
                    </span>
        </a>
        <!-- Light Logo-->
        <a href="{{route('admin.index')}}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{get_file(setting()->logo_header)}}" alt="" height="22">
                    </span>
            <span class="logo-lg">
                        <img src="{{get_file(setting()->logo_header)}}" alt="" height="40">
                    </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('admin.index')}}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards"> {{helperTrans('admin.Dashboard')}}</span>
                    </a>
                </li>

                <!-- end Dashboard Menu -->
                @if(auth()->guard('admin')->user()->hasPermission('languages_read'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('languages.index')}}">
                        <i class="fa fa-language"></i> <span data-key="t-dashboards">  {{helperTrans('admin.Languages')}} </span>
                    </a>
                </li>
                @endif

                @if(auth()->guard('admin')->user()->hasPermission('roles_read'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('roles.index')}}">
                        <i class="fa fa-user-secret"></i> <span data-key="t-dashboards">  {{helperTrans('admin.Roles')}} </span>
                    </a>
                </li>
                @endif

                @if(auth()->guard('admin')->user()->hasPermission('admins_read'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('admins.index')}}">
                        <i class="fa fa-user-secret"></i> <span data-key="t-dashboards">  {{helperTrans('admin.Admins')}} </span>
                    </a>
                </li>
                @endif
                <!-- end Dashboard Menu -->


{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link menu-link" href="#patients" data-bs-toggle="collapse" role="button"--}}
{{--                       aria-expanded="false" aria-controls="reports">--}}
{{--                        <i class="fa-solid fa-kit-medical"></i>--}}
{{--                        <span data-key="t-apps">       {{helperTrans('admin.Patients')}}  </span>--}}
{{--                    </a>--}}
{{--                    <div class="collapse menu-dropdown" id="patients">--}}
{{--                        <ul class="nav nav-sm flex-column">--}}
{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link menu-link"--}}
{{--                                   href="{{route('medical_bags.index')}}">--}}
{{--                                    <span data-key="t-dashboards">  {{helperTrans('admin.Medical Bags')}}</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}


{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link menu-link"--}}
{{--                                   href="{{route('medical_file_patients.index')}}">--}}
{{--                                    <span data-key="t-dashboards">  {{helperTrans('admin.Medical File')}}</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}

{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </li>--}}
                <!-- Start Main Settings -->
                @if(auth()->guard('admin')->user()->hasPermission('settings_read'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#main_settings" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="reports">
                        <i class="fa fa-user-md"></i>
                        <span data-key="t-apps">General Main Setting</span>
                    </a>
                    <div class="collapse menu-dropdown" id="main_settings">
                        <ul class="nav nav-sm flex-column">
                            @if(auth()->guard('admin')->user()->hasPermission('settings_read'))
                            <li class="nav-item">
                                <a class="nav-link menu-link"
                                   href="{{route('main_otp.index')}}">
                                    <span data-key="t-dashboards">OTP Providers</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif
                <!-- End Main Settings -->
                <!-- end Patients Menu -->
                @if(auth()->guard('admin')->user()->hasPermission('doctors_read') || auth()->guard('admin')->user()->hasPermission('provider_types_read') || auth()->guard('admin')->user()->hasPermission('providers_read') || auth()->guard('admin')->user()->hasPermission('laboratories_read') || auth()->guard('admin')->user()->hasPermission('analysis_read') || auth()->guard('admin')->user()->hasPermission('radiology_centers_read') || auth()->guard('admin')->user()->hasPermission('insurance_people_read') || auth()->guard('admin')->user()->hasPermission('insurance_companies_read'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#providers" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="reports">
                        <i class="fa fa-user-md"></i>
                        <span data-key="t-apps">       {{helperTrans('admin.Providers')}}  </span>
                    </a>
                    <div class="collapse menu-dropdown" id="providers">
                        <ul class="nav nav-sm flex-column">
                            @if(auth()->guard('admin')->user()->hasPermission('doctors_read'))
                            <li class="nav-item">
                                <a class="nav-link menu-link"
                                   href="{{route('doctors.index')}}">
                                    <span data-key="t-dashboards">  {{helperTrans('admin.Doctors')}}</span>
                                </a>
                            </li>
                            @endif

                            @if(auth()->guard('admin')->user()->hasPermission('provider_types_read'))
                            <li class="nav-item">
                                <a class="nav-link menu-link"
                                   href="{{route('provider_types.index')}}">
                                    <span data-key="t-dashboards">  {{helperTrans('admin.Provider Types')}}</span>
                                </a>
                            </li>
                            @endif

                            @if(auth()->guard('admin')->user()->hasPermission('providers_read'))
                            <li class="nav-item">
                                <a class="nav-link menu-link"
                                   href="{{route('providers.index')}}">
                                    <span data-key="t-dashboards">  {{helperTrans('admin.Providers')}}</span>
                                </a>
                            </li>
                            @endif

                            @if(auth()->guard('admin')->user()->hasPermission('laboratories_read'))
                            <li class="nav-item">
                                <a class="nav-link menu-link"
                                   href="{{route('laboratories.index')}}">
                                    <span data-key="t-dashboards">  {{helperTrans('admin.Laboratories')}}</span>
                                </a>
                            </li>

                            @endif

                            @if(auth()->guard('admin')->user()->hasPermission('analysis_read'))
                            <li class="nav-item">
                                <a class="nav-link menu-link"
                                   href="{{route('analysis.index')}}">
                                    <span data-key="t-dashboards">  {{helperTrans('admin.Analysis')}}</span>
                                </a>
                            </li>

                            @endif

                            @if(auth()->guard('admin')->user()->hasPermission('radiology_centers_read'))
                            <li class="nav-item">
                                <a class="nav-link menu-link"
                                   href="{{route('radiology_centers.index')}}">
                                    <span data-key="t-dashboards">  {{helperTrans('admin.Radiology Center')}}</span>
                                </a>
                            </li>
                            @endif

                            @if(auth()->guard('admin')->user()->hasPermission('insurance_people_read'))
                            <li class="nav-item">
                                <a class="nav-link menu-link"
                                   href="{{route('insurance_people.index')}}">
                                    <span data-key="t-dashboards">  {{helperTrans('admin.Insurance People')}}</span>
                                </a>
                            </li>
                            @endif

                            @if(auth()->guard('admin')->user()->hasPermission('insurance_companies_read'))
                            <li class="nav-item">
                                <a class="nav-link menu-link"
                                   href="{{route('insurance_companies.index')}}">
                                    <span data-key="t-dashboards">  {{helperTrans('admin.Insurance Company')}}</span>
                                </a>
                            </li>
                            @endif



                        </ul>
                    </div>
                </li>
                @endif

                @if(auth()->guard('admin')->user()->hasPermission('main_services_read') || auth()->guard('admin')->user()->hasPermission('package_read') || auth()->guard('admin')->user()->hasPermission('specializations_read') || auth()->guard('admin')->user()->hasPermission('experiences_read') || auth()->guard('admin')->user()->hasPermission('nationalities_read') || auth()->guard('admin')->user()->hasPermission('governorates_read') || auth()->guard('admin')->user()->hasPermission('cities_read') || auth()->guard('admin')->user()->hasPermission('families_read'))

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#master_data" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="reports">
                        <i class="fa fa-list"></i>
                        <span data-key="t-apps">       {{helperTrans('admin.Master Data')}}  </span>
                    </a>
                    <div class="collapse menu-dropdown" id="master_data">
                        <ul class="nav nav-sm flex-column">
                            @if(auth()->guard('admin')->user()->hasPermission('main_services_read'))
                            <li class="nav-item">
                                <a class="nav-link menu-link"
                                   href="{{route('main_services.index')}}">
                                    <span data-key="t-dashboards">  {{helperTrans('admin.Main Services')}}</span>
                                </a>
                            </li>
                            @endif

                            {{-- <li class="nav-item">
                                <a class="nav-link menu-link"
                                   href="{{route('categories.index')}}">
                                    <span data-key="t-dashboards">  {{helperTrans('admin.Categories')}}</span>
                                </a>
                            </li> --}}

                            @if(auth()->guard('admin')->user()->hasPermission('package_read'))
                            <li class="nav-item">
                                <a class="nav-link menu-link"
                                   href="{{route('packages.index')}}">
                                    <span data-key="t-dashboards">  {{helperTrans('admin.Package')}}</span>
                                </a>
                            </li>
                            @endif

                            @if(auth()->guard('admin')->user()->hasPermission('specializations_read'))
                            <li class="nav-item">
                                <a class="nav-link menu-link"
                                   href="{{route('specializations.index')}}">
                                    <span data-key="t-dashboards">  {{helperTrans('admin.Specializations')}}</span>
                                </a>
                            </li>
                            @endif

                            @if(auth()->guard('admin')->user()->hasPermission('experiences_read'))
                            <li class="nav-item">
                                <a class="nav-link menu-link"
                                   href="{{route('experiences.index')}}">
                                    <span data-key="t-dashboards">  {{helperTrans('admin.Experience')}}</span>
                                </a>
                            </li>
                            @endif




                            @if(auth()->guard('admin')->user()->hasPermission('nationalities_read'))
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="{{route('nationalities.index')}}">
                                    <span data-key="t-dashboards">  {{helperTrans('admin.Nationalities')}} </span>
                                </a>
                            </li>
                            @endif

                            @if(auth()->guard('admin')->user()->hasPermission('governorates_read'))
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="{{route('governorates.index')}}">
                                    <span data-key="t-dashboards">  {{helperTrans('admin.Governorates')}} </span>
                                </a>
                            </li>
                            @endif

                            @if(auth()->guard('admin')->user()->hasPermission('cities_read'))
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="{{route('cities.index')}}">
                                    <span data-key="t-dashboards">  {{helperTrans('admin.Cities')}} </span>
                                </a>
                            </li>
                            @endif


                            @if(auth()->guard('admin')->user()->hasPermission('families_read'))
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="{{route('families.index')}}">
                                     <span data-key="t-dashboards">  {{helperTrans('admin.Families')}} </span>
                                </a>
                            </li>
                            @endif



                        </ul>
                    </div>
                </li>
                @endif



{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link menu-link" href="#sc" data-bs-toggle="collapse" role="button"--}}
{{--                       aria-expanded="false" aria-controls="reports">--}}
{{--                        <i class="fa fa-list"></i>--}}
{{--                        <span data-key="t-apps">       {{helperTrans('admin.SC')}}  </span>--}}
{{--                    </a>--}}
{{--                    <div class="collapse menu-dropdown" id="sc">--}}
{{--                        <ul class="nav nav-sm flex-column">--}}


{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link menu-link" href="{{route('sc_categories.index')}}">--}}
{{--                                    <span data-key="t-dashboards">  {{helperTrans('admin.Sc categories')}} </span>--}}
{{--                                </a>--}}
{{--                            </li>--}}


{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link menu-link" href="{{route('sc_types.index')}}">--}}
{{--                                    <span data-key="t-dashboards">  {{helperTrans('admin.Sc Types')}} </span>--}}
{{--                                </a>--}}
{{--                            </li>--}}


{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link menu-link" href="{{route('sc_services.index')}}">--}}
{{--                                    <span data-key="t-dashboards">  {{helperTrans('admin.Sc Service')}} </span>--}}
{{--                                </a>--}}
{{--                            </li>--}}

{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link menu-link" href="{{route('sc_symptoms.index')}}">--}}
{{--                                    <span data-key="t-dashboards">  {{helperTrans('admin.Sc Symptoms')}} </span>--}}
{{--                                </a>--}}
{{--                            </li>--}}


{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link menu-link" href="{{route('sc_addons.index')}}">--}}
{{--                                    <span data-key="t-dashboards">  {{helperTrans('admin.Sc Addons')}} </span>--}}
{{--                                </a>--}}
{{--                            </li>--}}


{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </li>--}}



                <li class="nav-item">
                    <a class="nav-link menu-link" href="#gc" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="reports">
                        <i class="fa fa-list"></i>
                        <span data-key="t-apps">       {{helperTrans('admin.GC')}}  </span>
                    </a>
                    <div class="collapse menu-dropdown" id="gc">
                        <ul class="nav nav-sm flex-column">


                            <li class="nav-item">
                                <a class="nav-link menu-link" href="{{route('gc_medication_types.index')}}">
                                    <span data-key="t-dashboards">  {{helperTrans('admin.Gc Medication Type')}} </span>
                                </a>
                            </li>



                            <li class="nav-item">
                                <a class="nav-link menu-link" href="{{route('gc_blood_sugar_units.index')}}">
                                    <span data-key="t-dashboards">  {{helperTrans('admin.Gc Blood Sugar Units')}} </span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link menu-link" href="{{route('gc_blood_sugar_times.index')}}">
                                    <span data-key="t-dashboards">  {{helperTrans('admin.Gc Blood Sugar Times')}} </span>
                                </a>
                            </li>



{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link menu-link" href="{{route('gc_nationalities.index')}}">--}}
{{--                                    <span data-key="t-dashboards">  {{helperTrans('admin.Gc Nationalities')}} </span>--}}
{{--                                </a>--}}
{{--                            </li>--}}



                        </ul>
                    </div>
                </li>


                @if(auth()->guard('admin')->user()->hasPermission('types_read'))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{route('types.index')}}">
                            <i class="fa fa-file"></i> <span data-key="t-dashboards">  {{helperTrans('admin.Types')}} </span>
                        </a>
                    </li>
                @endif

                @if(auth()->guard('admin')->user()->hasPermission('vouchers_read'))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{route('vouchers.index')}}">
                            <i class="fa fa-code"></i> <span data-key="t-dashboards">  {{helperTrans('admin.Voucher')}} </span>
                        </a>
                    </li>
                @endif


                @if(auth()->guard('admin')->user()->hasPermission('areas_read'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('areas.index')}}">
                        <i class="fa fa-area-chart"></i> <span data-key="t-dashboards">  {{helperTrans('admin.Areas')}} </span>
                    </a>
                </li>
                @endif



                @if(auth()->guard('admin')->user()->hasPermission('employees_read'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('employees.index')}}">
                        <i class="fa fa-users"></i> <span data-key="t-dashboards">  {{helperTrans('admin.Employees')}} </span>
                    </a>
                </li>
                @endif



                @if(auth()->guard('admin')->user()->hasPermission('patients_read'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('patients.index')}}">
                        <i class="fa fa-heartbeat"></i> <span data-key="t-dashboards">  {{helperTrans('admin.Patients')}} </span>
                    </a>
                </li>
                @endif

                @if(auth()->guard('admin')->user()->hasPermission('days_read'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('days.index')}}">
                        <i class="fa fa-calendar-day"></i> <span data-key="t-dashboards">  {{helperTrans('admin.Days')}} </span>
                    </a>
                </li>
                @endif


                @if(auth()->guard('admin')->user()->hasPermission('sliders_read'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('sliders.index')}}">
                        <i class="fa fa-sliders"></i> <span data-key="t-dashboards">  {{helperTrans('admin.Sliders')}} </span>
                    </a>
                </li>
                @endif

                @if(auth()->guard('admin')->user()->hasPermission('patient_subscribes_read'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('patient_subscribes.index')}}">
                        <i class="fa fa-bell"></i> <span data-key="t-dashboards">  {{helperTrans('admin.Patient Subscribe')}} </span>
                    </a>
                </li> <!-- end Dashboard Menu -->
                @endif

                @if(auth()->guard('admin')->user()->hasPermission('medication_ways_read'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('medication_ways.index')}}">
                        <i class="fa-solid fa-pills"></i> <span data-key="t-dashboards">  {{helperTrans('admin.Medication Ways')}} </span>
                    </a>
                </li> <!-- end Dashboard Menu -->
                @endif

                @if(auth()->guard('admin')->user()->hasPermission('medication_units_read'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('medication_units.index')}}">
                        <i class="fa fa-balance-scale"></i> <span data-key="t-dashboards">  {{helperTrans('admin.Medication Units')}} </span>
                    </a>
                </li> <!-- end Dashboard Menu -->
                @endif

                @if(auth()->guard('admin')->user()->hasPermission('solution_types_read'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('solution_types.index')}}">
                        <i class="fa fa-question-circle"></i> <span data-key="t-dashboards">  {{helperTrans('admin.Solution Types')}} </span>
                    </a>
                </li> <!-- end Dashboard Menu -->
                @endif

                @if(auth()->guard('admin')->user()->hasPermission('solution_priorities_read'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('solution_priorities.index')}}">
                        <i class="fa fa-question-circle"></i> <span data-key="t-dashboards">  {{helperTrans('admin.Solution Priorities')}} </span>
                    </a>
                </li> <!-- end Dashboard Menu -->
                @endif


                @if(auth()->guard('admin')->user()->hasPermission('diagnoses_read'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('diagnoses.index')}}">
                        <i class="fas fa-diagnoses"></i> <span data-key="t-dashboards">  {{helperTrans('admin.Diagnoses')}} </span>
                    </a>
                </li> <!-- end Dashboard Menu -->
                @endif


                @if(auth()->guard('admin')->user()->hasPermission('bookings_read'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('bookings.index')}}">
                        <i class="fa fa-ticket"></i> <span data-key="t-dashboards">  {{helperTrans('admin.Booking')}} </span>
                    </a>
                </li> <!-- end Dashboard Menu -->
                @endif


                @if(auth()->guard('admin')->user()->hasPermission('hospitals_read'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('hospitals.index')}}">
                        <i class="fa fa-hospital"></i> <span data-key="t-dashboards">  {{helperTrans('admin.Hospitals')}} </span>
                    </a>
                </li> <!-- end Dashboard Menu -->
                @endif


                @if(auth()->guard('admin')->user()->hasPermission('request_bookings_read'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('request_bookings.index')}}">
                        <i class="fa fa-ticket"></i> <span data-key="t-dashboards">  {{helperTrans('admin.Request Booking')}} </span>
                    </a>
                </li> <!-- end Dashboard Menu -->
                @endif


                @if(auth()->guard('admin')->user()->hasPermission('notifications_read'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('notifications.index')}}">
                        <i class="fa fa-bell"></i> <span data-key="t-dashboards">  {{helperTrans('admin.Notifications')}} </span>
                    </a>
                </li> <!-- end Dashboard Menu -->
                @endif


                @if(auth()->guard('admin')->user()->hasPermission('select_providers_read'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('select_providers.index')}}">
                        <i class="fa fa-cog"></i> <span data-key="t-dashboards">  {{helperTrans('admin.Select Providers')}} </span>
                    </a>
                </li> <!-- end Dashboard Menu -->
                @endif


                @if(auth()->guard('admin')->user()->hasPermission('pharmacies_read'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('pharmacies.index')}}">
                        <i class="fas fa-capsules"></i> <span data-key="t-dashboards">  {{helperTrans('admin.Pharmacies')}} </span>
                    </a>
                </li> <!-- end Dashboard Menu -->
                @endif


                @if(auth()->guard('admin')->user()->hasPermission('radiology_read'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('radiology.index')}}">
                        <i class="fa-solid fa-x-ray"></i> <span data-key="t-dashboards">  {{helperTrans('admin.Radiology')}} </span>
                    </a>
                </li> <!-- end Dashboard Menu -->
                @endif


                @if(auth()->guard('admin')->user()->hasPermission('signs_read'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('signs.index')}}">
                        <i class="fa-solid fa-disease"></i> <span data-key="t-dashboards">  {{helperTrans('admin.Sign')}} </span>
                    </a>
                </li> <!-- end Dashboard Menu -->
                @endif

                @if(auth()->guard('admin')->user()->hasPermission('chronic_diseases_read'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('chronic_diseases.index')}}">
                        <i class="fa-solid fa-disease"></i> <span data-key="t-dashboards">  {{helperTrans('admin.Chronic Diseases')}} </span>
                    </a>
                </li> <!-- end Dashboard Menu -->
                @endif

                @if(auth()->guard('admin')->user()->hasPermission('pmedical_operations_read'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('medical_operations.index')}}">
                        <i class="fa-solid fa-disease"></i> <span data-key="t-dashboards">  {{helperTrans('admin.Medical Operation')}} </span>
                    </a>
                </li> <!-- end Dashboard Menu -->
                @endif

                @if(auth()->guard('admin')->user()->hasPermission('settings_read'))
                <li class="nav-item">
                        <a class="nav-link menu-link" href="{{route('settings.index')}}">
                            <i class="fa fa-cog"></i> <span data-key="t-dashboards">  {{helperTrans('admin.Settings')}} </span>
                        </a>
                    </li> <!-- end Dashboard Menu -->
                @endif

            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->


<div class="vertical-overlay"></div>




