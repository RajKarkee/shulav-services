@extends('front.page')
@section('css')
    <link rel="stylesheet" href="{{ asset('front/auth.css') }}">
    <style>
        label{
           margin: 10px 0px 10px 5px;
        }
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
                    <div class="control mb-3">
                        <span class="icon">
                            <i class="fas fa-phone"></i>
                        </span>
                        <input type="phone" name="phone" id="phone" placeholder="Enter Phone No" aria-label="Phone"
                            aria-describedby="Email">
                    </div>
                    <div class="control mb-3" id="otp-holder">
                        <span class="icon">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="number" name="otp" placeholder="Enter Otp" aria-label="Otp" aria-describedby="otp"
                            id="otp">

                    </div>
                    <div class="text-end" id="request_otp">
                        <button class="btn btn-red" onclick="requestOTP()">
                            Request OTP
                        </button>
                    </div>
                    <div class="text-end" id="login_opt">
                        <button class="btn btn-red" id="finish" onclick="login()">
                            Login
                        </button>
                    </div>
                    <div  id="OTPForm">
                        <div class="control mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" aria-label="Name"
                                aria-describedby="Name">
                        </div>
                        <div class="control mb-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" aria-label="Email"
                                aria-describedby="Email">
                        </div>
                        <div class="control mb-3">
                            <label for="address">Address</label>
                            <input type="text" name="address" id="address" aria-label="Address"
                                aria-describedby="Address">
                        </div>
                        <div class="control mb-3">
                            <label for="city_id">City</label>
                            <select name="city_id" id="city_id" aria-label="City"
                                aria-describedby="City">
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <button class="btn btn-primary" onclick="login()">
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('js')

    <script>
        $(document).ready(function() {
            $('#OTPForm').hide();
            $('#login_opt').hide();
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

        function requestOTP() {
            const phone = $('#phone').val();
            axios.post("{{ route('loginPhone') }}", {
                    phone: phone
                })
                .then((res) => {
                    if (res.data.status == true && res.data.user == false) {
                        $('#OTPForm').show();
                        $('#request_otp').hide();
                    } else if (res.data.status == true && res.data.user == true) {
                        $('#login_opt').show();
                        $('#request_otp').hide();
                    }
                })
                .catch((err) => {
                    console.log(err.response);
                    if (err.response) {
                        alert(err.response.data.message);
                    } else {
                        alert('Some error occured please try again');
                    }
                    $('#request_otp button').show();
                })

        }

        function login() {
            const otp = $('#otp').val();
            const name = $('#name').val();
            const email = $('#email').val();
            const address = $('#address').val();
            const city_id = $('#city_id').val();

            axios.post('{{ route('loginOTP') }}', {
                    otp: otp,
                    name: name,
                    email: email,
                    address: address,
                    city_id: city_id
                })
                .then((res) => {
                    const user - res.data;
                    if(user.role == 2){
                        window.location.href = "{{ route('vendor.dashboard') }}";
                    }else{
                        alert('You do not have access to this page');
                    }

                })
                .catch((err) => {
                    console.log(err.response);
                    if (err.response) {
                        alert(err.response.data.message);
                    } else {
                        alert('Some error occured please try again');
                    }
                    $('#login_opt button').show();

                });
        }
    </script>
@endsection
