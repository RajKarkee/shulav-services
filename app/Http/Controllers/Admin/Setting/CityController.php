<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    public function index(){
        $cities=DB::table('cities')->get(['id','name']);
        return view('admin.setting.city.index',compact('cities'));
    }

    public function add(Request $request){
        if($request->getMethod()=="POST"){
            $city=new City();
            $city->name=$request->name;
            $city->desc=$request->desc??'';
            $city->lat=$request->lat;
            $city->lan=$request->lan;
            if($request->hasFile('image')){
                $city->image=$request->image->store('uploads/city');
            }
            $city->save();
            Helper::clearCitiesCache();
            return response()->json(['status'=>true]);
        }else{
            return view('admin.setting.city.add');
        }
    }
    public function edit(Request $request,City $city){
        if($request->getMethod()=="POST"){
            $city->name=$request->name;
            $city->desc=$request->desc??'';
            $city->lat=$request->lat;
            $city->lan=$request->lan;
            if($request->hasFile('image')){
                $city->image=$request->image->store('uploads/city');
            }
            $city->save();
            Helper::clearCitiesCache();
            return response()->json(['status'=>true]);
        }else{
            return view('admin.setting.city.edit',compact('city'));
        }
    }

    public function delete(Request $request){
        City::where('id',$request->id)->delete();
        Helper::clearCitiesCache();
        return response()->json(['status'=>true]);
    }
}
