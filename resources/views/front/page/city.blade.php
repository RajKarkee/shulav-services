@extends('front.page')

@section('meta')
    <meta name="description" content="{{ $city->desc }}" />
    <meta property="og:url" content="{{ route('city', ['id' => $city->id]) }}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $city->name }}" />
    <meta property="og:description" content="{{ $city->desc }}" />
    <meta property="og:image" content="{{ asset($city->image) }}" />
@endsection
@section('title', $city->name)
@section('jumbotron')
    <li>City</li>
    <li>{{ $city->name }}</li>
@endsection
@section('content')
    <div class="container py-5">
        <div class="page">
            <h3 class="text-center mb-4 text-black">
                Popular Vendors in {{ $city->name }} City
            </h3>
            <div class="row" id="vendors">
                {{-- @foreach ($vendors as $vendor)

                @endforeach --}}
            </div>
            <hr>


        </div>
    </div>
    <div class="services">
        <h3 class="text-center mb-4 text-black">
            Service Avialable in {{ $city->name }} City
        </h3>
        <div class="service-holder">
            <div class="row" id="services">
                @foreach ($services as $service)
                    <div class="col-lg-2 col-md-4 col-6">
                        <a href="{{route('search',['loc_id'=>$city->id,'ser_id'=>$service->id])}}" class="square d-block">
                            <div class="single-service square-inner">
                                {{-- <div class="count">
                                    {{$service->c}}
                                </div> --}}
                                <img
                                    data-src="{{asset($service->image)}}" src="/uploads/service/blank.svg" class="lazy">
                                <div class="name">
                                    {{$service->name}}
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
    @include('front.page.city.vendortemplate')
@endsection
@section('js')
    <script src="{{ asset('front/js/lazy.js') }}"></script>

    <script>
        //vendor data
        var vendors = {!! json_encode($vendors) !!};
        const vendor_template = $('#vendor-template').html();
        // console.log(vendors);
        $(document).ready(function() {
            renderVendors(vendors.data, vendors.current_page);
            lazy.init('.lazy-' + vendors.current_page);
            lazy.initLazyLoading('.lazy');
            loading = false;
        });

        function renderVendors(data, step) {
            html = '';
            data.forEach(vendor => {
                const review_avg=vendor.review_avg!=null?parseFloat(vendor.review_avg).toFixed(2):'0';

                _html = strReplaceAll(vendor_template, ['xxx_step', 'xxx_id', 'xxx_image', 'xxx_service',
                    'xxx_phone', 'xxx_name', 'xxx_address', 'xxx_username','xxx_reviews','xxx_rate','xxx_count'
                ], [step, vendor.id, vendor.image, vendor.service, vendor.phone, vendor.name, vendor.address, vendor.username,vendor.review_count,review_avg,vendor.count])
                html += _html;
            });
            $('#vendors').append(html);
        }
    </script>
@endsection
