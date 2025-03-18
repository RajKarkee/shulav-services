@foreach ($images as $image)
    <div class="col-md-3 col-6 p-0" id="image-{{$image->id}}">
        <div class="single-image">
            <img src="{{ asset($image->file) }}" alt="" class="w-100">
            <button class="btn btn-red w-100" onclick="removeImage({{$image->id}})">
                Remove
            </button>
        </div>
    </div>
@endforeach
