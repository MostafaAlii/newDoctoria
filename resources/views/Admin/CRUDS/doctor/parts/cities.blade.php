
@if(count($cities)>0)

     <option selected disabled>{{helperTrans('admin.Now Select City')}}</option>
    @foreach($cities as $city)
        <option value="{{$city->id}}">{{$city->name}}</option>
    @endforeach


@else


    <option selected disabled>{{helperTrans('api.Select Another governorate')}}</option>


@endif
