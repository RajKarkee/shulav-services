@extends('front.page')

@section('meta')
    <meta name="description" content="{{ $vendor->desc }}" />
    <meta property="og:url" content="{{ route('vendor', ['username' => $vendor->username]) }}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $vendor->name }}" />
    <meta property="og:description" content="{{ $vendor->desc }}" />
    <meta property="og:image" content="{{ asset($vendor->image) }}" />
@endsection
@section('title', $vendor->name)
@section('jumbotron')
    <li>Vendor</li>
    <li>{{ $vendor->name }}</li>
@endsection
@section('css')
    <style>
        .jumbotron {
            display: none;
        }

    </style>
@endsection
@section('content')
    <div class="" id="single-vendor-container">
        <div class="container">
            <div id="single-vendor-page" class="pt-2 pt-md-5">
                <div id="detail-first">
                    <div class="row m-0">
                        <div class="col-md-2 p-0 d-none d-md-block">
                            <img class="vendor-image" src="{{ asset($vendor->image) }}" alt="">
                        </div>
                        <div class="col-12 p-0 d-block d-md-none pb-2">
                            <div class="row m-0">
                                <div class="col-3 p-0">
                                    <img class="vendor-image-md" src="{{ asset($vendor->image) }}" alt="">
                                </div>
                                <div class="col-9 p-0 ps-2">

                                    <div class="name-md text-start">
                                        <span>
                                            {{ $vendor->name }}
                                        </span>
                                        <span class="rate text-success d-inline-flex align-items-center">
                                            <i class="material-icons">grade</i>4.3
                                        </span>
                                    </div>
                                    <div class="text-md">
                                        <a
                                            href="{{ route('vendor', ['username' => $vendor->username]) }}">{{ '@' . $vendor->username }}</a>
                                    </div>
                                </div>
                            </div>
                            {{-- <hr class="my-2"> --}}
                        </div>
                        <div class="col-md-10 p-0 px-md-3">
                            <div class="info">
                                <div class="d-none d-md-block">
                                    <div class="name  align-items-center">
                                        <span>

                                            {{ $vendor->name }}
                                        </span>
                                        <span class="rate text-success d-inline-flex align-items-center ms-3">
                                            <i class="material-icons">grade</i>4.3
                                        </span>
                                    </div>
                                    <div class="text">
                                        <a
                                            href="{{ route('vendor', ['username' => $vendor->username]) }}">{{ '@' . $vendor->username }}</a>
                                    </div>
                                </div>
                                <div class="row m-0">
                                    <div class="col-md-3 p-0 col-6">
                                        <span class="text d-flex align-items-start align-items-md-center me-2">
                                            <i class="material-icons">home_repair_service</i>
                                            <span>{{ $vendor->service }}</span>
                                        </span>
                                        <span class="text d-flex align-items-start align-items-md-center me-2">
                                            <i class="material-icons">room</i>
                                            <span>{{ $vendor->city }}</span>
                                        </span>
                                    </div>
                                    <div class="col-md-9 col-6 p-0">
                                        <span class="text d-flex align-items-start align-items-md-center me-2">
                                            <i class="material-icons">phone</i>
                                            <a href="tel:{{ $vendor->phone }}">{{ $vendor->phone }}</a>
                                        </span>
                                        <span class="text d-flex align-items-start align-items-md-center me-2">
                                            <i class="material-icons">email</i>
                                            <a href="mailto:{{ $vendor->email }}">{{ $vendor->email }}</a>
                                        </span>
                                    </div>
                                    <div class="col-12 p-0">
                                        <div class=" text d-flex align-items-start align-items-md-center">
                                            <i class="material-icons">public</i>
                                            {{ $vendor->address }}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                {{-- <hr> --}}
                <div id="detail-second">
                    <div class="row">
                        <div class="col-md-5 order-2 order-md-1 pt-md-0 pt-3">
                            @if ($otherServices->count() > 0)
                                <div class="box">
                                    <div class="title">
                                        Other Services
                                    </div>
                                    <div class="box-inner">
                                        <div class="row">
                                            @foreach ($otherServices as $otherService)
                                                <div class="shadow">
                                                    <div class="p-4">
                                                        <img src="{{ asset($otherService->image) }}"
                                                            class="w-100 image-rounded" alt="">
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($vendor->opening != null)

                                <div class="box">
                                    <div class="title">
                                        Opening Hours
                                    </div>
                                    <hr class="my-1">
                                    <div class="box-inner">
                                        <table class="w-100">
                                            @foreach (\App\Extra\Opening::options as $code => $name)
                                                @php
                                                    $opening = (object) $vendor->opening[$code];
                                                @endphp
                                                <tr class="{{ $opening->isopen ? 'open' : 'close' }}">
                                                    <td>
                                                        {{ $name }}
                                                    </td>
                                                    <td class="text-end">
                                                        @if ($opening->isopen)
                                                            {{ $opening->start }} - {{ $opening->end }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-7">
                            <div class="box h-100  order-1 order-md-2">
                                <div class="title">
                                    About {{ $vendor->name }}
                                </div>
                                <hr class="my-1">
                                <div class="box-inner description">
                                    {!! $vendor->desc !!}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                @include('front.page.vendor.reviews')
            </div>
        </div>
    </div>
    <div class="sharethis-sticky-share-buttons"></div>
@endsection
@section('js')
    <script type="text/javascript"
        src="https://platform-api.sharethis.com/js/sharethis.js#property=61da3087179d600019788988&product=sticky-share-buttons"
        async="async"></script>
@endsection
