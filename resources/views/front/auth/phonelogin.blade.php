@extends('front.page')
@section('css')
    <link rel="stylesheet" href="{{ asset('front/auth.css') }}">
    <style>

    </style>
@endsection
@section('title', 'Login')
@section('jumbotron')
    <li>Login</li>
@endsection
@section('content')
    <div id="page-login">
        <div class="holder">
            <div class="image">

            </div>
            <div class="login-form">

                <div class="controls px-3">
                    @if ($phone != null)
                        <div class="control mb-3">

                            <span class="icon">
                                <i class="fas fa-phone"></i>
                            </span>
                            <span id="phone" style="display: flex;align-items: center;">{{ $phone }}</span>
                        </div>
                    @else
                        <div class="control mb-3">

                            <span class="icon">
                                <i class="fas fa-phone"></i>
                            </span>
                            <input type="phone" name="phone" id="phone" placeholder="Enter Phone No"
                                aria-label="Phone" aria-describedby="Email">
                        </div>
                    @endif
                    <div class="control mb-3" id="otp-holder" style="display: {{ $phone == null ? 'none' : 'flex' }}">
                        <span class="icon">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="number" name="otp" placeholder="Enter Otp" aria-label="Otp"
                            aria-describedby="otp" id="otp">

                    </div>
                    <div class="text-end">
                        <button id="finish" class="btn btn-red" data-step="{{ $phone == null ? 1 : 2 }}">
                            {{ $phone == null ? 'Next' : 'Login' }}
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
@section('js')

    <script>
        $(document).ready(function() {

            $('#finish').click(function(e) {
                e.preventDefault();
                if (this.dataset.step == 1) {
                    const phone = $('#phone').val();
                    const pattern = /9[7-8][0-6][0-9]{7}/;
                    if (phone.length != 10 || !(pattern.test(phone))) {
                        alert('Please Enter Valid Phone No');
                    }
                    $(this).hide();
                    requestOTP(phone, this);
                } else {
                    $(this).hide();
                    login(this);
                }
            });

        });

        var valid = '';

        function requestOTP(no, ele) {
            axios.post("{{ route('loginPhone') }}", {
                    phone: no
                })
                .then((res) => {
                    console.log(res);
                    $(ele).show();
                    valid = Date(res.data.validtill);
                    $('#otp-holder').css('display', 'flex');
                    $(ele).text("Login");
                    ele.dataset.step= 2;
                    window.requestOTP = () => {
                        alert('Otp Already Sent');
                    }
                })
                .catch((err) => {
                    $(ele).show();
                })

        }

        function login(ele) {
            const opt=parseInt($('#otp').val());
            axios.post('{{route('loginOTP')}}',{otp:opt})
            .then((res)=>{
                $(ele).show();
                localStorage.setItem('myCat', res.data.redirect);

                window.location.href = res.data.redirect;

            })
            .catch((err)=>{
                console.log(err.response);
                if(err.response){
                    alert(err.response.data.message);
                }else{
                    alert('Some error occured please try again');
                }
                $(ele).show();

            });
        }
    </script>
@endsection
