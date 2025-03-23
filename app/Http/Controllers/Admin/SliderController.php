<?php

namespace App\Http\Controllers\Admin;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class SliderController extends Controller
{
    public function index()
    {
        $sliders=Slider::all();
        // dd($sliders);
        return view('admin.slider.index',compact('sliders'));
    }

    public function add(Request $request)
    {
        if($request->getMethod()=="POST"){
            $slider=new Slider();
            $slider->image=$request->image->store('uploads/slider');
            $slider->mobile_image=$request->mobile_image->store('uploads/slider');
            $slider->link=$request->link;
            $slider->index=$request->index;
            $slider->save();
            $this->render() ;
            return response()->json(['status'=>true]);
        }else{
            return view('admin.slider.add');
        }
    }

    public function edit(Request $request,Slider $slider)
    {
        if($request->getMethod()=="POST"){
            if($request->hasFile('image')){

                $slider->image=$request->image->store('uploads/slider');
            }
            if($request->hasFile('mobile_image')){
                $slider->mobile_image=$request->mobile_image->store('uploads/slider');
            }

            $slider->link=$request->link;
            $slider->index=$request->index;
            $slider->save();
            $this->render() ;
            return response()->json(['status'=>true]);
        }else{
            return view('admin.slider.edit',compact('slider'));
        }
    }

    public function del(Request $request,Slider $slider){
        $slider->delete() ;
        $this->render() ;
        return redirect()->back()->with('message','Slider Deleted');
    }
    public function render(){
        $sliders = DB::table('sliders')->get();
        Helper::putCache('home.slider',view('admin.setting.template.slider',compact('sliders')));
    }
}
