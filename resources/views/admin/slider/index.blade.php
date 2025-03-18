@extends('admin.layout.app')
@section('css')
    <style>

    </style>
@endsection
@section('page-option')
<a type="button" class="btn btn-primary" href="{{route('admin.setting.front.slider.add')}}">Add Slider</a>

@endsection
@section('s-title')
    <li class="breadcrumb-item">Sliders</li>
@endsection
@section('content')
    <div class="card shadow">
        <div class="card-body" id="">
            @foreach ($sliders as $slider)
                <div class="card shadow mb-3">
                    <div class="card-body" id="">
                        <div class="row">
                            <div class="col-md-9">
                                <strong>Desktop / Tablet Image</strong> <br>
                                <div>
                                    <img src="{{asset($slider->image)}}" class="w-100" alt="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <strong>Mobile Image</strong> <br>
                                <div>
                                    <img src="{{asset($slider->mobile_image)}}" class="w-100" alt="">
                                </div>
                            </div>
                            <div class="col-12 p-0"><hr></div>
                            <div class="col-md-9">
                                <strong>Link</strong> <br>
                                <div>
                                    <a href="{{$slider->link}}">{{$slider->link}}</a>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <strong>Index</strong> <br>
                                <div>
                                    {{$slider->index}}
                                </div>
                            </div>
                            <div class="col-12 p-0"><hr></div>
                            <div class="col-md-12">
                                <a href="{{route('admin.setting.front.slider.edit',['slider'=>$slider->id])}}" class="btn btn-success">Edit</a>
                                <form class="d-inline" method="POST" action="{{route('admin.setting.front.slider.del',['slider'=>$slider->id])}}">
                                    @csrf
                                    <button  class="btn btn-danger" onclick="return prompt('Enter yes to delete')=='yes';">Delete</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('script')

    <script>


    </script>
@endsection
