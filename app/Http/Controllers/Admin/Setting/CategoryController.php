<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class CategoryController extends Controller
{
    public function index(){
        $cats=Category::with('services')->get();
        return view('admin.setting.service.category',compact('cats'));
    }

    public function category(Category $cat){
        return view('admin.setting.service.index',compact('cat'));
    }

    public function add(Request $request){
        $data=null;
        if($request->state==1){
            $data=new Category();
        }else{
            $data=new Service();
            $data->category_id=$request->category_id;
        }
        $data->name=$request->name;
        $data->rate=$request->rate??0;
        $data->desc=$request->desc;
        if($request->hasFile('image')){
            $data->image=$request->image->store('uploads/'.($request->state==1?'category':'service'));
        }
        $data->save();
        //Artisan::call("make:data");

        return $request->state==1?view('admin.setting.service.singlecategory',['cat'=>$data]):view('admin.setting.service.singleservice',['cat'=>$data]);
    }

    public function update(Request $request){
        $data=null;
        if($request->state==1){
            $data=Category::find($request->id);
        }else{
            $data=Service::find($request->id);

        }
        $data->name=$request->name;
        $data->rate=$request->rate??0;
        $data->desc=$request->desc;
        if($request->hasFile('image')){
            $data->image=$request->image->store('uploads/'.($request->state==1?'category':'service'));
        }
        $data->save();
        //Artisan::call("make:data");

        if($request->state==1){
            $data->services;
        }
        return $request->state==1?view('admin.setting.service.singlecategory',['cat'=>$data]):view('admin.setting.service.singleservice',['cat'=>$data]);
    }

    public function delete(Request $request){
        $data=null;
        if($request->state==1){
            $data=Category::find($request->id);
        }else{
            $data=Service::find($request->id);
        }
        $data->delete();
        //Artisan::call("make:data");

        return response()->json(['status'=>true]);
    }
}
