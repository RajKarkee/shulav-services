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

                        <div class="bg-white shadow mb-3">
                            <div class="card-body ">
                                <div class="stepper">
                                    <div class="step step-1">
                                        <h5 class="mb-3">
                                            Please Choose Category For Your {{ $type == 1 ? 'Product' : 'Service' }}
                                        </h5>
                                        <div class="row">
                                            @foreach (\App\Models\Category::all(['id', 'name']) as $category)
                                                <div class="col-md-4 col-6 mb-3 ">
                                                    <div class="shadow text-center p-3 btn-red-hover h-100 d-flex align-items-center justify-content-center"
                                                        data-value="{{ $category->id }}" onclick="chooseCategory({{$category->id}},'{{$category->name}}')">
                                                        {{ $category->name }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="step step-2">
                                        <h5 class="mb-3">
                                            <span class="text-red-hover pe-2" onclick="prevStep()">
                                                <i class="fa fa-arrow-left"></i>
                                            </span>
                                            <span id="catname">

                                            </span>
                                        </h5>
                                        <div class="row" id="services">
                                            
                                        </div>
                                    </div>
                                    <div class="step step-3">
                                        <h5 class="mb-3">
                                            Post your {{ $type == 1 ? 'Product' : 'Service' }}
                                        </h5>

                                        
                                        <div class="row">
                                            <input type="hidden" name="category_id" id="category_id">
                                            <input type="hidden" name="service_id" id="service_id">
                                           
                                            <div class="col-12">
                                                <strong>Selected Category</strong> 
                                                <div>
                                                    <span id="selectedCategory"></span>
                                                    <span class="text-red-hover ps-3 fw-bolder" onclick="currentstep=1;loadStep();" >Change</span>
                                                </div>
                                                <hr>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="file" accept="image/*" name="image" id="image"
                                                    class="form-control">
                                            </div>
                                            <div class="col-12">
                                                <hr>
                                            </div>
                                            <div class="col-md-12">
        
                                                <div class="form-group mb-3">
                                                    <label class="fw-bolder" for="name">Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="name" class="form-control" name="name"
                                                        value="{{ old('name', '') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group mb-3">
                                                    <label class="fw-bolder" for="price">Price <span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" min="1" name="price" id="price"
                                                        class="form-control" value="{{ old('price', '') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group mb-3">
        
                                                    <label class="fw-bolder" for="short_desc"> Unit <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="short_desc" id="short_desc" cols="30"
                                                        rows="10" class="form-control" value="{{ old('short_desc', '') }}">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4 mb-3">
                                                <label for="start" class="required">Listing Start date <span
                                                        class="text-danger">*</span></label>
                                                <input type="date" value="today" name="start" id="start"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="end" class="required">Listing End date <span
                                                        class="text-danger">*</span></label>
                                                <input type="date" name="end" id="end" class="form-control">
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group mb-3">
    
                                                    <label class="fw-bolder" for="desc">Description</label>
                                                    <textarea name="desc" id="fulldesc" cols="30" rows="10" class="form-control">{!! old('desc', '') !!}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="row m-0">
        
                                                    @for ($i = 0; $i < 6; $i++)
                                                        <div class="col-md-4 col-6 p-0 ">
                                                            <input type="file" name="images[]" class="images"
                                                                id="image-{{ $i }}">
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
        const services = {!! \App\Models\Service::all(['name', 'id', 'category_id']) !!};

        $(document).ready(function() {
            let formattedDate = new Date();
            let d = formattedDate.getDate();
            let m = formattedDate.getMonth();
            m += 1; // JavaScript months are 0-11
            let y = formattedDate.getFullYear();

            $("input[type='date']").val(y + "-" + (m < 10 ? ("0" + m) : m) + "-" + d);

            tinymce.init({
                invalid_elements: "script",
                selector: '#fulldesc',
                plugins: 'advlist autolink lists link  charmap  hr anchor pagebreak',
                toolbar_mode: 'floating',
            });
            $('#image').dropify({});
            $('.images').dropify({});


            $('.stepper .step').hide();
            $('.stepper .step-' + currentstep).show();
        });

        var currentstep = 1;
        var currentcat = null;
        var currentcatname = null;
        var currentser = null;
        var currentsername = null;

        function loadStep() {
            $('.stepper .step').hide();
            $('.stepper .step-' + currentstep).show();
            goToTop();
        }
        function nextStep() {
            if (step == 1) {

            }
        }

        function prevStep() {
            currentstep-=1;
            loadStep();
        }

        function chooseCategory(id,name) {
            currentcat =id;
            currentcatname=name;
            $('#catname').html("Categories in "+currentcatname);
            const data = services.filter(o=>o.category_id==currentcat);
            let html = '';
            data.forEach(element => {
                html += ` <div class="col-md-4 col-6 mb-3 " >
                                <div class="shadow  text-center  p-3 btn-red-hover h-100 d-flex align-items-center justify-content-center" data-value="${element.id}" onclick="chooseService(${element.id},' ${ element.name }')">
                                    ${ element.name }
                                </div>
                            </div>`;
            });
            $('#services').html(html);
            currentstep=2;
            loadStep();
        }

        function chooseService(id,name){
            currentser =id;
            currentsername=name;
            $('#category_id').val(currentcat);
            $('#service_id').val(currentser);
            $('#selectedCategory').html(currentcatname+">"+currentsername)
            currentstep=3;
            loadStep();
        }

    
    </script>
    @include('vendor.dashboard.imagejs')
    @include('vendor.dashboard.namejs')
    @include('vendor.dashboard.descjs')
@endsection
