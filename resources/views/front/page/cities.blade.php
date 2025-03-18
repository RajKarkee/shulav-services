@extends('front.page')

@section('meta')
<meta name="description" content="Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi rem, voluptatibus aliquid hic sed laborum ad delectus sapiente voluptas corporis ipsum neque nulla earum odit, dolorum accusamus, ab dolores vel.
" />
<meta property="og:url"                content="{{route('cities')}}" />
<meta property="og:type"               content="article" />
<meta property="og:title"              content="{{env('APP_NAME')}} - Cities" />
<meta property="og:description"        content="Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi rem, voluptatibus aliquid hic sed laborum ad delectus sapiente voluptas corporis ipsum neque nulla earum odit, dolorum accusamus, ab dolores vel.
" />
<meta property="og:image"              content="/uploads/banner.png" />
@endsection
@section('title',"cities")
@section('jumbotron')
    <li>Cities</li>
@endsection
@section('content')
<div id="cities" class="pt-5" >
    <div class="container">

        <div class="row">
            @foreach ($cities as $city)
                <div class="col-6 col-md-4">
                    <a title="{{$city->desc}}" href="{{route('city',['id'=>$city->id])}}" class="single-city" id="city-{{$city->id}}">
                        <img data-src="{{asset($city->image)}}" class="lazy" src="/uploads/city/blank.svg" alt="">
                        <div class="desc">
                            <div class="name">
                                {{$city->name}}
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{asset('front/js/lazy.js')}}"></script>
<script>
    lazy.init('.lazy');
</script>
@endsection
