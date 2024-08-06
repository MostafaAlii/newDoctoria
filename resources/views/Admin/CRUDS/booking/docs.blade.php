@extends('Admin.layouts.inc.app')
@section('title')
    {{helperTrans('admin.Booking Docs')}}
@endsection
@section('css')


@endsection
@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">

            <h5 class="card-title mb-0 flex-grow-1 text-center">{{helperTrans('admin.Booking Docs for Patient')}}
                {{$row->patient->name??''}}

            </h5>


        </div>


    </div>

    <div class="row g-4">
        @forelse($row->docs as $doc)
        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <div class="card">
                <div class="card-header d-flex align-items-center ">
                    <h5 class="card-title mb-0 flex-grow-1 text-center">{{helperTrans('admin.Doc')}}</h5>
                </div>
                <div class="card-body">
                    <div class="card-body text-center">
                        @php
                            $imageUrl = get_file($doc->doc);
                            $fileExtension = pathinfo($imageUrl, PATHINFO_EXTENSION);
                            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                            $isImage = in_array(strtolower($fileExtension), $imageExtensions);
                        @endphp

                        @if ($isImage)
                            <a data-fancybox="" href="{{ get_file($doc->doc) }}">
                                <img height="60px" src="{{ get_file($doc->doc) }}">
                            </a>
                        @else
                            <a target="_blank" href="{{ get_file($doc->doc) }}" class="btn btn-success">
                                <i class="fa fa-download"></i>
                            </a>
                        @endif
                    </div>

                </div>
            </div>
        </div>
        @empty

        @endforelse
    </div>



@endsection
@section('js')

@endsection
