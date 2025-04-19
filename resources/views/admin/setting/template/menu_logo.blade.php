<div class="logo">
    <a href="{{ route('index') }}">
        <picture>
            <source media="(min-width: 768px)" srcset="{{ asset($logo) }}">
            <source media="(max-width: 767px)" srcset="{{ asset($footer_logo) }}">
            <img class="logo" src="{{ asset($logo) }}" alt="Slider Image">
        </picture>
    </a>
</div>
