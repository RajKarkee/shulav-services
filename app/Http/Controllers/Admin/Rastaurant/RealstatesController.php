<?php

namespace App\Http\Controllers\Admin\Rastaurant;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Realstate;
use App\Models\RealstateImage;
use Illuminate\Http\Request;
use Mockery\Undefined;

class RealstatesController extends Controller
{
    public function index(Request $request){
        if($request->isMethod('get')){
            $locations = Location::all();
            return view('admin.realstate.index',compact('locations'));
        }else{
            // dd($request->all());
            $request->validate([
                'name' => 'required',
                'rate' => 'required',
                'contact' =>'required',
                'desc' => 'required',
                'city_id' => 'required',
                'location_id' => 'required'
            ]);
            $data = new Realstate();
            $data->name = $request->name;
            $data->desc = $request->desc;
            $data->rate = $request->rate;
            $data->contacts = $request->contact;
            $data->city_id = $request->city_id;
            $data->location_id = $request->location_id;
            $data->image = $request->featureimg->store('back/img/realstate');
            $data->save();

            if($request->hasFile('gallery')){
                foreach ($request->gallery as $key => $imgs) {
                   $img = new RealstateImage();
                   $img->realstate_id = $data->id;
                   $img->image = $imgs->store('back/img/realstate');
                   $img->save();
                }
            }

        }
    }


    public function location(Request $request){
        // dd($request->all());
        $location = Location::where('city_id',$request->city_id)->get();
        return response()->json($location);
    }

    public function loadData(){
        $data = Realstate::all();
        return view('admin.realstate.list',compact('data'));
    }


    public function update(Request $request){
        $request->validate([
            'name' => 'required',
            'rate' => 'required',
            'contact' =>'required',
            'desc' => 'required',
            'city_id' => 'required',
            'location_id' => 'required'
        ]);
        $data = Realstate::where('id',$request->id)->first();
        $data->name = $request->name;
        $data->desc = $request->desc;
        $data->rate = $request->rate;
        $data->contacts = $request->contact;
        $data->city_id = $request->city_id;
        $data->location_id = $request->location_id;
        if($request->hasFile('featureimg')){
            $data->image = $request->featureimg->store('back/img/realstate');
        }
        $data->save();
    }

    // name
    // desc
    // rate
    // contacts
    // images(multiple image)
    // city_id
    // location_id

    public function detail($id){
        $realstate = Realstate::find($id);
        return view('admin.realstate.detail',compact('realstate'));
    }

    public function imagedelete($id){
        RealstateImage::where('id',$id)->delete();
        return redirect()->back();
    }

    public function gallery(Request $request){
        if($request->hasFile('gallery')){
            foreach ($request->gallery as $key => $imgs) {
               $img = new RealstateImage();
               $img->realstate_id = $request->id;
               $img->image = $imgs->store('back/img/realstate');
               $img->save();
            }
            return redirect()->back();
        }
    }


}
