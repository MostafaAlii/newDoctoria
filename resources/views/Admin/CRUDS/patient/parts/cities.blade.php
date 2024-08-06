
@if(count($cities)>0)

       <option selected disabled>Now Select City</option>
    @foreach($cities as $city)
        <option  value="{{$city->id}}">{{$city->name}}</option>
    @endforeach


@else

    <option selected disabled> Select Another Nationality</option>


@endif
