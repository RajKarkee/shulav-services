@extends('front.page')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container .select2-selection--single{
        height: 38px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 38px;
    }
    .select2-container--default .select2-selection--single .select2-selection__clear,.select2-container--default .select2-selection--single .select2-selection__arrow {
        width:36px;
        height: 36px;
    }
    select2-container--default .select2-selection--single .select2-selection__arrow {
        font-size: 35px;
    }
    .select2-container--default .select2-selection--single .select2-selection__clear{
        font-size: 35px;
        font-weight: 400;
        text-align: center;
        width: 50px;
        display: inline-flex;
        align-items:center;
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
    @include('front.page.search.vendortemplate')
    <div id="page-search" class="py-5">

        <div class="container pb-3" id="page-search-container">
            <form action="{{route('search')}}">

                <div class="row mb-3">
                    <div class="col-md-5">
                        <label for="City">City</label>
                        <select data-allow-clear="true" data-placeholder="Select a Location" name="loc_id" id="city" class="form-control select2">
                            <option value="" selected disabled>Select A Location</option>

                            @foreach ($cities as $city)
                                <option value="{{$city->id}}" {{$city->id==$loc_id?'selected':''}}>{{$city->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label for="service">Service</label>
                        <select data-allow-clear="true" data-placeholder="Select a Service" name="ser_id" id="service" class="form-control select2">
                            <option value="" selected disabled>Select A Service</option>

                            @foreach ($services as $service)
                                <option value="{{$service->id}}" {{$service->id==$ser_id?'selected':''}}>{{$service->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end"><button class="btn btn-search">Search</button></div>
                </div>
            </form>

        </div>
        @if (!$empty)
            @if ($vendors->count()>0)

            <div id="loadmore" class="text-center" style="display: none;">
                <button class="btn btn-red">
                    Load more
                </button>
            </div>
            <div id="loading" class="text-center text-black" >
               loading...
            </div>
            @else
            <div class="not-found">
                <img src="{{asset('front/notfound.svg')}}" alt="">
            </div>
            <h2 class="my-2 text-center text-black ">
                No Professionals Found.
            </h2>
            @endif
        @else


        @endif
    </div>
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@if(!$empty)
    <script src="{{ asset('front/js/lazy.js') }}"></script>
    <script>

        const ismobile=false;
        // const ismobile=window.innerWidth<426;
        var loading=true;
        var temp_loading=true;

        var interval=setInterval(() => {
            if(loading!=temp_loading){
                temp_loading=loading;
                if(loading){
                    $('#loadmore').hide();
                    $('#loading').show();
                }else{
                    $('#loadmore').show();
                    $('#loading').hide();
                }
            }
        }, 100);


        //vendor data
        var vendors={!!json_encode($vendors)!!};
        var vendor_template;
        // console.log(vendors);
        $(document).ready(function () {
            $('.select2').select2();
            if(vendors.data.length>0){

                if(ismobile){
                    $('#page-search-container').append('<div id="vendors-column"></div>')
                    vendor_template=$('#vendor-template-mobile').html();
                }else{
                    $('#page-search-container').append('<div class="row" id="vendors"></div>')
                    vendor_template=$('#vendor-template').html();
                }
                renderVendors(vendors.data,vendors.current_page);

                lazy.init('.lazy-'+vendors.current_page);

                $('#loadmore').click(function (e) {
                    e.preventDefault();
                    if(!loading && vendors.last_page>vendors.current_page){
                        loadMore();
                    }
                });
                loading=false;
            }else{
                clearInterval(interval);
                $('#loadmore').remove();
                $('#loading').remove();
            }
        });


        function renderVendors(data,step){
            html='';
            data.forEach(vendor => {
                const review_avg=vendor.review_avg!=null?parseFloat(vendor.review_avg).toFixed(2):'0';
                _html=strReplaceAll(vendor_template,['xxx_step','xxx_id','xxx_image','xxx_address','xxx_phone','xxx_name','xxx_city','xxx_service','xxx_username','xxx_count','xxx_rate','xxx_reviews'],[step,vendor.id,vendor.image,vendor.address,vendor.phone,vendor.name,vendor.city,vendor.service,vendor.username,vendor.count,review_avg,vendor.review_count]);
                html+=_html;
            });
            if(ismobile){
                $('#vendors-column').append(html);

            }else{
                $('#vendors').append(html);

            }
            if(vendors.current_page==vendors.last_page){
                    clearInterval(interval);
                    $('#loadmore').remove();
                    $('#loading').remove();
            }
        }
        function loadMore() {
            loading=true;
            axios.post(vendors.next_page_url,{_token:'{{csrf_token()}}'})
            .then((res)=>{
                // console.log(res.data);
                vendors.data=vendors.data.concat(res.data.data);
                vendors.next_page_url=res.data.next_page_url;
                vendors.current_page=res.data.current_page;
                renderVendors(res.data.data,res.data.current_page);
                lazy.initLazyLoading('.lazy-'+vendors.current_page);
                loading=false;


            })
            .catch((err)=>{
                // console.log(err);
                false;
            });
        }

    </script>
@else
    <script>
        $(document).ready(function () {
            $('.select2').select2();

        });
    </script>
@endif
@endsection
