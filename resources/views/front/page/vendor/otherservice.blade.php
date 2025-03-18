{{-- @if ($products->where('type',2)->count() > 0)
<div class="bg-white shadow mt-2">
    <div class="card-body">
        <div class="title">
             Services
        </div>
        <div class="desc">
            <div class="row">
                @foreach ($products->where('type',2) as $product)
                    
                    <div class="col-md-3 py-2">
                        <div title="{{$product->short_desc}} " id="product-{{$product->id}}" class="product  shadow" onclick="showProduct('product-{{$product->id}}');">
                            <span class="close shadow" onclick="event.stopPropagation();back();">
                                <i class="fas fa-close"></i>
                            </span>
                            <span class="back " onclick="event.stopPropagation();back();">
                                <i class="fas fa-arrow-left"></i>
                            </span>
                            <div class="product-wrapper">
                                <div class="image">
                                    <img class="w-100" src="{{asset($product->image)}}" alt="">  
                                </div>
                                <div class="all">
                                    <div class="product-name">
                                        {{$product->name}} 
                                    </div> 
                                    <div class="product-price">
                                        Rs. {{$product->price+0}} 
                                    </div>   

                                    <div class="product-desc text-justify">
                                        <hr class="m-0">
                                        <div class="p-2">
                                            {!! $product->desc !!}
                                        </div>
                                    </div>   
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
        
    </div>
</div>
@endif
@if ($products->where('type',1)->count() > 0)
<div class="bg-white shadow mt-2">
    <div class="card-body">
        <div class="title">
             Products
        </div>
        <div class="desc" id="products">
            <div class="row">
                @foreach ($products as $product)
                    
                    <div class="col-md-3 py-2">
                        <div title="{{$product->short_desc}} " id="product-{{$product->id}}" class="product  shadow" onclick="showProduct('product-{{$product->id}}');">
                            <span class="close shadow" onclick="event.stopPropagation();back();">
                                <i class="fas fa-close"></i>
                            </span>
                            <span class="back " onclick="event.stopPropagation();back();">
                                <i class="fas fa-arrow-left"></i>
                            </span>
                            <div class="product-wrapper">
                                <div class="image">
                                    <img class="w-100" src="{{asset($product->image)}}" alt="">  
                                </div>
                                <div class="all">
                                    <div class="product-name">
                                        {{$product->name}} 
                                    </div> 
                                    <div class="product-price">
                                        Rs. {{$product->price+0}} 
                                    </div>   

                                    <div class="product-desc text-justify">
                                        <hr class="m-0">
                                        <div class="p-2">
                                            {!! $product->desc !!}
                                        </div>
                                    </div>   
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
       
    </div>
</div>
@endif --}}

<div class="bg-white shadow mt-2">
    <div class="card-body">
        <div class="title">
             Products
        </div>
        <div class="desc" id="products">
            <div class="row">
                @foreach ($products as $product)
                    
                    <div class="col-md-3 py-2">
                        <div onclick=" window.location.href='{{ route('product', ['product' => $product->id]) }}'"  id="product-{{$product->id}}" class="product  shadow" onclick="showProduct('product-{{$product->id}}');">
                           
                            <div class="product-wrapper">
                                <div class="image">
                                    <img  class="w-100" src="{{asset($product->image)}}" alt="">  
                                </div>
                                <div class="all">
                                    <div class="product-name">
                                        {{$product->name}} 
                                    </div> 
                                    <div class="product-price">
                                        Rs. {{$product->price+0}} / {{$product->short_desc}}
                                    </div>   
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
       
    </div>
</div>