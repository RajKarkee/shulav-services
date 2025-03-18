@extends('front.page')

@section('meta')
    <meta name="description" content="{{ $vendor->desc }}" />
    <meta property="og:url" content="{{ route('vendor', ['username' => $vendor->username]) }}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $vendor->name }}" />
    <meta property="og:description" content="{{ $vendor->desc }}" />
    <meta property="og:image" content="{{ asset($vendor->image) }}" />
    <script>
        const prod=localStorage.getItem('prod');
        localStorage.removeItem('prod');
        const produrl=('{{route('mobileProduct',['product'=>'xxx'])}}').replace('xxx',prod);
    </script>
@endsection
@section('title', $vendor->name)
@section('jumbotron')
    <li>Vendor</li>
    <li>{{ $vendor->name }}</li>
@endsection
@section('css')
    @php
    $shares_show = ['facebook', 'gmail', 'skype', 'whatsapp', 'instagram', 'twitter', 'telegram', 'messenger'];
    @endphp
    <style>
        .jumbotron {
            display: none;
        }

        #st-1,
        .st-logo,
        .st-disclaimer,
        .st-btn {
            display: none !important;
        }

        .opening-hour>td:first-child{
            font-weight: 600;
        }
    </style>
    @foreach ($shares_show as $site)
        <style>
            .st-btn[data-network='{{ $site }}'] {
                display: inline-block !important;
            }

        </style>
    @endforeach
@endsection
@section('content')
    <div id="single-vendor-page">
        <div class="container pt-2 pt-md-5">
            <div id="vendor-detail-first">
                <div id="first">
                    <div id="vendor-image">
                        <img src="{{ asset($vendor->image) }}" alt="">
                    </div>
                    <div id="vendor-name">
                        {{ $vendor->name }}
                    </div>
                    <div id="vendor-rate" class="d-flex align-items-center justify-content-center">
                        <span class="star d-inline-flex align-items-center">
                            <i class="fas me-1 fa-star"></i>
                            <span id="review-avg">{{round($vendor->review_avg,2)}}</span>
                        </span>
                        <span class="review-count" id="review-count">
                            {{$vendor->review_count}} Reviews
                        </span>
                    </div>
                    {{-- <hr class="mx-2"> --}}

                </div>
                <div id="second">
                    <div class="row m-0">
                        @if ($vendor->email)

                        <div class="col-12 col-md-6">
                            <div class="data">

                                <div class="title">
                                    Email
                                </div>
                                <div class="detail">
                                    <i class="far me-1 fa-envelope"></i>
                                    <a href="mailto:{{ $vendor->email }}">{{ $vendor->email }}</a>
                                </div>
                            </div>

                        </div>
                        @endif
                        @if ($vendor->phone)
                            
                        <div class="col-12 col-md-6">
                            <div class="data">

                                <div class="title">
                                    Phone
                                </div>
                                <div class="detail">
                                    <i class="fas me-1 fa-mobile-alt"></i>
                                    <a href="tel:{{ $vendor->phone }}">{{ $vendor->phone }}</a>
                                </div>
                            </div>

                        </div>
                        @endif
                        <div class="col-12 col-md-6">
                            <div class="data">

                                <div class="title">
                                    City
                                </div>
                                <div class="detail">
                                    <i class="fas me-1 fa-map-marker-alt"></i>
                                    <span>{{ $vendor->city }}</span>
                                </div>
                            </div>

                        </div>
                        <div class="col-12 col-md-6">
                            <div class="data">

                                <div class="title">
                                    Service
                                </div>
                                <div class="detail">
                                    <img src="{{ asset($vendor->service_image) }}" alt="">
                                    <span>{{ $vendor->service }}</span>
                                </div>
                            </div>

                        </div>
                        <div class="col-12">
                            <div class="data">

                                <div class="title">
                                    Street Address
                                </div>
                                <div class="detail">
                                    <i class="far me-1 fa-address-card"></i>
                                    <span>{{ $vendor->address }}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div id="third">
                    <div class="username">
                        {{ '@' . $vendor->username }}
                    </div>
                    <div id="share" data-network="sharethis"
                        onclick="$('#st-1 .st-btn[data-network=\'sharethis\']')[0].click();">
                        <div href="{{ route('share', ['username' => $vendor->username]) }}" class="w-100 btn-share">
                            <span>
                                Share Professional

                            </span>
                            <i class="fas ms-1 fa-share-alt copy"></i>
                        </div>
                    </div>
                    {{-- <div id="socials"> --}}
                        {{-- @include('front.page.vendor.socials') --}}
                        @if (Auth::check() && Auth::user()->role==3 && (Auth::user()->vendor->id!=$vendor->id))
                        <hr>
                            <div id="bookmark">

                                @if ($bookmark==null)

                                <a class="btn-bookmark" href="{{route('user.bookmark',['vendor_id'=>$vendor->id])}}">
                                    <span>
                                        Add Bookmark

                                    </span>
                                    <i class="fas ms-1 fa-bookmark"></i>
                                </a>
                                @else
                                <a class="btn-bookmark" href="{{route('user.bookmark',['vendor_id'=>$vendor->id])}}">
                                    <span>
                                        Remove Bookmark

                                    </span>
                                    <i class="fas ms-1 fa-bookmark"></i>

                                </a>
                                @endif
                            </div>
                        @endif
                    {{-- </div> --}}
                </div>
            </div>
            <div id="vendor-detail-second">

                <div class="about ">
                    <div class="title">
                        About {{ $vendor->name }}
                    </div>
                    <div class="desc">
                        {!! $vendor->desc !!}
                    </div>
                   
                </div>
                @include('front.page.vendor.otherservice')
                
                @include('front.page.vendor.openinghour')
                @include('front.page.vendor.reviews')
                
            </div>

            
        </div>
    </div>
    @include('front.page.vendor.review_single_template')
    <div  class="sharethis-sticky-share-buttons" data-url="{{ route('share', ['username' => $vendor->username]) }}"></div>
    <a href="" id="pop" target="blank"></a>
