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
       Payment
    </li>
    <li class="breadcrumb-item active">
        Settings
     </li>
@endsection
@section('content')

    <div class="card shadow mb-3">
        <div class="card-body">

            <form action="{{route('admin.setting.payment')}}" method="post" enctype="multipart/form-data">
                @csrf


                <div class="shadow mt-3">
                    <h4 class="d-flex justify-content-between align-items-center px-3 py-1">
                        <span>
                           Payment Gateways
                        </span>
                        <span class="btn" onclick="add('payment');">
                            Add New
                        </span>
                    </h4>
                    <hr class="m-0">
                    <div class="card-body" id="payment">
                        <div class="row m-0">
                            <div class="row col-md-5 ps-4"> <strong>Payement Gateway</strong> </div>
                            <div class="row col-md-4 ps-4"> <strong>Payement ID</strong> </div>
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

            <div class="col-md-5">
                <input type="text" value="xxx_title" name="title_xxx_id" required class="form-control">
            </div>
            <div class="col-md-4">
                <input type="text" value="xxx_id" name="id_xxx_id" required class="form-control">
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
        const payment={!! json_encode($data) !!};
        function add(type){
            $('#'+type).append(strReplaceAll(tem,['xxx_id','xxx_title','xxx_id','xxx_type'],[i,'','',type]));
            i+=1;
        }
        function  del(id) {
            $('#link_'+id).remove();
        }

        $(document).ready(function () {
            $('.photo').dropify();
            payment.forEach(ele => {
                $('#'+"payment").append(strReplaceAll(tem,['xxx_id','xxx_title','xxx_id','xxx_type'],[i,ele.title,ele.id,"payment"]));
                i+=1;
            });

        });
    </script>
@endsection
