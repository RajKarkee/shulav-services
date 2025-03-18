<div class="row">
    @foreach ($tops as $top)
        {{-- @for ($i = 0; $i < 2; $i++) --}}
        {{-- <div class="col-md-3 mb-3 "> --}}
        <a class=" top-product " href="{{ route('product', ['product' => $top->id]) }}">
            <div class="holder shadow h-100">
                <div class="image">
                    <img src="{{ asset($top->image) }}" alt="">
                </div>
                <div class="top-title ">
                    {{ $top->name }}
                </div>
                <div class="top-price text-red">
                    {{ $top->price }} / {{$top->short_desc}}
                </div>
             
            </div>
        </a>
        {{-- </div> --}}
        {{-- @endfor --}}

    @endforeach
</div>