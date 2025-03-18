@extends('front.page')
@section('css')
    <link rel="stylesheet" href="{{ asset('front/auth.css') }}">
@endsection
@section('title', 'Setup')
@section('jumbotron')
    <li>Setup</li>
@endsection
@section('content')
    <div id="page-login">
        <div class="holder join">

            <div class="login-form step">
                <form id="week-holder">
                    <h4 class="text-center text-black mt-3">
                        We Are nearly finished. <br>
                        just Enter Your Work Schedule
                    </h4>
                    <hr>
                    <strong>

                        <div class="row">
                            <div class="col-4">
                                Day
                            </div>
                            <div class="col-4">Opening Time</div>
                            <div class="col-4">Closing Time</div>
                        </div>
                    </strong>
                    @foreach (\App\Extra\Opening::options as $key => $option)
                        <hr class="my-1">
                        <div class="row">
                            <div class="col-4 pe-0 d-flex align-items-center">
                                <input type="checkbox" name="open_{{ $key }}" id="open_{{ $key }}"
                                    class="me-1" {{ $key != 'sat' ? 'checked' : '' }}>
                                <label for="open_{{ $key }}">
                                    <strong>
                                        {{ $option }}
                                    </strong>
                                </label>
                            </div>
                            <div class="col-4 pe-0">
                                <input type="text" name="start_{{ $key }}" id="start_{{ $key }}"
                                    class="form-control" value="10:00 AM">
                            </div>
                            <div class="col-4 ps-1">
                                <input type="text" name="end_{{ $key }}" id="end_{{ $key }}"
                                    class="form-control" value="05:00 PM">
                            </div>
                        </div>
                    @endforeach
                    <div class="d-flex justify-content-end mt-2">
                        <span class="btn btn-red" id="next">
                            Next
                        </span>
                    </div>
                </form>
            </div>
            <div class="overlay">
                <img src="{{ asset('front/loading.svg') }}" alt="">
            </div>
        </div>

    </div>

@endsection
@section('js')

    <script>
        $('#next').click(function(e) {
            $('.overlay').addClass('active');
            var fd = new FormData(document.getElementById('week-holder'));
            axios.post("{{ route('vendor.step') }}", fd)
                .then((res) => {
                    if (res.data.status) {
                        window.location.reload();
                    }
                    $('.overlay').removeClass('active');

                })
                .catch((err) => {
                    $('.overlay').removeClass('active');

                });
        });
    </script>
@endsection
