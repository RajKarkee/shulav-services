@extends('front.page')
@section('css')
    <link rel="stylesheet" href="{{ asset('front/vendor/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('front/vendor/product.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
        integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .dropify-wrapper .dropify-message p {
            margin: 5px 0 0;
            font-size: 16px;
        }

    </style>
@endsection
@section('title', 'Vendor Add ' . ($type == 1 ? 'Products' : 'Services'))

@section('content')

    <div id="vendor-dashboard-page">
        <div>
            <div class="row">
                @include('vendor.dashboard.sidebar')
                <div class="col-md-8   ">
                    <div class="bg-white shadow mb-3">
                        <div class="card-body " id="jumbotron">
                            <a href="{{ route('vendor.dashboard') }}">Dashboard</a>
                            <a
                                href="{{ route('vendor.product.index', ['type' => $type]) }}">{{ $type == 1 ? 'Products' : 'Services' }}</a>
                            <span>Add</span>
                        </div>
                    </div>
                    @if ($errors->any())
                        <div class="bg-white shadow mb-3">
                            <div class="card-body ">
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ $error }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <form action="{{ route('vendor.product.add', ['type' => $type]) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        
                        <div class="stepper">
                            <div class="step step-1">
                                step1
                            <div class="text-end">
                                <span class="btn btn-red" onclick="nextStep()">
                                    Next
                                </span>
                            </div>
                            </div>
                        </div>
                        <div class="bg-white shadow mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="file" accept="image/*" name="image" id="image" class="form-control">
                                    </div>
                                    <div class="col-12">
                                        <hr>
                                    </div>
                                    <div class="col-md-12">

                                        <div class="form-group mb-3">
                                            <label class="fw-bolder" for="name">Name <span class="text-danger">*</span></label>
                                            <input type="text" id="name" class="form-control" name="name"
                                                value="{{ old('name', '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group mb-3">
                                            <label class="fw-bolder" for="price">Price <span class="text-danger">*</span></label>
                                            <input type="number" min="1" name="price" id="price" class="form-control"
                                                value="{{ old('price', '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group mb-3">

                                            <label class="fw-bolder" for="short_desc"> Unit <span class="text-danger">*</span></label>
                                            <input type="text" name="short_desc" id="short_desc" cols="30" rows="10"
                                                class="form-control" value="{{ old('short_desc', '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="control join mb-3 ">
                                            <label for="category" class="required">Service Type <span class="text-danger">*</span></label>
                                            <select min="10" max="10" class="form-control" id="category" name="category_id" aria-label="category"
                                                aria-describedby="category" autocomplete="off">
                                                @foreach (\App\Models\Category::all(['id', 'name']) as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="control join mb-3">
                                            <label for="service" class="required">Service  <span class="text-danger">*</span></label>
                                            <select min="10" max="10" id="service" name="service_id" class="form-control" aria-label="service"
                                                aria-describedby="service" autocomplete="off">

                                            </select>
                                        </div>
                                    </div>
                                    <div  class="col-md-6 mb-3">
                                        <label for="start" class="required">Listing Start date  <span class="text-danger">*</span></label>
                                        <input type="date" value="today" name="start" id="start" class="form-control">
                                    </div>
                                    <div  class="col-md-6 mb-3">
                                        <label for="end" class="required">Listing End date  <span class="text-danger">*</span></label>
                                        <input type="date" name="end" id="end" class="form-control">
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-3">

                                            <label class="fw-bolder" for="desc">Description</label>
                                            <textarea name="desc" id="fulldesc" cols="30" rows="10"
                                                class="form-control">{!! old('desc', '') !!}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row m-0">

                                            @for ($i = 0; $i < 6; $i++)
                                                
                                                <div class="col-md-4 col-6 p-0 ">
                                                    <input type="file" name="images[]" class="images" id="image-{{$i}}">
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="col-md-12 py-2">
                                        <div class="form-group">
                                            <button class="btn btn-red">Add
                                                {{ $type == 1 ? 'Product' : 'Service' }}</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>



    </div>
    </div>
    </div>
    </div>

@endsection
@section('js')
    @include('toastr.index')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
        integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.tiny.cloud/1/4adq2v7ufdcmebl96o9o9ga7ytomlez18tqixm9cbo46i9dn/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        var data;
        const services={!! \App\Models\Service::all(['name','id','category_id'])->groupBy('category_id')!!};

        $(document).ready(function() {
            let formattedDate = new Date();
            let d = formattedDate.getDate();
            let m =  formattedDate.getMonth();
            m += 1;  // JavaScript months are 0-11
            let y = formattedDate.getFullYear();

            $("input[type='date']").val(y + "-" + (m<10?("0"+m):m) + "-" + d);

            tinymce.init({
                invalid_elements: "script",
                selector: '#fulldesc',
                plugins: 'advlist autolink lists link  charmap  hr anchor pagebreak',
                toolbar_mode: 'floating',
            });
            $('#image').dropify({});
            $('.images').dropify({});
            $('#category').change(function (e) {
                e.preventDefault();
                selService();
            });
            selService();

            $('.stepper .step').hide();
            $('.stepper .step-'+currentstep).show();
        });

        currentstep=1;
        currentcat=null;
        currentser=null;
        function nextStep() {
            if(step==1){

            }
        }
        function prevStep() {
            if(step==2){
                
            }
        }
        
        function selService() {
            const category=$('#category').val();
            const data=services[''+category+''];
            let html='';
            data.forEach(element => {
                html+='<option value="'+element.id+'">'+element.name+'</option>';
            });
            $('#service').html(html);
        }

        
    </script>
    @include('vendor.dashboard.imagejs')
    @include('vendor.dashboard.namejs')
    @include('vendor.dashboard.descjs')
@endsection
