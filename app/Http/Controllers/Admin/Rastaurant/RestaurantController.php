<?php

namespace App\Http\Controllers\Admin\Rastaurant;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('admin.restaurant.index');
        } else {
            // dd($request->all());
            $rest = new Restaurant();
            $rest->name = $request->name;
            $rest->desc = $request->desc;
            $rest->logo = $request->image->store('back/images/restaurant');
            $rest->save();
        }
    }


    public function loadData()
    {
        $rests = Restaurant::all();
        return view('admin.restaurant.list', compact('rests'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $rest = Restaurant::where('id', $request->id)->first();
        $rest->name = $request->name;
        $rest->desc = $request->desc;
        if($request->hasFile('logo')){
            $rest->logo = $request->logo->store('back/images/restaurant');
        }
        $rest->save();
    }

    public function delete(Request $request){
        $rest = Restaurant::where('id', $request->id)->first();
        $rest->delete();
    }
}
