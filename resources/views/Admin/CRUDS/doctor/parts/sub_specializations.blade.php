
@if(count($sub_specializations)>0)

    <option selected disabled>{{helperTrans('admin.Now Select Sub Specializations')}}</option>
    @foreach($sub_specializations as $sub_specialization)
        <option value="{{$sub_specialization->id}}">{{$sub_specialization->name}}</option>
    @endforeach


@else


    <option selected disabled>{{helperTrans('api.Select Another Specialization')}}</option>


@endif
