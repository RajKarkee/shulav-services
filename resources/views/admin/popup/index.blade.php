@extends('admin.layout.app')
@section('css')
    <style>

    </style>
@endsection
@section('page-option')
<a type="button" class="btn btn-primary" href="{{route('admin.setting.front.popup.add')}}">Add Popup</a>

@endsection
@section('s-title')
    <li class="breadcrumb-item">Popups</li>
@endsection
@section('content')
    <div class="card shadow">
        <div class="card-body" id="">
            @foreach ($popups as $popup)
                <div class="card shadow mb-3">
                    <div class="card-body" id="">
                        <div class="row">
                            <div class="col-md-6">
                                <strong> Image</strong> <br>
                                <div>
                                    <img src="{{asset($popup->image)}}" class="w-100" alt="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div>

                                    <strong>Link</strong> <br>
                                    <div>
                                        <a href="{{$popup->link}}">{{$popup->link}}</a>

                                    </div>
                                </div>
                                <hr>
                                <div>

                                    <strong>Is Large</strong> <br>
                                    <div>
                                        {{$popup->is_large==1?'yes':'no'}}

                                    </div>
                                </div>
                                <hr>

                                <div class="">
                                    <a href="{{route('admin.setting.front.popup.edit',['popup'=>$popup->id])}}" class="btn btn-success">Edit</a>
                                    <form class="d-inline" method="POST" action="{{route('admin.setting.front.popup.del',['popup'=>$popup->id])}}">
                                        @csrf
                                        <button  class="btn btn-danger" onclick="return prompt('Enter yes to delete')=='yes';">Delete</button>

                                    </form>
                                    <form class="d-inline" method="POST" action="{{route('admin.setting.front.popup.status',['popup'=>$popup->id,'status'=>$popup->active==1?0:1])}}">
                                        @csrf
                                        <button  class="btn btn-{{$popup->active==1?'warning':'success'}}" onclick="return prompt('Enter yes to {{$popup->active==1?'Deactivate':'Activate'}}')=='yes';">{{$popup->active==1?'Deactivate':'Activate'}}</button>

                                    </form>
                                </div>
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
