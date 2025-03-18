<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RoleManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {

        if (!Auth::check()) {
            if($request->expectsJson()){
                return response()->json([
                    'msg'=>['Url Not Found']
                ],400);
            }else{
                Session::put('redirect',$request->fullUrl());
                Session::save();
                if($role=='admin'){
                   return redirect()->route('admin.login');
                }else{
                    return redirect()->route('loginFirst');
                }
            }
        }
        $user=Auth::user();

        if($user->getRole()==$role){
            Config::set('per.per',$user->permissions);
            return $next($request);
        }else{
            if($request->expectsJson()){
                return response()->json([
                    'msg'=>['Url Not Found']
                ],400);
            }else{
                return redirect()->route($user->getRole().".dashboard");
            }
        }
    }
}
