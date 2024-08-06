<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('radiology.update_import')}}">
    @csrf
    <div class="row g-4">


        <div class="form-group">
            <label for="name" class="form-control-label">{{helperTrans('admin.File')}} </label>
            <input type="file" class="dropify" name="file" data-default-file="{{get_file()}}" />
        </div>





    </div>
</form>


<script>
    $('.dropify').dropify();
</script>

