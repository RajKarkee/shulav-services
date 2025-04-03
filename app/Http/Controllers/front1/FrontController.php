<?php

namespace App\Http\Controllers\front1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FrontPageSection;
use CreateProductsTable;

class FrontController extends Controller
{
    public function index(){
        $sliders = DB::table('sliders')->get(['id', 'image', 'link']);
        $serviceCategories = DB::table('categories')->whereNull('parent_id')->get(['id', 'name', 'image']);
        $sections = FrontPageSection::with(['products.productType'])
        ->orderBy('position','asc')
        ->get();
        return view('front1.index',compact('sliders','serviceCategories','sections'));

    }
    
    public function categoryIndex(){
        return view('front1.aaa');
    }
    public function categorySingle($name , $id){
      $product = DB::table('products')
      ->leftjoin('cities','products.city_id','=','cities.id')
      ->select('products.*','cities.name as city_name')
  
      ->where('products.id',$id)
      ->where('products.active',1)
      ->first();

      if(!$product){
          abort(404);
      }
      return view('front1.view',compact('product'));

       
    }
}
