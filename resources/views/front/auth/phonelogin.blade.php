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
                        <input type="number" name="otp" placeholder="Enter Otp" aria-label="Otp" aria-describedby="otp"
                            id="otp">

                    </div>
                    <div class="text-end">
                        <button id="finish" class="btn btn-red" data-step="{{ $phone == null ? 1 : 2 }}"
                            onclick="{{ $phone == null ? 'javascript:requestOTP($(\'#phone\').val(), this)' : '' }}">
                            {{ $phone == null ? 'Next' : 'Login' }}
                        </button>
                    </div>

                </div>
                <form action="{{ route('loginOTP') }}" method="POST" id="OTPForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" aria-label="Name"
                                aria-describedby="Name">
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" aria-label="Email"
                                aria-describedby="Email">
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="address">Address</label>
                            <input type="text" name="address" id="address" class="form-control" aria-label="Address"
                                aria-describedby="Address">
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="city_id">City</label>
                            <select name="city_id" id="city_id" class="form-control" aria-label="City"
                                aria-describedby="City">
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <button class="btn-prrimary"> Save </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
@section('js')

    <script>
        $(document).ready(function() {
            $('#OTPForm').hide();

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
                    if (res.data.status == true) {
                        $(ele).show();
                        valid = Date(res.data.validtill);
                        $('#otp-holder').css('display', 'flex');
                        $(ele).text("Login");
                        ele.dataset.step = 2;
                    }
                })
                .catch((err) => {
                    console.log(err.response);
                    if (err.response) {
                        alert(err.response.data.message);
                    } else {
                        alert('Some error occured please try again');
                    }
                    $(ele).show();
                })

        }

        function login(ele) {
            const opt = parseInt($('#otp').val());
            axios.post('{{ route('loginOTP') }}', {
                    otp: opt
                })
                .then((res) => {

                })
                .catch((err) => {
                    console.log(err.response);
                    if (err.response) {
                        alert(err.response.data.message);
                    } else {
                        alert('Some error occured please try again');
                    }
                    $(ele).show();

                });
        }
    </script>
@endsection
