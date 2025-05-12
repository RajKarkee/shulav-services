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
        if ($user) {
            if ($user && Auth::attempt($credentials) && $user->role == 2) {
                Auth::login($user);
                return redirect()->route('vendor.dashboard')->with('success', 'Login Successful');
            }
        } else {
            $user = new User();
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->role = 2;
            $user->save();

            if ($user && Auth::attempt($credentials) && $user->role == 2) {
                Auth::login($user);
                return redirect()->route('vendor.dashboard')->with('success', 'Login Successful');
            }
        }
        return redirect()->back()->with('error', 'Invalid Credentials or Unauthorized Role');
    }
}
