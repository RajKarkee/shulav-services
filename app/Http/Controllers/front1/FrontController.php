<?php

namespace App\Http\Controllers\front1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function index(){
        $sliders = DB::table('sliders')->get(['id', 'image', 'link']);
        $serviceCategories = DB::table('categories')->where('type',2)->whereNull('parent_id')->get(['id', 'name', 'image']);
        return view('front1.index',compact('sliders','serviceCategories'));
    }
    
    public function categoryIndex(){
        return view('front1.aaa');
    }
    public function categorySingle($categoryId){
        return view('front1.view');
    }
}
