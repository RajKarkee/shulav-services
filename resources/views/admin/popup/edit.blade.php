@extends('admin.layout.app')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/plugins/drophify/css/dropify.min.css') }}">
<style>
    .form-control{
        padding: 0.355rem 0.755rem;
        border-radius: 5px;
    }
    .col-md-6{
        padding-bottom: 0.5rem;
    }
    .col-md-3{
        padding-bottom: 0.5rem;
    }
</style>
@endsection
@section('page-option')
@endsection
@section('s-title')
    <li class="breadcrumb-item"><a href="{{route('admin.setting.front.popup.index')}}">Popups</a></li>
    <li class="breadcrumb-item">#{{$popup->id}}</li>
    <li class="breadcrumb-item">Edit</li>
@endsection
@section('content')
    <div class="card shadow">
        <div class="card-body" id="">
            <form id="add-popup" action="{{route('admin.setting.front.popup.edit',['popup'=>$popup->id])}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 pb-3">
                        <label for="image">Desktop / Tab Image</label>
                        <input type="file" name="image" id="image" class="dropify" data-default-file="{{asset($popup->image)}}" accept="image/*" >
                    </div>

                    <div class="col-md-6">
                        <label for="link">Link</label>
                        <input type="text" name="link" id="link" class="form-control" value="{{$popup->link}}" required>
                        <hr>
                        <div >
                            <span class="mr-2">
                                <input type="checkbox" name="is_large" id="is_large" {{$popup->is_large==1?'checked':''}} value="1"> <label for="is_large">Large Popup</label>
                            </span>
                            <button class="btn btn-primary px-5">Save</button>
                        </div>
                    </div>

                </div>
            </form>


        </div>
    </div>
@endsection
@section('script')

<script src="{{ asset('admin/plugins/drophify/js/dropify.min.js') }}"></script>
<script>
    var state = false;
    function checkOrg(ele) {
        document.getElementById('dob_label').innerHTML=ele.checked?'Established Date':'Date Of Birth';
        if(ele.checked){
            $('#gender-holder').addClass('d-none');
        }else{
            $('#gender-holder').removeClass('d-none');

        }

    }
    $(document).ready(function() {
        $('.dropify').dropify();
        $('#add-popup').submit(function (e) {
            e.preventDefault();
            if(!state){
                state=true;
                block('#add-popup');
                let fd=new FormData(this);
                const ele=this;
                axios.post(this.action,fd)
                .then((res)=>{
                    toastr.success('popup Updated Sucessfully');
                    state=false;
                    unblock('#add-popup');

                })
                .catch((err)=>{
                    unblock('#add-popup');
                    state=false;
                    toastr.error('popup Cannot be Updated,'+err.response.data.message);
                });
            }
        });
    });


</script>
@endsection
