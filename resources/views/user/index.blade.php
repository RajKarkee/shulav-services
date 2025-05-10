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
                            My Products
                        </h5>
                        <hr class="m-0">
                        <div class="p-3" >
                            <div id="reviews">
                                <div id="reviews-inner"></div>
                            </div>
                        </div>
                    </div>
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
