@extends('front.page')
@section('css')
    <link rel="stylesheet" href="{{ asset('front/vendor/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('front/rcrop.min.css') }}">

@endsection
@section('title', 'Vendor Reviews ')

@section('content')

<div id="vendor-dashboard-page">
    <div>
        <div class="row">
            @include('vendor.dashboard.sidebar')
            <div class="col-md-8   ">
                <div class="bg-white shadow mb-3" >
                    <div class="card-body " id="jumbotron">
                        <a href="{{route('vendor.dashboard')}}">Dashboard</a>
                        <span>Reviews</span>
                    </div>
                </div>
                @include('vendor.dashboard.due')

                <div class="bg-white shadow mb-3" >
                    <div class="card-body " >
                        <div class="row">
                            <div class="col-md-4 text-center d-flex align-items-center">
                                <div class="w-100">
                                    <h5>Total Reviews</h5>
                                    <p>{{$count->review_count}}</p>
                                    <hr>
                                    <h5>Rating</h5>
                                    <p>{{round( $count->review_avg,2)}}</p>
                                </div>
                            </div>
                            <div class="col-md-8" id="review-overview">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white shadow p-3 mb-3">
                    <div id="reviews" style="background: white;">
                        <div id="reviews-inner"></div>
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>
@include('front.page.vendor.review_single_template')

@endsection
@section('js')
    @include('vendor.dashboard.imagejs')
    @include('vendor.dashboard.namejs')
    @include('vendor.dashboard.descjs')
    <script>
        const reviews = {!! json_encode($reviews) !!};
        const asset = "{{ asset('') }}";
        const overview ={!! json_encode($overview) !!};
        const $template = $('#single-review-template').html();
        const colors=['#49d602','#f45ec2','#ae5bcc','#fdff1f','#33ffcc'];
        var $ratio = 0;
        var $max = 0;
        $(document).ready(function() {
            let $html = "";
            reviews.forEach(review => {
                review.i = asset + review.i;
                review.ago = (time_ago(review.c));
                $html += template($template, review)
            });
            for (let index = 1; index < 6; index++) {
                const o = overview['review_count_'+index];
                if($max<o){
                    $max=o;
                    if($max!=0){
                        $ratio=100/$max;
                    }
                }
            }
            $('#reviews-inner').html($html);

            html='';
            for (let index = 1; index < 6; index++) {
                const o = overview['review_count_'+index];
                let per=Math.ceil(o*$ratio);
                if (per>100) {
                    per=100;
                }
                html+='<div class="review-container mb-2">'+
                    '<div class="d-flex align-items-end">'+
                        '<span style="width:50px;display: inline-flex;align-items: flex-end;justify-content:flex-end;padding-right:5px;">'+index+' <i class="fas fa-star" style="font-size:20px;color:'+(colors[5-index])+';"></i></span>'+
                        '<div style="flex-grow:1">'+
                            '<h6 class="mb-0">'+o+' Reviews</h6>'+
                            '<div style="background:'+(colors[5-index])+';height:10px;width:'+(per)+'%;"></div>'+
                        '</div>'+
                    '</div>'+
                '</div>';
            }

            $('#review-overview').html(html);
            console.log($html);
        });
    </script>
@endsection
