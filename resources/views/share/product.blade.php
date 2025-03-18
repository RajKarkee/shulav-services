<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{env('APP_NAME')}} - {{$product->name}}</title>
    <meta name="description" content="{{ strip_tags($product->desc) }}" />
    <meta property="og:url" content="{{ route('pshare', ['product' => $product->id]) }}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $product->name }}" />
    <meta property="og:description" content="{{ strip_tags($product->desc) }}" />
    <meta property="og:image" content="{{ asset($product->image) }}" />
</head>
<body>
    Redirecting.....


    <script>
    
        var fallbackToStore = function() {
            window.location.replace("{{route('product',['product'=>$product->id])}}");
        };
        var openApp = function() {
        window.location.replace('khazom://');
        };
        var triggerAppOpen = function() {
            openApp();
            // setTimeout(fallbackToStore, 2000);
        };
        window.onload=()=>{
            triggerAppOpen();
        };
    </script>
</body>
</html>
