@extends('front.page')

@section('meta')
<meta name="description" content="{{$service->desc}}" />
<meta property="og:url"                content="{{route('service',['id'=>$service->id])}}" />
<meta property="og:type"               content="article" />
<meta property="og:title"              content="{{$service->title}}" />
<meta property="og:description"        content="{{$service->desc}}" />
<meta property="og:image"              content="{{asset($service->image)}}" />
@endsection
@section('title',$service->name)
@section('jumbotron')
    <li>Services</li>
    <li>{{$service->name}}</li>
@endsection
@section('content')
    <div class="container py-5">
        <div class="page">
            <div class="row" id="vendors">
                {{-- @foreach ($vendors as $vendor)

                @endforeach --}}
            </div>
            <div id="loadmore" class="text-center" style="display: none;">
                <button class="btn btn-primary">
                    Load more
                </button>
            </div>
            <div id="loading" class="text-center" >
               loading...
            </div>
        </div>
    </div>
    @include('front.page.service.vendortemplate')
@endsection
@section('js')
<script src="{{asset('front/js/lazy.js')}}"></script>

    <script>

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
        const vendor_template=$('#vendor-template').html();
        // console.log(vendors);
        $(document).ready(function () {
            renderVendors(vendors.data,vendors.current_page);

            lazy.init('.lazy-'+vendors.current_page);

            $('#loadmore').click(function (e) {
                e.preventDefault();
                if(!loading && vendors.last_page>vendors.current_page){
                    loadMore();
                }
            });
            loading=false;
        });


        function renderVendors(data,step){
            html='';
            data.forEach(vendor => {
                _html=strReplaceAll(vendor_template,['xxx_step','xxx_id','xxx_image','xxx_city','xxx_phone','xxx_name'],[step,vendor.id,vendor.image,vendor.city,vendor.phone,vendor.name])
                html+=_html;
            });
            $('#vendors').append(html);
        }
        function loadMore() {
            loading=true;
            axios.post(vendors.next_page_url,{})
            .then((res)=>{
                // console.log(res.data);
                renderVendors(res.data.data,res.data.current_page);
                vendors.data=vendors.data.concat(res.data.data);
                vendors.next_page_url=res.data.next_page_url;
                vendors.current_page=res.data.current_page;
                lazy.initLazyLoading('.lazy-'+vendors.current_page);
                loading=false;
                if(vendors.current_page==vendors.last_page){
                    clearInterval(interval);
                    $('#loadmore').remove();
                    $('#loading').remove();
                }

            })
            .catch((err)=>{
                // console.log(err);
                false;
            });
        }

    </script>
@endsection
