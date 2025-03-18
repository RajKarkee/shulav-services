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
    <li class="breadcrumb-item"><a href="{{route('admin.setting.front.slider.index')}}">Sliders</a></li>
    <li class="breadcrumb-item">Add</li>
@endsection
@section('content')
    <div class="card shadow">
        <div class="card-body" id="">
            <form id="add-slider" action="{{route('admin.setting.front.slider.add')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-9 pb-3">
                        <label for="image">Desktop / Tab Image</label>
                        <input type="file" name="image" id="image" class="dropify" accept="image/*" required>
                    </div>
                    <div class="col-md-3 pb-3">
                        <label for="mobile_image">Mobile / Image</label>
                        <input type="file" name="mobile_image" id="mobile_image" class="dropify" accept="image/*" required>
                    </div>
                    <div class="col-md-9">
                        <label for="link">Link</label>
                        <input type="text" name="link" id="link" class="form-control" value="#" required>
                    </div>
                    <div class="col-md-3">
                        <label for="index">index</label>
                        <input type="number" name="index" id="index" class="form-control" value="1" required>
                    </div>
                    <div class=" col-12 py-2">
                        <button class="btn btn-primary px-5">Save</button>
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
        $('#add-slider').submit(function (e) {
            e.preventDefault();
            if(!state){
                state=true;
                block('#add-slider');
                let fd=new FormData(this);
                const ele=this;
                axios.post(this.action,fd)
                .then((res)=>{
                    ele.reset();
                    toastr.success('slider Added Sucessfully');
                    state=false;
                    $('.dropify-clear').click();
                    unblock('#add-slider');

                })
                .catch((err)=>{
                    unblock('#add-slider');
                    state=false;
                    toastr.error('slider Cannot be Added,'+err.response.data.message);
                });
            }
        });
    });


</script>
@endsection
