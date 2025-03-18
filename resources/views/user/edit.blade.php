@extends('front.page')
@section('css')
    <link rel="stylesheet" href="{{ asset('front/vendor/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('front/rcrop.min.css') }}">
    <style>
        .control input,
        .control textarea,
        .control select{
            width:100%;
            border-radius: 5px;
            border: 1px solid #b0b0b0;
            pointer-events: all;
            background-color: #f1f1f1;
            padding: 5px;
        }
        .control input:focus,
        .control textarea:focus,
        .control select:focus{
            background: white;
        }
    </style>
@endsection
@section('title', 'User Edit ')

@section('content')

    <div id="vendor-dashboard-page">

        <div class="row">
            @include('user.dashboard.sidebar')
            <div class="col-md-8   ">
                <div class="bg-white shadow mb-3">
                    <div class="card-body " id="jumbotron">
                        <a href="{{ route('user.dashboard') }}">Dashboard</a>
                        <span> Edit Profile</span>

                    </div>
                </div>
                <div class="bg-white shadow mb-3">
                    <div class="card-body ">
                        <form id="update-password" action="{{ route('user.update-pass') }}" method="POST">
                            @csrf
                            <div class="row control">

                                <div class="col-md-3">
                                    <label for="oldpass">Old Password</label>
                                    <input type="password" name="oldpass" id="oldpass" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="pass">New Password</label>
                                    <input type="password" name="pass" id="pass" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="repass">Retype Password</label>
                                    <input type="password" name="repass" id="repass" class="form-control" required>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button class="w-100 btn btn-red">Update Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="bg-white shadow">
                    <div class="card-body">
                        <form action="{{route('user.edit-info')}}" id="update-profile" method="POST">
                        @csrf
                        <div class="controls ">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="control join mb-3">
                                        <label for="name" class="required">Name </label>
                                        <input type="text" id="name" name="name" value="{{ $user->name }}"
                                            placeholder="Enter Your Name " aria-label="Name" aria-describedby="Email"
                                            autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="control join mb-3">
                                        <label for="phone" class="required">
                                            Phone Number
                                            <span class="text-danger" id="phone-error"></span>
                                        </label>
                                        <input type="phone" id="phone" name="phone" value="{{ $user->vendor->phone }}"
                                            placeholder="Enter phone Number" aria-label="phone" aria-describedby="phone"
                                            autocomplete="off" required >
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="control join mb-3">
                                        <label for="city" class="required">city </label>
                                        <select min="10" max="10" id="city" name="city_id" aria-label="city"
                                            aria-describedby="city" autocomplete="off">
                                            @foreach (\App\Models\City::all(['id', 'name']) as $city)
                                                <option value="{{ $city->id }}"
                                                    {{ $user->vendor->city_id == $city->id ? 'selected' : '' }}>{{ $city->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="control join mb-3">
                                        <label for="address" class="required">Street Address </label>
                                        <input type="text" name="address" id="address" value="{{ $user->vendor->address }}"
                                            placeholder="Enter Street Address" aria-label="Address"
                                            aria-describedby="Address" autocomplete="off" required>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="control join mb-3">
                                        <label for="dob">Date Of Birth </label>
                                        <input type="date" name="dob" id="dob"
                                            placeholder="Date of Birth" aria-label="Date of Birth"
                                            aria-describedby="Date of Birth" autocomplete="off" value="{{$user->vendor->dob}}">
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="control join mb-3">
                                        <label for="gender" {{-- class="required" --}}>Gender </label>
                                        <select min="10" max="10" id="gender" name="gender_id" aria-label="gender"
                                            aria-describedby="gender" autocomplete="off">
                                            <option value="1" {{ $user->vendor->gender == 1 ? 'selected' : '' }}>Male</option>
                                            <option value="2" {{ $user->vendor->gender == 2 ? 'selected' : '' }}>Female</option>
                                            <option value="3" {{ $user->vendor->gender == 3 ? 'selected' : '' }}>Others</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 ">
                                    <div class="control join mb-3">
                                        <label for="desc" {{-- class="required" --}}>Description </label>
                                        <textarea min="10" max="10" id="desc" name="desc" aria-label="desc"
                                            aria-describedby="desc" autocomplete="off">{{$user->vendor->desc}}</textarea>
                                    </div>
                                </div>
                                <div class="div py-2 text-end">
                                    <button class="btn btn-red">Update Profile</button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    @include('user.dashboard.imagejs')
    @include('user.dashboard.namejs')
    @include('user.dashboard.descjs')
    <script>
        $('#update-password').submit(function (e) {
            e.preventDefault();
            if($('#repass').val()!=$('#pass').val()){
                alert("Please confirm new Password");

            }else{
                if(confirm('Do you want to update password?')){
                    axios.post(this.action,new FormData(this))
                    .then((res)=>{
                        alert('Password Updated Sucessfully');
                        this.reset();
                    })
                    .catch((err)=>{
                        alert('Cannot Update Password,Please Try Again');
                    });
                }
            }

        });
        $('#update-profile').submit(function (e) {
            e.preventDefault();

                if(confirm('Do you want to update Profile?')){
                    axios.post(this.action,new FormData(this))
                    .then((res)=>{
                        alert('Profile Updated Sucessfully');
                            $('#desc-input').val($('#desc').val());
                            $('#name-input').val($('#name').val());
                            $('#from-input').html($( "#city_id option:selected" ).text());
                    })
                    .catch((err)=>{
                        try {
                            alert(err.response.data.message);

                        } catch (error) {

                            alert('Cannot Update Profile,Please Try Again');
                        }
                    });
                }


        });
    </script>
@endsection
