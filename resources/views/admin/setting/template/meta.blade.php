@php
    $data=getSetting('website');
@endphp
<meta name="description" content="{{ $data->meta_description }}" />
<meta property="og:url" content="{{ route('index')}}" />
<meta property="og:type" content="article" />
<meta property="og:title" content="{{ env('APP_NAME','')}}" />
<meta property="og:description" content="{{ $data->meta_description }}" />
<meta property="og:image" content="{{ asset($data->meta_banner) }}" />
