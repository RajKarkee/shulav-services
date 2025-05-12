@extends('front.page')
@section('css')
    <link rel="stylesheet" href="{{ asset('front/vendor/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('front/rcrop.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/user/index.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('css/main2.css') }}">
    <style>
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding-top: 50px;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .modal.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-back {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 700px;
            max-height: 90vh;
            overflow-y: auto;
            transform: translateY(-20px);
            transition: transform 0.3s ease;
        }

        .modal.active .modal {
            transform: translateY(0);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid #e5e7eb;
        }

        .modal-title {
            font-size: 18px;
            font-weight: 600;
            color: #111827;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 20px;
            color: #6b7280;
            cursor: pointer;
        }

        .modal-body {
            padding: 20px;
        }


        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-column {
            flex: 1;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #111827;
        }

        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            color: #111827;
        }

        .form-control:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        .image-upload-container {
            margin-top: 20px;
        }

        .image-upload-title {
            margin-bottom: 10px;
            font-weight: 500;
            color: #111827;
        }

        .image-upload-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 10px;
        }

        .image-upload-item {
            position: relative;
            width: 100%;
            height: 120px;
            border: 2px dashed #d1d5db;
            border-radius: 6px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            overflow: hidden;
        }

        .image-upload-item:hover {
            border-color: #2563eb;
        }

        .image-number {
            font-size: 12px;
            color: #6b7280;
            margin-top: 5px;
        }

        .upload-icon {
            width: 24px;
            height: 24px;
            color: #6b7280;
        }

        .image-preview {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .remove-image {
            position: absolute;
            top: 5px;
            right: 5px;
            width: 20px;
            height: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            z-index: 1;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 15px 20px;
            border-top: 1px solid #e5e7eb;
        }

        .btn-cancel {
            background-color: white;
            color: #374151;
            border: 1px solid #d1d5db;
        }

        .btn-save {
            background-color: #2563eb;
            color: white;
            border: none;
        }

        .hidden {
            display: none;
        }

        /* For demonstration only - product table styling */
        .products-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .products-table th,
        .products-table td {
            text-align: left;
            padding: 12px 15px;
            border-bottom: 1px solid #e5e7eb;
        }

        .products-table th {
            background-color: white;
            color: #6b7280;
            font-weight: 500;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
    </style>
@endsection
@section('title', 'User Dashboard ')

@section('content')
    <div class="view mt-2" >
        <div class="heading">
            <h4>My Products</h4>
        </div>

        @php
            $categories = \App\Models\Category::all();
            $productsCats = \App\Models\Category::where('type', 1)->get();
            $cities = \App\Models\City::all();
        @endphp

        <div class="container">
            <div class="header">
                <div class="title-section">
                    <h1 class="title">Products</h1>
                    <span class="results"></span>
                    <span class="info-icon">ⓘ</span>
                </div>
                @if (session('success'))
                    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050">
                        <div id="successToast" class="toast align-items-center text-bg-success border-0 show" role="alert"
                            aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body">
                                    {{ session('success') }}
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                @endif
                @if (session('error'))
                    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050">
                        <div id="errorToast" class="toast align-items-center text-bg-danger border-0 show" role="alert"
                            aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body">
                                    {{ session('error') }}
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="action-buttons">
                    <button class="btn btn-primary" onclick="showModal()" id="addProductBtn">
                        <span>+</span>
                        Add new product
                    </button>
                </div>
            </div>
            <table class="products-table">
                <thead>
                    <tr>
                        <th>IMAGE</th>
                        <th>PRODUCT</th>
                        <th>CATEGORY</th>
                        <th>PRICE</th>
                        <th>STATUS</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td><img src="{{ asset($product->image) }}" alt=""
                                    style="width: 100px; height: 100px; background-color: #ccc;"></td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category_name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->active == 1 ? 'Active' : 'Inactive' }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-secondary">Edit</button>
                                    <a href="{{route('user.products.del',['product_id'=>$product->id])}}" class="btn btn-danger">Delete</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal" id="addProductModal">
        <div class="modal-back">
            <div class="modal-header">
                <h2 class="modal-title">Add Product</h2>
                <button class="modal-close" id="closeModal">×</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.products.index') }}" method='POST' enctype="multipart/form-data"
                    id="addProductForm">
                    @csrf
                    <div class="form-row">
                        <div class="form-column">
                            <label class="form-label" for="productName">Product Name</label>
                            <input type="text" name="name" class="form-control" id="productName"
                                placeholder="Type product name">
                        </div>
                        <div class="form-column">
                            <label class="form-label" for="category">Category</label>
                            <select class="form-control" name="category_id" id="category">
                                <option value="">Select category</option>
                                @foreach ($productsCats as $productsCat)
                                    <option value="{{ $productsCat->id }}">{{ $productsCat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-column">
                            <label class="form-label" for="short_desc">Short description</label>
                            <input type="text" name="short_desc" class="form-control" id="short_desc"
                                placeholder="Product short description">
                        </div>
                        <div class="form-column">
                            <label class="form-label" for="price">Price</label>
                            <input type="text" name="price" class="form-control" id="price"
                                placeholder="Rs.2999">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-column">
                            <label class="form-label" for="city_id">City</label>
                            <select class="form-control" name="city_id" id="city_id">
                                <option value="">Select City</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="description">Description</label>
                        <textarea class="form-control" name='desc' id="description" placeholder="Write product description here"></textarea>
                    </div>

                    <div class="image-upload-container">
                        <h3 class="image-upload-title">Product Images</h3>
                        <div class="image-upload-grid">
                            <!-- Image 1 -->
                            <div class="image-upload-item" data-index="1">
                                <input type="file" id="imageUpload1" class="hidden" name="image" accept="image/*">
                                <svg class="upload-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                <div class="image-number">Image 1</div>
                            </div>

                            <!-- Image 2 -->
                            <div class="image-upload-item" data-index="2">
                                <input type="file" id="imageUpload2" name="image1" class="hidden" accept="image/*">
                                <svg class="upload-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                <div class="image-number">Image 2</div>
                            </div>

                            <!-- Image 3 -->
                            <div class="image-upload-item" data-index="3">
                                <input type="file" id="imageUpload3" name="image2" class="hidden" accept="image/*">
                                <svg class="upload-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                <div class="image-number">Image 3</div>
                            </div>

                            <!-- Image 4 -->
                            <div class="image-upload-item" data-index="4">
                                <input type="file" id="imageUpload4" name='image3' class="hidden" accept="image/*">
                                <svg class="upload-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                <div class="image-number">Image 4</div>
                            </div>

                            <!-- Image 5 -->
                            <div class="image-upload-item" data-index="5">
                                <input type="file" id="imageUpload5" name='image4' class="hidden" accept="image/*">
                                <svg class="upload-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                <div class="image-number">Image 5</div>
                            </div>

                            <!-- Image 6 -->
                            <div class="image-upload-item" data-index="6">
                                <input type="file" id="imageUpload6" name='image5' class="hidden" accept="image/*">
                                <svg class="upload-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                <div class="image-number">Image 6</div>
                            </div>

                            <!-- Image 7 -->
                            <div class="image-upload-item" data-index="7">
                                <input type="file" id="imageUpload7" name='image6' class="hidden" accept="image/*">
                                <svg class="upload-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                <div class="image-number">Image 7</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-cancel" id="cancelBtn">Cancel</button>
                        <button type='submit' class="btn btn-save">Save product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            console.log("Document ready!");

            // Initialize DataTable
            try {
                console.log("Initializing DataTable...");
                $('.products-table').DataTable();
                console.log("DataTable initialized successfully!");
            } catch (e) {
                console.error("Error initializing DataTable:", e);
            }

            // Handle toast if it exists
            var $successToast = $('#successToast');
            if ($successToast.length) {
                var toast = new bootstrap.Toast($successToast[0], {
                    delay: 3000
                });
                toast.show();
            }

            var $errorToast = $('#errorToast');
            if ($errorToast.length) {
                var toast = new bootstrap.Toast($errorToast[0], {
                    delay: 3000
                });
                toast.show();
            }

            // Show modal function
            window.showModal = function() {
                $('#addProductModal').fadeIn();
                $('body').css('overflow', 'hidden');
            };

            // Show modal on button click
            $('#addProductBtn').on('click', function() {
                showModal();
            });

            // Close modal
            $('#closeModal, #cancelBtn').on('click', function() {
                $('#addProductModal').fadeOut();
                $('body').css('overflow', '');
            });

            // Click outside modal to close
            $('#addProductModal').on('click', function(e) {
                if ($(e.target).is('#addProductModal')) {
                    $('#addProductModal').fadeOut();
                    $('body').css('overflow', '');
                }
            });

            // Handle image uploads
            $('.image-upload-item').each(function() {
                const item = $(this);
                const index = item.data('index');
                const input = $(`#imageUpload${index}`);

                item.on('click', function() {
                    if (!item.find('.image-preview').length) {
                        input.click();
                    }
                });

                input.on('change', function() {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            item.find('.image-preview, .remove-image').remove();

                            const img = $('<img>', {
                                src: e.target.result,
                                class: 'image-preview',
                                css: {
                                    width: '100%',
                                    borderRadius: '8px',
                                    marginTop: '10px'
                                }
                            });
                            const remove = $('<div>', {
                                class: 'remove-image',
                                text: '×',
                                css: {
                                    position: 'absolute',
                                    top: '5px',
                                    right: '10px',
                                    background: '#ff4d4d',
                                    color: 'white',
                                    borderRadius: '50%',
                                    cursor: 'pointer',
                                    fontWeight: 'bold',
                                    width: '20px',
                                    height: '20px',
                                    textAlign: 'center',
                                    lineHeight: '20px',
                                }
                            });

                            item.css('position', 'relative').append(img).append(remove);

                            remove.on('click', function(e) {
                                e.stopPropagation();
                                input.val('');
                                item.find('.image-preview, .remove-image').remove();
                            });
                        };
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            });
        });
    </script>
@endsection
