<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('roles.update',$role->id)}}">
    @csrf
    @method('PUT')
    <div class="row g-4">

        <div class="form-group">
            <label>Name <span class="text-danger">*</span></label>
            <input type="text" name="name" autofocus class="form-control"  value="{{ old('name', $role->name) }}" required>
        </div>

        <h5>Permissions <span class="text-danger">*</span></h5>

        @php
            $models = [
                'roles',
                'admins',
                'users',
                'providers',
                'doctors',
                'laboratories',
                'analysis',
                'radiology_center',
                'insurance_people',
                'insurance_companies',
                'main_services',
                'package',
                'specializations',
                'experiences',
                'governorates',
                'cities',
                'families',
                'types',
                'areas',
                'employees',
                'patients',
                'days',
                'sliders',
                'patient_subscribe',
                'medication_ways',
                'medication_units',
                'solution_types',
                'solution_priorities',
                'diagnoses',
                'booking',
                'hospitals',
                'request_booking',
                'notifications',
                'select_providers',
                'pharmacies',
                'radiology',
                'sign',
                'chronic_diseases',
                'medical_operation',
                'vouchers',
                'settings',
            ];
        @endphp

        <table class="table">
            <thead>
            <tr>
                <th>Model</th>
                <th>Permissions</th>
            </tr>
            </thead>

            <tbody>
                @foreach ($models as $model)
                    <tr>
                        <td>{{$model}}</td>
                        <td>

                            @php
                                $permissionMaps = ['create', 'read', 'update', 'delete'];
                            @endphp

                            @foreach ($permissionMaps as $permissionMap)
                                <div class="animated-checkbox mx-2" style="display:inline-block;">
                                    <label class="m-0">
                                        <input type="checkbox" value="{{ $model . '_' . $permissionMap }}" name="permissions[]" {{ $role->hasPermission( $model . '_' . $permissionMap) ? 'checked' : '' }} class="role">
                                        <span class="label-text">{{$permissionMap}} </span>
                                    </label>
                                </div>
                            @endforeach
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table><!-- end of table -->
    </div>
</form>
