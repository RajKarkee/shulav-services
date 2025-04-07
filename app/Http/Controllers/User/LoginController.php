<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request)
    {
     
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

       
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $request->email)->first();

        if ($user && Auth::attempt($credentials) && $user->role == 3) {
            Auth::login($user);
            return redirect()->back()->with('message', 'Login Successful');
        }

        return redirect()->back()->with('error', 'Invalid Credentials or Unauthorized Role');
    }
}
    