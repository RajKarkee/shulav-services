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
            <div class="login-form">
                <h5>
                    @if ($redirect!=null)
                        Please Login To Continue,
                    @else
                        Welcome Back,
                    @endif
                </h5>
                <br>

                <a href="{{route('loginPhone')}}" class="where">Login with Phone</a>
                <a href="{{route('loginGoogle')}}" class="where">Login with Gmail</a>
                <div class="text-center py-2 fw-bold">
                    OR
                </div>
                <a href="{{route('login')}}" class="where">Login with Email</a>
            </div>
        </div>

    </div>
@endsection
@section('js')

@endsection
