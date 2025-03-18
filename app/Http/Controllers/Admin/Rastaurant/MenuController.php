<?php

namespace App\Http\Controllers\Admin\Rastaurant;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request){
        if($request->isMethod('get')){
            return view('admin.restaurant.menu.index');
        }else{
            // dd($request->all());
            $menu = new Menu();
            $menu->name = $request->name;
            $menu->rate = $request->rate;
            $menu->timetodeliver = $request->timetodeliver;
            $menu->desc = $request->desc;
            $menu->logo = $request->logo->store('back/restaurant/menu');
            $menu->restaurant_id = $request->restaurant_id;
            $menu->save();
        }
    }

    public function loadData()
    {
        $menus = Menu::all();
        return view('admin.restaurant.menu.list', compact('menus'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $menu = Menu::where('id', $request->id)->first();
        $menu->name = $request->name;
        $menu->rate = $request->rate;
        $menu->timetodeliver = $request->timetodeliver;
        $menu->desc = $request->desc;
        $menu->restaurant_id = $request->restaurant_id;
        if($request->hasFile('logo')){
            $menu->logo = $request->logo->store('back/restaurant/menu');
        }
        $menu->save();
    }

    public function delete(Request $request){
        $menu = Menu::where('id', $request->id)->first();
        $menu->delete();
    }

}
