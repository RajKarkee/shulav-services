@extends('front.page')
@section('css')
<link rel="stylesheet" href="{{asset('front/auth.css')}}">
<style>

</style>
@endsection
@section('title',"Login")
@section('jumbotron')
    <li>Login</li>
@endsection
@section('content')
    <div id="page-login">
        <div class="holder">
            <div class="image">

            </div>
            <div class="login-form ">

                <div class="heading-logo mb-3">
                    <img src="{{asset('front/khazom.png')}}" alt="" srcset="">
                </div>
                {{--
                <div class="header">
                    <span class="active">
                        Login
                    </span>

                </div> --}}
                <form action="{{route('login')}}" method="post">
                    @csrf
                    <input type="hidden" name="hooked" class="hooked" value="">
                    @if (request()->has('q'))
                        <input type="hidden" name="redirect" value="{{request()->get('q')}}">
                    @endif
                    @if (session('err'))
                        <div class="alert alert-danger">
                            {{ session('err') }}
                        </div>
                    @endif
                    <div class="controls px-3" >
                        <div class="control mb-3">

                                <span class="icon" >
                                    <i class="far fa-envelope"></i>
                                </span>
                                <input type="email" name="email" value="{{old('email')}}" placeholder="Enter Email Address" aria-label="Email" aria-describedby="Email">

                        </div>
                        <div class="control mb-3">
                            <span class="icon" >
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" name="password"  placeholder="Enter Password" aria-label="Password" aria-describedby="Password">

                        </div>
                        <div class="d-flex justify-content-between">
                            <div >
                                <a href="{{route('forgot')}}" class="btn btn-link link">Forgot Password</a>
                            </div>
                            <div>
                                <button class="btn btn-red">Login</button>
                            </div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <a href="{{route('join')}}" class="link btn btn-link">
                                Don't have A Account? <strong class="text-red">join Us</strong>
                            </a>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>
@endsection
@section('js')

@endsection
