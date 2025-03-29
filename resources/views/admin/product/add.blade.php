@extends('admin.layout.app') <!-- Assuming you have a layout file for the admin -->

@section('s-title')
    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Product</a></li>
    <li class="breadcrumb-item">Add</li>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/drophify/css/dropify.min.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">


    <style>
        #mass-image .dropify-wrapper{
            height: 150px;
        }
    </style>
@endsection

@section('content')
    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" onSubmit="saveData(event,this);">
                @csrf

                <div class="row">
                    <div class=" col-md-4">
                        <div>
                            <label for="image">Feature Image</label>
                            <input type="file" name="image" class="form-control dropify" accept=".jpg,.jpeg,.png" id="image" required>
                        </div>
                        <hr>
                        <div class="row" id="mass-image">
                            @for ($index = 0; $index < 6; $index++)
                                <div class="col-md-6">
                                    <label for="image_{{ $index }}">Image {{ $index + 1 }}</label>
                                    <input type="file" name="image-{{$index}}" class="form-control dropify" accept=".jpg,.jpeg,.png" id="image_{{ $index }}">
                                </div>
                            @endfor
                        </div>

                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category_id">Service Category</label>
                                    <select type="text" name="category_id" class="form-control" id="category_id" required>
                                        @foreach (\App\Helper::getCategoriesMini() as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city_id">City</label>
                                    <select type="text" name="city_id" class="form-control" id="city_id" required>
                                        @foreach (\App\Helper::getCitiesMini() as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" id="name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="number" step="0.01" name="price" class="form-control" id="price" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sale_price"><input type="checkbox" name="on_sale" id="on_sale" class="mr-2" onChange="$('#sale_price').attr('readonly',!this.checked;$('#sale_price').attr('required',!this.checked;" />Sale Price</label>
                                    <input type="number" step="0.01" name="sale_price" class="form-control" id="sale_price" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start">Start</label>
                                    <input type="datetime-local" name="start" class="form-control" id="start">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end">End</label>
                                    <input type="datetime-local" name="end" class="form-control" id="end">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="short_desc">Short Description</label>
                                    <textarea name="short_desc" class="form-control" id="short_desc" rows="2"></textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="desc">Description</label>
                                    <textarea name="desc" class="form-control" id="desc" rows="3"></textarea>
                                </div>
                            </div>

                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Add Product</button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('admin/plugins/drophify/js/dropify.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>

    <script>
        var lock=false;
        $(function() {
            $('.dropify').dropify();
            $('#desc').summernote({
                placeholder: 'Enter the product description...',
                tabsize: 2,
                height: 200
            });
        });

        function saveData(e,ele){
            e.preventDefault();
            if(lock){
                return;
            }
            lock=true;
            var formData = new FormData(ele);
            axios.post(ele.action, formData )
            .then((res)=>{

            })
            .catch((err)=>{

            })
            .finally(()=>{
                lock=false;
            })

        }
    </script>
@endsection
