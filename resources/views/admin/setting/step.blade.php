@extends('admin.layout.app')
@section('css')
    <style>
        .sm-title{
            font-weight: 600;
            font-size: 1.2rem;

        }
        .form-control{
            border-radius: 0px;
        }
    </style>
@endsection
@section('page-option')
    {{-- <a type="button" class="btn btn-primary" href="{{ route('admin.vendor.add') }}">Add Vendor</a> --}}
@endsection
@section('s-title')


    <li class="breadcrumb-item ">
       Front
    </li>
    <li class="breadcrumb-item active">
        Steps
     </li>
@endsection
@section('content')

    <div class="card shadow mb-3">
        <div class="card-body">

            <form action="{{route('admin.setting.front.step')}}" method="post">
                @csrf
                @foreach ($steps as $key=>$step)
                <div class="shadow mb-4">
                    <h5 class="p-2" style="text-transform: capitalize;">
                        {{$key}}
                    </h5>
                    <hr class="my-0">
                    <div class="p-2">
                        <div>
                            <label for="{{$key}}_title">Title</label>
                            <input type="text" value="{{$step->title}}" name="{{$key}}_title" id="{{$key}}_title" class="form-control">
                        </div>
                        <div>
                            <label for="{{$key}}_text">Description</label>
                            <textarea type="text" name="{{$key}}_text" id="{{$key}}_text" class="form-control">{{$step->text}}</textarea>
                        </div>

                    </div>
                </div>
                @endforeach
                <div class="py-2">
                    <button class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>


@endsection
@section('script')

@endsection
