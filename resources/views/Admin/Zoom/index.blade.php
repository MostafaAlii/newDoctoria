@extends('Admin.layouts.inc.app')
@section('title')
    {{helperTrans('admin.create_call')}}
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
        @if(auth()->guard('admin')->user()->hasPermission('admins_create'))
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">"{{helperTrans('admin.create_call')}}</h5>
                <form action="{{route('zoom_video_call.store')}}" method="post">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="inputState">doctors</label>
                            <select class="custom-select mr-sm-2" name="doctor_id" required>
                                <option selected disabled>doctors...</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{$doctor->id}}">{{$doctor->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col">
                            <label for="inputState">patients</label>
                            <select class="custom-select mr-sm-2" name="patient_id" required>
                                <option selected disabled>patients...</option>
                                @foreach($patients as $patient)
                                    <option value="{{$patient->id}}">{{$patient->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"> {{helperTrans('admin.create_call')}}</button>
                </form>
                
                


            </div>
        @endif
    </div>


@endsection
@section('js')
    <link href="{{url('assets/dashboard/css/select2.css')}}" rel="stylesheet"/>
    <script src="{{url('assets/dashboard/js/select2.js')}}"></script>
    <!--datatable js-->

@endsection
