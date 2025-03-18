<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        if($request->getMethod()=="POST"){
            // dd($request->all());
            $data=$request->validate([
                'email'=>'email|required',
                'password'=>'required'
            ]);
            if(Auth::attempt(['email'=>$request->email,'password'=>$request->password,'role'=>1],$request->filled(('me')))){
                return redirect()->route('admin.dashboard')->with('message',"Login Sucessfull");
            }else{
                return redirect()->back()
                ->with('error','Email and password Combination Wrong.')
                ->withInput(['email']);
            }
        }else{
            return view('admin.auth.login');
        }
    }
    public function logout(Request $request){
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
