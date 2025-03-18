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
    <link rel="stylesheet" href="{{ asset('admin/plugins/drophify/css/dropify.min.css') }}">

@endsection
@section('page-option')
@endsection
@section('s-title')


    <li class="breadcrumb-item ">
       Front
    </li>
    <li class="breadcrumb-item active">
        Settings
     </li>
@endsection
@section('content')

    <div class="card shadow mb-3">
        <div class="card-body">

            <form action="{{route('admin.setting.front.minor')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 pb-2">
                        <label for="logo">Header Logo</label>
                        <input type="file" name="logo" id="logo" class="form-control photo" accept="image/*" data-default-file="{{asset($data->logo)}}" >
                    </div>
                    <div class="col-md-6 pb-2">
                        <label for="footer_logo">Mobile Logo</label>
                        <input type="file" name="footer_logo" id="footer_logo" class="form-control photo" accept="image/*" data-default-file="{{asset($data->footer_logo)}}"  >
                    </div>
                    <div class="col-md-12 pb-2">
                        <label for="play_store">Play Store Link</label>
                        <input type="text" name="play_store" id="play_store" class="form-control " value="{{$data->play_store??''}}" >
                    </div>
                    <div class="col-md-12 pb-2">
                        <label for="company">Company Name</label>
                        <input type="text" name="company" id="company" class="form-control " value="{{$data->company??''}}" >
                    </div>
                    @foreach ($data->social_links    as $key=>$link)
                    <div class="col-md-6 pb-2">
                        <label for="{{$key}}">{{$key}} Link</label>
                        <input type="text" name="{{$key}}" id="{{$key}}" class="form-control " value="{{$link}}" >
                    </div>
                    @endforeach
                    <div class="col-md-12 mt-2">
                        <label for="address">Address</label>
                        <textarea name="address" id="address" class="form-control">{{$data->address}}</textarea>
                    </div>
                </div>

                <div class="shadow mt-3">
                    <h4 class="d-flex justify-content-between align-items-center px-3 py-1">
                        <span>
                           Phone Numbers
                        </span>
                        <span class="btn" onclick="add('phone');">
                            Add Number
                        </span>
                    </h4>
                    <hr class="m-0">
                    <div class="card-body" id="phone">
                        <div class="row m-0">
                            <div class="row col-md-9 ps-4"> <strong>Phone Number</strong> </div>
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="shadow mt-3">
                    <h4 class="d-flex justify-content-between align-items-center px-3 py-1">
                        <span>
                           Email Addresses
                        </span>
                        <span class="btn" onclick="add('email');">
                            Add Email Address
                        </span>
                    </h4>
                    <hr class="m-0">
                    <div class="card-body" id="email">
                        <div class="row m-0">
                            <div class="row col-md-9 ps-4"> <strong>Email Address</strong> </div>
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="py-2">
                    <button class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>

    <div id="link-template" class="d-none">
        <div class="row" id="link_xxx_id">
            <input type="hidden" name="xxx_type[]" value="xxx_id">

            <div class="col-md-9">
                <input type="text" value="xxx_title" name="title_xxx_id" required class="form-control">
            </div>

            <div class="col-md-3">
                <button class="btn btn-danger w-100" onclick="del(xxx_id)">Del</button>
            </div>
        </div>
        <hr>
    </div>
@endsection
@section('script')
    <script src="{{ asset('admin/plugins/drophify/js/dropify.min.js') }}"></script>
    <script>
        const tem=$('#link-template').html();
        $('#link-template').remove();
        i=0;
        const phone={!! json_encode($data->phone) !!};
        const email={!! json_encode($data->email) !!};
        function add(type){
            $('#'+type).append(strReplaceAll(tem,['xxx_id','xxx_title','xxx_type'],[i,'',type]));
            i+=1;
        }
        function  del(id) {
            $('#link_'+id).remove();
        }

        $(document).ready(function () {
            $('.photo').dropify();
            phone.forEach(ele => {
                $('#'+"phone").append(strReplaceAll(tem,['xxx_id','xxx_title','xxx_type'],[i,ele,"phone"]));
                i+=1;
            });
            email.forEach(ele => {
                $('#'+"email").append(strReplaceAll(tem,['xxx_id','xxx_title','xxx_type'],[i,ele,"email"]));
                i+=1;
            });
        });
    </script>
@endsection
