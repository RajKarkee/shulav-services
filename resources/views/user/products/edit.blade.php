<div class="modal-body">
    <form action="{{ route('user.products.edit', $product->id) }}" method="POST" enctype="multipart/form-data"
        id="editProductForm">
        @csrf
        <div class="form-row">
            <div class="form-column">
                <label class="form-label" for="productName">Product Name</label>
                <input type="text" name="name" class="form-control" id="EditproductName" value="{{ $product->name }}"
                    placeholder="Type product name">
            </div>
            <div class="form-column">
                <label class="form-label" for="category">Category</label>
                <select class="form-control" name="editCategory_id" id="category">
                    <option value="">Select category</option>
                    @foreach ($productsCats as $productsCat)
                        <option value="{{ $productsCat->id }}"
                            {{ $product->category_id == $productsCat->id ? 'selected' : '' }}>{{ $productsCat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-column">
                <label class="form-label" for="short_desc">Short description</label>
                <input type="text" name="short_desc" class="form-control" id="short_desc"
                    value="{{ $product->short_desc }}" placeholder="Product short description">
            </div>
            <div class="form-column">
                <label class="form-label" for="price">Price</label>
                <input type="text" name="price" class="form-control" id="editPrice" value="{{ $product->price }}"
                    placeholder="Rs.2999">
            </div>
        </div>
        <div class="form-row">
            <div class="form-column">
                <label class="form-label" for="city_id">City</label>
                <select class="form-control" name="edit_city_id" id="city_id">
                    <option value="">Select City</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}" {{ $product->city_id == $city->id ? 'selected' : '' }}>
                            {{ $city->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="description">Description</label>
            <textarea class="form-control" name='desc' id="edit_description" placeholder="Write product description here">{{ $product->desc }}</textarea>
        </div>

        <div class="image-upload-container">
            <h3 class="image-upload-title">Product Images</h3>
            <div class="image-upload-grid">
                @for ($i = 0; $i < 7; $i++)
                    <div class="image-upload-item" data-index="{{ $i + 1 }}">
                        <input type="file" id="imageUpload{{ $i + 1 }}" class="hidden"
                            name="image-{{ $i }}" accept="image/*">
                        @if (isset($product->{'image' . ($i > 0 ? $i : '')}))
                            <img src="{{ asset('storage/' . $product->{'image' . ($i > 0 ? $i : '')}) }}"
                                class="preview-image" alt="Product image {{ $i + 1 }}">
                            <button type="button" class="remove-image" data-index="{{ $i }}">×</button>
                        @else
                            <svg class="upload-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                        @endif
                        <div class="image-number">Image {{ $i + 1 }}</div>
                    </div>
                @endfor
            </div>
        </div>
        <div class="modal-footer">
            <a onclick="closeModal()" class="btn btn-cancel">Cancel</a>
            <button type='submit' class="btn btn-save" onclick="updateModal({{ $product->id }})">Update product</button>
        </div>
    </form>
</div>
@section('js2')
<script>
    function initEdit(id){

    }
</script>
@endsection
