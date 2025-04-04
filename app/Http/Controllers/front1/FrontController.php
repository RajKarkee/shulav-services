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
    
    public function categoryIndex($id){
        // $products = DB::table('categories')
        // ->leftjoin('products','categories.id','=','products.category_id')
        
        // ->leftjoin('cities','products.city_id','=','cities.id')
        // ->select('categories.*','products.*','cities.name as city_name')
        // ->where('categories.id','=',$id)
        // ->where('categories.active',1)
        // ->where('products.active',1)
        // ->orderBy('products.created_at','desc')
        // ->paginate(12);
        $category = DB::table('categories')->where('id',$id)->first();
        if(!$category){
            abort(404);
        }
        $products = DB::table('products')
    ->join('categories', 'products.category_id', '=', 'categories.id')
    ->select('products.*', 'categories.name as category_name')
    ->where('products.category_id', $id)
    ->where('products.active', 1)
    ->orderBy('products.created_at', 'desc')
    ->paginate(12);
        $allcategories = DB::table('categories')->whereNull('parent_id')->get(['id', 'name']);
        // $subcategories = DB::table('categories')->where('parent_id',$id)->get(['id', 'name']);
        $subcategories = DB::table('categories')
    ->whereNotNull('parent_id') 
    ->get();
        // ->where('id',$id)->first();
        return view('front1.library',compact(['products','allcategories','category','subcategories']));
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
