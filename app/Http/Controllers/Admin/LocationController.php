<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function index($id)
    {
        $city=DB::table('cities')->where('id',$id)->first();
        $locations=DB::table('locations')->where('city_id',$id)->get();
        return view('admin.setting.city.location.index',compact('city','locations'));
    }

    public function add($id,Request $request){
        if($request->getMethod()=="POST"){
            $city=new Location();
            $city->name=$request->name;
            $city->desc=$request->desc??'';
            $city->lat=$request->lat;
            $city->lan=$request->lan;
            $city->city_id=$id;
            if($request->hasFile('image')){
                $city->image=$request->image->store('uploads/location');
            }
            $city->save();
            // //Artisan::call("make:data");

            return response()->json(['status'=>true]);
        }else{
            $city=DB::table('cities')->where('id',$request->id)->first(['id','name']);
            return view('admin.setting.city.location.add',['city'=>$city]);
        }
    }

    public function edit(Location $location,Request $request)
    {
        if($request->getMethod()=="POST"){
            $location->name=$request->name;
            $location->desc=$request->desc??'';
            $location->lat=$request->lat;
            $location->lan=$request->lan;
            if($request->hasFile('image')){
                $location->image=$request->image->store('uploads/location');
            }
            $location->save();
            return response()->json(['status'=>true]);
        }else{
            return view('admin.setting.city.location.edit',compact('location'));
        }
    }
}
