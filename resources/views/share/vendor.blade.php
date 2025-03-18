<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{env('APP_NAME')}} - {{$vendor->name}}</title>
    <meta name="description" content="{{ $vendor->desc }}" />
    <meta property="og:url" content="{{ route('vendor', ['username' => $username]) }}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $vendor->name }}" />
    <meta property="og:description" content="{{ $vendor->desc }}" />
    <meta property="og:image" content="{{ asset($vendor->image) }}" />
</head>
<body>
    Redirecting.....

    <script>
        window.onload=()=>{
            window.location.replace("{{route('vendor',['username'=>$username])}}");
        };
    </script>
</body>
</html>
