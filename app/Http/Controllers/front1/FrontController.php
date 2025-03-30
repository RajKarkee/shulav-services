<?php

namespace App\Http\Controllers\front1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function index(){
        $sliders = DB::table('sliders')->get(['id', 'image', 'link']);
        return view('front1.index',compact('sliders'));
    }
    public function menu(){
        return view('front1.aaa');
    }
    public function view(){
        return view('front1.view');
    }
}
