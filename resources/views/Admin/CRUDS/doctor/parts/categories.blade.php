@if(count($categories)>0)

    <option selected disabled>Now Select Category</option>
    @foreach($categories as $category)
        <option value="{{$category->id}}">{{$category->name}}</option>
    @endforeach

@else


    <option selected disabled> {{helperTrans('admin.Select Another')}}</option>


@endif
