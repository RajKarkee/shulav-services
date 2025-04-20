<?php

namespace App\Http\Controllers\front1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PhoneLoginController extends Controller
{
  public function index(){
    return view('front.auth.phonelogin');
  }
}
