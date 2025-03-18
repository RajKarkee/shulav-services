<?php

namespace App\Http\Controllers\front1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(){
        return view('front1.index');
    }
    public function menu(){
        return view('front1.aaa');
    }
    public function view(){
        return view('front1.view');
    }
}
