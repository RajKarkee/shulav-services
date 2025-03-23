@foreach ($sliders as $slider)
    <div class="banner">
        <img src="{{ asset($slider->image) }}" alt="Color Your Way to Epic Rewards" class="full-width-banner">
    </div>
@endforeach
