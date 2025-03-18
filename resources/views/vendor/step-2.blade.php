@extends('front.page')
@section('css')
    <link rel="stylesheet" href="{{ asset('front/auth.css') }}">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/pell/dist/pell.min.css">

@endsection
@section('title', 'Setup')
@section('jumbotron')
    <li>Setup</li>
@endsection
@section('content')
    <div id="page-login">
        <div class="holder join">
            <div class="login-form step">
                <h4 class="text-center text-black mt-3">
                    A Few thing and we are done. <br>
                    Write Something About Your Self
                </h4>
                <hr>
                <textarea name="pell" id="pell-input" class="form-control"  cols="30"
                    rows="5" placeholder="Write Something About Your Self"></textarea>
                {{-- <div id="pell" style="box-shadow:var(--shadow);padding-top:10px;"></div> --}}
                <div class="d-flex justify-content-end mt-2">
                    <span class="btn btn-red" id="next">
                        Next
                    </span>
                </div>
            </div>
            <div class="overlay">
                <img src="{{ asset('front/loading.svg') }}" alt="">
            </div>
        </div>

    </div>

@endsection
@section('js')

    <script src="https://unpkg.com/pell"></script>
    <script>
        var data;
        $(document).ready(function() {
            // if ($(window).innerWidth() > 426) {

            //     pell.init({
            //         actions: [
            //             "bold",
            //             "italic",
            //             "underline",
            //             "strikethrough",
            //             "heading1",
            //             "heading2",
            //             "paragraph",
            //             "quote",
            //             "olist",
            //             "ulist",
            //             "code",
            //             "line",
            //             "link"
            //         ],
            //         classes: {
            //             actionbar: 'pell-actionbar',
            //             button: 'pell-button',
            //             editor: 'pell-editor'
            //         },
            //         onChange: html => {
            //             data = html;
            //         },
            //         element: document.getElementById('pell'),

            //     });
            // } else {
            //     $('#pell').hide();
            //     $('#pell-input').show();
            // }

            $('#next').click(function(e) {
                $('.overlay').addClass('active');

                let desc = '';
                // if ($(window).innerWidth() > 426) {
                //     desc = data;
                // } else {
                // }
                    desc = $('#pell-input').val();
                axios.post("{{ route('vendor.step') }}", {'desc':desc})
                    .then((res) => {
                        if (res.data.status) {
                            window.location.reload();
                        }
                    })
                    .catch((err) => {
                        $('.overlay').removeClass('active');

                    });
            });

        });
    </script>
@endsection
