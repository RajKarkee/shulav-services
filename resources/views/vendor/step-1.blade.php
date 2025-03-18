@extends('front.page')
@section('css')
    <link rel="stylesheet" href="{{ asset('front/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('front/rcrop.min.css') }}">
    <style>

    </style>
@endsection
@section('title', 'Setup ')
@section('jumbotron')
    <li>Setup</li>
@endsection
@section('content')
    <div id="page-login">
        <div class="holder join">
            <div class="login-form step">

                {{-- <div class="heading-logo mb-3">
                    <img src="{{asset('front/khazom.png')}}" alt="" srcset="">
                </div> --}}

                {{-- <div class="header">
                    <span class="active join-type"  data-id="normal">
                        Register As Normal User
                        <div class="normal">
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aut obcaecati esse itaque iste necessitatibus nisi dignissimos animi ea placeat provident voluptates labore rerum possimus excepturi laborum similique, harum asperiores amet.
                        </div>
                    </span>

                    <span class="join-type" data-id="professional">
                        Register As  Professional
                        <div class="normal">
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aut obcaecati esse itaque iste necessitatibus nisi dignissimos animi ea placeat provident voluptates labore rerum possimus excepturi laborum similique, harum asperiores amet.
                        </div>
                    </span>
                </div> --}}
                <h4 class="text-center text-black mt-3">
                    A Few thing and we are done. <br>
                    let's setup your image
                </h4>
                <hr>
                <form action="{{ route('join') }}" autocomplete="off" method="post" style="position: relative;">
                    @csrf
                    <input type="hidden" name="type" id="type" value="normal">

                    <div id="first-selector">
                        <span style="" onclick="$('#image-input')[0].click()">
                            <h6>
                                Click here to select a Image
                                <br>
                                <img src="/front/camera.svg" alt="" id="image-display">

                            </h6>
                        </span>
                        <div class="text-center py-2">
                            <a href="" class="btn btn-link link">Skip for now</a>
                        </div>
                    </div>
                    <div id="second-selector" style="display: none">
                        <div id="image-holder" >
                            <img src="" id="image-resize" alt="" style="width: 766px">
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="" class="btn btn-link link">
                                    Skip for now
                                </a>
                            </div>
                            <div>
                                <div class="img-loader ">
                                    <label for="image-input">
                                        <img src="/front/camera.svg" alt="" id="image-display">
                                        <input type="file" class="d-none" id="image-input" name="image"
                                            accept="image/*">
                                    </label>
                                </div>
                            </div>
                            <div>
                                <span class="btn btn-red" id="next">
                                    Next
                                </span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="overlay">
                <img src="{{asset('front/loading.svg')}}" alt="">
            </div>
        </div>

    </div>
    {{-- <div class="modal fade" id="image-resize-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="image-resize-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body" id="modal-body">
                    <img src="" id="image-resize" alt="" style="width: 766px">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
@section('js')

    <script src="{{ asset('front/js/rcrop.min.js') }}"></script>
    <script>
        var result, data;

        function loadChange(yes) {
            if (yes) {

            } else {

            }
        }

        function initEdit() {
            $('#second-selector').show();
            $('#first-selector').hide();

            $('#image-resize').width($('#image-holder').width());
            $('#image-resize').attr('src', result);
            // $('#image-display').attr('src', e.target.result);
            // $('#image-display').parent().addClass('loaded');

            $('#image-resize').on('rcrop-changed', function() {
                data = $(this).rcrop('getDataURL');
            });
            $('#image-resize').rcrop({
                minSize: [200, 200],
                preserveAspectRatio: true,
                // preview: {
                //     display: true,
                //     size: [100, 100],
                // }
            });
            $('#image-input').val('');
        }


        function readURL(input) {
            $('#image-holder').html('<img src="" id="image-resize" alt="" >');
            if (input.files && input.files[0]) {
                let reader = new FileReader();

                reader.onload = function(e) {
                    result = e.target.result;
                    initEdit();
                };
                reader.readAsDataURL(input.files[0]);
            } else {

            }
        }

        $("#image-input").change(function() {
            readURL(this);
        });

        $('#next').click(function(e) {
            e.preventDefault();
            $('.overlay').addClass('active');
            data = $('#image-resize').rcrop('getDataURL');
            fetch(data)
                .then(res => res.blob())
                .then((_data) => {
                    console.log(_data, 'blob');
                    var fd = new FormData();
                    fd.append('image', _data);
                    axios.post("{{ route('vendor.step', ['step' => 1]) }}", fd)
                        .then((res) => {
                            if(res.data.status){
                                window.location.reload();
                            }
                        })
                        .catch((err) => {
                            $('.overlay').removeClass('active');

                        });
                })


        });
    </script>
@endsection
