<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function loginGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
}
