@extends('front.page')
@section('css')
    <link rel="stylesheet" href="{{ asset('front/auth.css') }}">
    <style>
        .type-selector{
            padding:30px 10px;
            border:1px solid #b6b6b6;
            text-align:center;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 700;
        }

        .type-selector.selected{
            border:1px solid rgb(175, 0, 0);
            color:white;
            background: rgb(175, 0, 0);
            border-radius: 10px;
            cursor: pointer;
            font-weight: 700;

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
                    <form action="{{route('setupUser')}}" method="post">
                        @csrf
                        <div class="row mb-3">
                            <input type="hidden" name="type" value="2" id="type">
                            <div class="col-6  type-selector selected type-selector-2 " onclick="sel(2)">
                                Sell <br> Service
                            </div>
                            <div class="col-6 type-selector  type-selector-3"  onclick="sel(3)">
                                Buy <br> Service
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="control join mb-3">
                                    <label for="name" class="required">Name </label>
                                    <input type="text" id="name" name="name"
                                        placeholder="Enter Your Name " aria-label="Name" aria-describedby="Email"
                                        autocomplete="off" required value="{{$localUser->name}}">
                                </div>
                            </div>
                           @if ($setup==2)
                           <div class="col-md-12">
                            <div class="control join mb-3">
                                <label for="phone" class="required">
                                    Email
                                    <span class="text-danger" id="phone-error"></span>
                                </label>
                                <br>
                                <span >{{ $email }}</span>
                            </div>
                        </div>
                            @else
                            <div class="col-md-6">
                                <div class="control join mb-3">
                                    <label for="phone" class="required">
                                        Phone
                                        <span class="text-danger" id="phone-error"></span>
                                    </label>
                                    <br>
                                    <span >{{ $phone }}</span>
                                </div>
                            </div>
                           @endif
                            <div class="col-md-{{$setup==2?12:6}}">
                                <div class="control join mb-3">
                                    <label for="city" class="required">city </label>
                                    <select min="10" max="10" id="city" name="city_id" aria-label="city"
                                        aria-describedby="city" autocomplete="off">
                                        {{-- <option>Please Select A City</option> --}}
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="control join mb-3">
                                    <label for="location" class="required">Location </label>
                                    <select min="10" max="10" id="location" name="location_id" aria-label="location"
                                        aria-describedby="location" autocomplete="off">

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="control join mb-3">
                                    <label for="address" >Street Address </label>
                                    <input type="text" name="address" id="address" value="{{ old('address') }}"
                                        placeholder="Enter Street Address" aria-label="Address" aria-describedby="Address"
                                        autocomplete="off" >
                                </div>
                            </div>
                            <div class="col-md-12 options option-2">
                                <div class="control join mb-3">
                                    <label for="city" class="required">Service Type </label>
                                    <select min="10" max="10" id="cat" name="category_id" aria-label="city"
                                        aria-describedby="Category" autocomplete="off">
                                        <option>Please Select A service Category</option>
                                        @foreach ($cats as $cat)
                                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 options option-2">
                                <div class="control join mb-3">
                                    <label for="service" class="required">Service </label>
                                    <select min="10" max="10" id="service" name="service_id" aria-label="service"
                                        aria-describedby="service" autocomplete="off">

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-red w-100">
                                    @if ($redirect==null)
                                        Complete Setup
                                    @else
                                        Continue
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('js')

    <script>
        const services={!! json_encode($services) !!};
        const locations={!! json_encode($locations) !!};

        $(document).ready(function() {
            if(x_city!=null){
                $('#city').val(x_city.id).change();
            }

            $('#cat').change(function(){
                $('#service').html(
                    services.filter(o=>o.category_id==$('#cat').val()).map(o=>`<option value="${o.id}">${o.name}</option>`)
                );
            });

            $('#city').change(function(){
                $('#location').html(
                locations.filter(o=>o.city_id==$('#city').val()).map(o=>`<option value="${o.id}">${o.name}</option`)
                );
            });
        });

        function sel(type){
            $('.type-selector').removeClass('selected');
            $('.type-selector-'+type).addClass('selected');

            $('.options').addClass('d-none');
            $('.option-'+type).removeClass('d-none');
            $('#type').val(type);

        }
    </script>
@endsection
