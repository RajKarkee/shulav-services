@extends('admin.layout.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/drophify/css/dropify.min.css') }}">
    <style>
        .dropify-wrapper{
            height: 100% !important;
        }
    </style>
@endsection

@section('s-title')
    <li class="breadcrumb-item">Setting</li>
    <li class="breadcrumb-item"><a href="{{route('admin.setting.city.index')}}">Cities</a></li>
    <li class="breadcrumb-item">Add</li>

@endsection
@section('content')
    <div class="card shadow">
        <div class="card-body">
            <form action="{{route('admin.setting.city.add')}}" method="post" id="add-city">
                @csrf
                <div class="row">
                    <div class="col-md-5">
                        <input required type="file" name="image" id="image" class="dropify" accept="image/*">
                    </div>
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="lat">Latitude</label>
                                <input type="text" name="lat" id="lat" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="lan">Longitude</label>
                                <input type="text" name="lan" id="lan" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label for="desc">Description</label>
                                <textarea name="desc" id="desc" cols="30" rows="4" class="form-control"></textarea>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-12 py-2">
                        <button class="btn btn-primary">Add City</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('admin/plugins/drophify/js/dropify.min.js') }}"></script>
    <script>
        var state = 1;
        $(document).ready(function() {
            $('.dropify').dropify();
            $('#add-city').submit(function (e) {
                e.preventDefault();
                console.log(this);
               block('#add-city');
                var fd=new FormData(this);
                axios.post('{{route('admin.setting.city.add')}}',fd)
                .then((res)=>{
                    unblock('#add-city');

                    if(res.data.status){
                        toastr.success('City Added Sucessfully.')
                        $('#add-city')[0].reset();
                        $('#add-city .dropify-clear')[0].click();
                    }else{
                        toastr.error('City Cannot Be added, Please Try Again.')

                    }
                })
                .catch((err)=>{
                    unblock('#add-city');
                    toastr.error('City Cannot Be added, Please Try Again.')
                });
            });
        });


    </script>
@endsection
