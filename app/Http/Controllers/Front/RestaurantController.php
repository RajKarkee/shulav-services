<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    public function index(){
        $user = Auth::user();
        $restaurants = Restaurant::all();
        return view('front.restaurant.index',compact('user','restaurants'));
    }

    public function menus($id){
        $menus = Menu::where('restaurant_id',$id)->get();
        $restro = Restaurant::find($id);
        $user = Auth::user();
        return view('front.restaurant.menu',compact('menus','user','restro'));
    }

    public function menusDetail($id){
        $menu = Menu::find($id);
        $user = Auth::user();
        return view('front.restaurant.menu_detail',compact('menu','user'));
    }

    public function cart(Request $request){
        $user = Auth::user();
        return view('front.restaurant.cart',compact('user'));
    }

    public function placeToOrder(Request $request){
        if($request->isMethod('get')){
            $user = Auth::user();
            return view('front.restaurant.placeorder',compact('user'));
        }else{
            // dd($request->all());

            foreach ($request->carts as $key => $value) {
                dd($value);
            }
        }
    }
}
