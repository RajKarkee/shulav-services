<div class="logo">
    <a href="{{ route('index') }}">
        <picture>
            <source media="(min-width: 768px)" srcset="{{ $logo }}">
            <source media="(max-width: 767px)" srcset="{{ $footer_logo }}">
            <img class="logo" src="{{ $logo }}" alt="logo">
        </picture>
    </a>
</div>
