@extends('front.page')
@section('css')
    <link rel="stylesheet" href="{{ asset('front/vendor/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('front/rcrop.min.css') }}">
    <style>
        .bookmark{
            display: block;
            text-decoration: none;
        }
        .bookmark>.image{
            padding:20px;
        }
        .bookmark>.desc{
            padding: 10px;
            font-weight: 500;
            text-align: center
        }
        .bookmark>.image>img{
            width: 100%;
            border-radius: 50%;
            overflow: hidden;
        }
        .remove-bookmark{
            position: absolute;top:0px;right:0px;height:40px;width:40px;display:flex;align-items: center;justify-content: center;text-decoration: none;
        }
        .remove-bookmark:hover{
            color: rgb(219, 219, 219);
        }
    </style>
@endsection
@section('title', 'User Dashboard ')

@section('content')
    <div id="vendor-dashboard-page">
        <div>
            <div class="row">
                @include('user.dashboard.sidebar')
                <div class="col-md-8   ">
                    <div class="bg-white shadow mb-3" >
                        <div class="card-body " id="jumbotron">
                            <a href="{{route('user.dashboard')}}">Dashboard</a>

                        </div>
                    </div>
                    <div class="bg-white shadow mb-3" >
                        <h5 class="p-3">
                            My Reviews
                        </h5>
                        <hr class="m-0">
                        <div class="p-3" >
                            <div id="reviews">
                                <div id="reviews-inner"></div>
                            </div>
                        </div>
                    </div>

                    @if(count($bookmarks)>0)
                    <div class="bg-white shadow mb-3" >
                        <h5 class="p-3">
                            Bookmarks
                        </h5>
                        <hr class="m-0">
                        <div class="p-3" >
                            <div class="row">
                                @foreach ($bookmarks as $bookmark)

                                <div class="col-md-4 mb-3" style="position: relative;">
                                    <a target="_blank" href="{{route('vendor',['username'=>$bookmark->username])}}" class="bookmark shadow">
                                        <div class="image">
                                            <img class="w-100" src="{{asset($bookmark->image)}}" alt="">
                                        </div>
                                        <div class="desc">
                                            {{$bookmark->name}}
                                        </div>
                                    </a>
                                    <a href="{{route('user.bookmark',['vendor_id'=>$bookmark->id])}}" style="" class="btn-red remove-bookmark">
                                        <span class="material-icons">
                                            bookmark_remove
                                        </span>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                    @if(count($histories)>0)
                    <div class="bg-white shadow mb-3" >
                        <h5 class="p-3">
                            Visited Professionals
                        </h5>
                        <hr class="m-0">
                        <div class="p-3" >
                            <div class="row">
                                @foreach ($histories as $bookmark)

                                <div class="col-md-4 mb-3" style="position: relative;">
                                    <a target="_blank" href="{{route('vendor',['username'=>$bookmark->username])}}" class="bookmark shadow">
                                        <div class="image px-5">
                                            <img class="w-100" src="{{asset($bookmark->image)}}" alt="">
                                        </div>
                                        <div class="desc">
                                            {{$bookmark->name}}
                                        </div>
                                    </a>

                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('front.page.vendor.review_single_template')
@endsection
@section('js')
    @include('user.dashboard.imagejs')
    @include('user.dashboard.namejs')
    @include('user.dashboard.descjs')
    <script>
        const reviews = {!! json_encode($reviews) !!};
        const asset = "{{ asset('') }}";
        const $template = $('#single-review-template').html();
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
                $('#reviews-inner').html($html);
                console.log($html);
            });
        $('#selector>span').click(function(e) {
            e.preventDefault();
            $('#selector>span').removeClass('active');
            $('.choice').removeClass('active');
            $('.choice' + $(this).data('select')).addClass('active');
            $(this).addClass('active');
        });
    </script>
@endsection
