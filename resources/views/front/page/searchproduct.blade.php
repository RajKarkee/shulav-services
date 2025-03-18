@extends('front.page')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single {
            height: 38px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;
        }

        .select2-container--default .select2-selection--single .select2-selection__clear,
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            width: 36px;
            height: 36px;
        }

        select2-container--default .select2-selection--single .select2-selection__arrow {
            font-size: 35px;
        }

        .select2-container--default .select2-selection--single .select2-selection__clear {
            font-size: 35px;
            font-weight: 400;
            text-align: center;
            width: 50px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

    </style>
@endsection
@section('meta')
    <meta name="description" content="Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi rem, voluptatibus aliquid hic sed laborum ad delectus sapiente voluptas corporis ipsum neque nulla earum odit, dolorum accusamus, ab dolores vel.
        " />
@endsection
@section('title', 'search')
@section('jumbotron')
    <li>Search</li>
@endsection
@section('content')
    <div id="page-search" class="py-5">
        <div class="container pb-3" id="page-search-container">
            <form action="{{ route('search') }}">

                <div class="row mb-3">
                    <div class="col-md-5">
                        <label for="City">City</label>
                        <select data-allow-clear="true" data-placeholder="Select a Location" name="loc_id" id="city"
                            class="form-control select2">
                            <option value="" selected disabled>Select A Location</option>

                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}" {{ $city->id == $loc_id ? 'selected' : '' }}>
                                    {{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label for="service">Service Type</label>
                        <select data-allow-clear="true" data-placeholder="Select a Service" name="ser_id" id="service"
                            class="form-control select2">
                            <option value="" selected disabled>Select A Service</option>

                            @foreach ($services as $service)
                                <option value="{{ $service->id }}" {{ $service->id == $ser_id ? 'selected' : '' }}>
                                    {{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end"><button class="btn btn-search">Search</button></div>
                </div>
            </form>

        </div>
        <div class="container">
            <div class="row products" id="products">

            </div>
            @if (!$empty)
                @if ($products->count() > 0)
                    <div id="loadmore" class="text-center" style="display: none;">
                        <button class="btn btn-red">
                            Load more
                        </button>
                    </div>
                    <div id="loading" class="text-center text-black">
                        loading...
                    </div>
                @else
                    <div class="not-found">
                        <img src="{{ asset('front/notfound.svg') }}" alt="">
                    </div>
                    <h2 class="my-2 text-center text-black ">
                        No Products or Services Found.
                    </h2>
                @endif
            @endif
        </div>
    </div>
    @include('front.page.searchproduct.template')
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @if (!$empty)
        <script>
            //vendor data
            var products = {!! json_encode($products) !!};
            var product_template;
            var loading=true;
            var temp_loading=true;
            const asset="{{$asset}}";
            $(document).ready(function() {
                $('.select2').select2();
                if (products.data.length > 0) {

                    product_template = $('#template').html();
                    renderProducts(products.data, products.current_page);
                    $('#loadmore').click(function(e) {
                        e.preventDefault();
                        if (!loading && vendors.last_page > vendors.current_page) {
                            loadMore();
                        }
                    });
                    loading = false;
                } else {
                    clearInterval(interval);
                    $('#loadmore').remove();
                    $('#loading').remove();
                }
            });
            var interval = setInterval(() => {
                if (loading != temp_loading) {
                    temp_loading = loading;
                    if (loading) {
                        $('#loadmore').hide();
                        $('#loading').show();
                    } else {
                        $('#loadmore').show();
                        $('#loading').hide();
                    }
                }
            }, 100);

            function renderProducts(data,step){
                html='';
                data.forEach(product => {
                   
                    _html=strReplaceAll(product_template,['xxx_id','xxx_image','xxx_name','xxx_price'],[product.id,asset+product.image,product.name,product.price]);
                    html+=_html;
                });
                    $('#products').append(html);
                
                if(products.current_page==products.last_page){
                        clearInterval(interval);
                        $('#loadmore').remove();
                        $('#loading').remove();
                }
            }


            function loadMore() {
                loading = true;
                axios.post(products.next_page_url, {
                        _token: '{{ csrf_token() }}'
                    })
                    .then((res) => {
                        // console.log(res.data);
                        products.data = products.data.concat(res.data.data);
                        products.next_page_url = res.data.next_page_url;
                        products.current_page = res.data.current_page;
                        renderProducts(res.data.data, res.data.current_page);
                        lazy.initLazyLoading('.lazy-' + products.current_page);
                        loading = false;


                    })
                    .catch((err) => {
                        // console.log(err);
                        false;
                    });
            }
        </script>
    @else
        <script>
            $(document).ready(function() {
                $('.select2').select2();

            });
        </script>
    @endif
@endsection
