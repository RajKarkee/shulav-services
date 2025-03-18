@foreach ($data->social_links as $key=>$item)
    @if ($item!="#")
        <a href="{{$item}}" class="social-link">
            <i class="fab {{\App\Helper::iconmap[$key]}}"></i>
        </a>
    @endif
@endforeach
