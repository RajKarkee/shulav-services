@extends('front.page')

@section('meta')
<meta name="description" content="Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi rem, voluptatibus aliquid hic sed laborum ad delectus sapiente voluptas corporis ipsum neque nulla earum odit, dolorum accusamus, ab dolores vel.
" />
<meta property="og:url"                content="{{route('services')}}" />
<meta property="og:type"               content="article" />
<meta property="og:title"              content="{{env('APP_NAME')}} - services" />
<meta property="og:description"        content="Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi rem, voluptatibus aliquid hic sed laborum ad delectus sapiente voluptas corporis ipsum neque nulla earum odit, dolorum accusamus, ab dolores vel.
" />
<meta property="og:image"              content="/uploads/banner.png" />
@endsection
@section('title',"Categories")
@section('jumbotron')
    <li>Categories</li>
@endsection
@section('content')
<div id="page-services" class="pt-5" >
    <div class="container">

        <div class="row">
            @foreach ($cats as $cat)
               <div class="col-md-2">

                    <div class="city ">
                        <img src="{{asset($cat->image)}}" alt="">
                        <div class="name">
                            {{$cat->name}}
                        </div>
                    </div>
               </div>
               <div class="col-md-10" id="cat-{{$cat->id}}">
                    @if($cat->services!=null)
                    <div class="row">
                        @foreach (explode(',',$cat->services) as $item)
                            @php
                            $ser=explode(':',$item);
                            @endphp
                            <div class="col-md-2 col-6 pb-3 mobile-sm">
                                <a href="{{route('search',['ser_id'=>$ser[0]])}}" class="city h-100">
                                    <img src="{{asset($ser[2])}}" alt="">
                                    <div class="name">
                                        {{$ser[1]}}
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    @endif
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
