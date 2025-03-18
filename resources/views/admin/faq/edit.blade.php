@extends('admin.layout.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/drophify/css/dropify.min.css') }}">
    <style>
        .col-md-3 {
            margin-bottom: 10px;
        }

        label {
            font-weight: 600;
            font-size: 1.1rem;
            /* margin-bottom: 5px; */
            color: black;
            margin-top: 5px;
        }

        .form-control,
        .tox {
            border-radius: 5px !important;
        }

    </style>
@endsection
@section('page-option')
@endsection
@section('s-title')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.faq.index') }}">Faqs</a>
    </li>
    <li class="breadcrumb-item ">
        {{$faq->q}}
    </li>
    <li class="breadcrumb-item active">
        Edit
    </li>
@endsection
@section('content')

    <div class="card shadow mb-3">
        <div class="card-body">
            <form action="{{ route('admin.faq.edit',['faq'=>$faq->id]) }}" method="post" enctype="multipart/form-data"
                id="edit-faq">

                @csrf
                <div class="row">
                    
                    
                    <div class="col-md-12">
                        <label for="q">Question</label>
                        <input type="text" name="q" id="q" value="{{$faq->q}}" required class="form-control" required>
                    </div>
                  
                    <div class="col-md-12 mb-2">
                        <label for="a">Answer</label>
                        <textarea name="a" id="a"  rows="4" class="form-control desc">{!!$faq->a!!}</textarea>
                    </div>
                   
                    <div class="col-md-6 py-2">
                        <button class="btn btn-primary">Update Faq</button>

                        <a href="{{route('admin.faq.index')}}" class="btn btn-danger">Cancel</a>

                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('script')
    <script src="https://cdn.tiny.cloud/1/4adq2v7ufdcmebl96o9o9ga7ytomlez18tqixm9cbo46i9dn/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        var state = false;
      
        $(function() {
            tinymce.init({
                selector: '.desc',
                plugins: [
                    '  advlist anchor autolink codesample fullscreen help image imagetools tinydrive',
                    ' lists link media noneditable  preview',
                    ' searchreplace table template  visualblocks wordcount '
                ],
                toolbar_mode: 'floating',
              
            });
            $('#edit-faq').submit(function (e) { 
                e.preventDefault();
                axios.post(this.action,new FormData(this))
                .then((res)=>{
                    toastr.success('Faq Saved Sucessfully');
                })
                .catch((err)=>{
                    toastr.error('Faq Not Saved, Some Error Occured');
                });
            });
        });
    </script>
@endsection