@endsection
@section('js')
    <script>
        function reImage(ele){
            $(ele).parent().height($(ele).parent().width()*0.6);
        }
    </script>
    <script type="text/javascript"
        src="https://platform-api.sharethis.com/js/sharethis.js#property=61da3087179d600019788988&product=sticky-share-buttons"
        async="async"></script>

        <script>
            const reviews={!! json_encode($reviews) !!};
            const asset="{{$asset}}";
            const $template=$('#single-review-template').html();
            var $tot=0;
            var $count=0;
            var $avg=0;
            $(document).ready(function () {
                let $html="";
                reviews.forEach(review => {
                    $tot+=review.r;
                    $count+=1;
                    review.i=asset+review.i;
                    review.ago=(time_ago(review.c));
                    $html+=template($template,review)
                });
                console.log($html);
                $avg=($tot==0)?0:($tot/$count);
                // $('#reviews-avg').text($avg);
                // $('#reviews-count').text($count+' Reviews');
                if($tot==0){
                    @if (Auth::check())
                    $('#reviews-inner').html('<div class="text-center"><h5>No Reviews yet</h5><button class="btn-primary btn" data-bs-target="#add-review" data-bs-toggle="modal" data-bs->Add First Review</button></div>');
                    @else
                    $('#reviews-inner').html('<div class="text-center"><h5>No Reviews yet</h5><a class="btn-red btn" href="{{route('login',['q'=>route('vendor',['username'=>$vendor->username])])}}">Login To Review</a></div>');

                    @endif
                }else{
                    $('#reviews-inner').html($html);
                    $('.review-description').each(function (index, ele) {
                        if(ele.offsetHeight>110){
                            $(ele).css('height', '110px');
                            $(ele).css('overflow', 'hidden');
                            $(ele).css('position', 'relative');
                            $(ele).append('<div class="overlay"><button class="btn btn-red " onclick="show('+ele.dataset.id+')">View More</button></div>');

                        }



                    });
                }
                @if (Auth::check())
                $('#add-review-form').submit(function (e) {
                    e.preventDefault();
                    axios.post(this.action,new FormData(this))
                    .then((res)=>{
                        const review=res.data.review;
                        let newreview=[];
                        newreview.i=document.querySelector('.profile-image').src;
                        newreview.ago=(time_ago(review.created_at));
                        newreview.n="{{Auth::user()->name}}";
                        newreview.d=review.desc;
                        newreview.vid=review.id;
                        newreview.r=review.rate;
                        if($tot==0){
                            $('#reviews-inner').html(template($template,newreview));

                        }else{

                            $('#reviews-inner').prepend(template($template,newreview));
                        }
                        checkReview(document.querySelector('#review-'+review.id+' .review-description'));
                        $('#close-add-review')[0].click();

                        $('#review-avg').html(parseFloat(res.data.data.review_avg).toFixed(2));
                        $('#review-count').html(res.data.data.review_count);
                    })
                    .catch((err)=>{
                        console.log(err);

                    });
                });
                @endif

                window.onload=function(){
                    if(location.hash!=''){
                        // console.log(location.hash);
                        // $('.product').removeClass('active');
                        // $(location.hash).addClass('active');
                        // oldhash=location.hash;
                        location.hash=='';
                    }else{
                        
                        if(prod!=null){
                            if(window.innerWidth<425){
                                localStorage.setItem('uname','{{$vendor->username}}')
                                window.location.href=produrl;

                            }else{
                                showProduct('product-'+prod);
                            }
                        }
                        
                    }
                      
                };
                $('.product-wrapper>.image>img').each(function (index, element) {
                    this.onload=reImage(element);
                    console.log(element);
                });
               
            });

            function checkReview(ele){
                if(ele.offsetHeight>110){
                    $(ele).css('height', '110px');
                    $(ele).css('overflow', 'hidden');
                    $(ele).css('position', 'relative');
                    $(ele).append('<div class="overlay"><button class="btn btn-red " onclick="show('+ele.dataset.id+')">View More</button></div>');

                }

            }
            function show(id) {
                $('#review-'+id).addClass('active-review');
                $('#review-'+id).append('<button id="btn-close-'+id+'" onclick="closeReview('+id+')" class="btn-close">&times;</button>');
            }
            function closeReview(id) {

                $('#review-'+id).removeClass('active-review');
                $('#btn-close-'+id).remove();
            }

            function showProduct(id){
                location.hash =id;
            }
            var oldhash='';
            const defaultShareUrl="{{ route('share', ['username' => $vendor->username]) }}";
            window.addEventListener('hashchange', function(e){
                console.log(location.hash);
                if(oldhash==location.hash){

                }else{
                    $('.product').removeClass('active');
                    if(location.hash!=''){
                        console.log($(location.hash).data('url'));
                        $(location.hash).addClass('active');
                        $('#st-1')[0].dataset.url= $(location.hash)[0].dataset.url;
                    }
                    oldhash=location.hash;
                }
                console.log('hash changed'+location.hash)
            });

            function back() {
                // if(prod!=0){
                //     // location.hash='products';
                // }
                // else{
                //   history.back();
                // }   
                    location.hash='';
                    history.replaceState(null, null, ' ');
                    if(window.innerWidth<425){
                        $([document.documentElement, document.body]).animate({
                            scrollTop: $("#products").offset().top- $('.mobile-head').height()-50
                        }, 10);
                    }else{
                        $([document.documentElement, document.body]).animate({
                            scrollTop: $("#products").offset().top- $('.head.page').height()-50
                        }, 10);
                    }
                    $('#st-1')[0].dataset.url= defaultShareUrl;


                // prod=0;
            }

            

        </script>
@endsection
