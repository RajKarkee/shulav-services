@extends('front.page')
@section('css')
    <link href="{{ asset('front/contact.css') }}" rel="stylesheet" />
    <style>

    </style>
@endsection
@section('meta')
    @include('front.index.meta')
@endsection
@section('title')
    {{ $faq->q }}
@endsection
@section('jumbotron')
    <li>{{ $faq->q }}</li>
@endsection
@section('content')
<div id="faq-page">

    <div class="container">
        <div class="content">

            <div class="row">
                <div class="col-md-7">
                    <div class="q">
                        <strong>
                            Q.
                        </strong>
                        {{ $faq->q }}
                    </div>
                    <div class="a">
                        {!! $faq->a !!}
                    </div>
                </div>
                <div class="col-md-5 pt-3">
                    @if ($faq->hasOther())
                        <div class="title after" >
                            Other Questions
                        </div>
                        @foreach ($faq->other() as $other)
                            <a target="_blank" class="other"
                                href="{{ route('faq', ['faq' => $other->id]) }}">{{ $other->q }}</a>
                        @endforeach
                    @endif
                </div>
            </div>

        </div>


    </div>
</div>
@endsection
@section('js')

@endsection
