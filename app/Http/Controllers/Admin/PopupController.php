<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Popup;
use Illuminate\Http\Request;

class PopupController extends Controller
{
    public function index()
    {
        $popups=Popup::all();
        return view('admin.popup.index',compact('popups'));
    }

    public function add(Request $request)
    {
        if($request->getMethod()=="POST"){
            $popup=new Popup();
            $popup->image=$request->image->store('uploads/popup');
            $popup->link=$request->link;
            $popup->is_large=$request->is_large??0;
            $popup->save();
            return response()->json(['status'=>true]);
        }else{
            return view('admin.popup.add');
        }
    }

    public function edit(Request $request,Popup $popup)
    {
        if($request->getMethod()=="POST"){
            if($request->hasFile('image')){

                $popup->image=$request->image->store('uploads/popup');
            }


            $popup->link=$request->link;
            $popup->is_large=$request->is_large??0;

            $popup->save();
            return response()->json(['status'=>true]);
        }else{
            return view('admin.popup.edit',compact('popup'));
        }
    }

    public function del(Request $request,Popup $popup){
        $popup->delete();
        return redirect()->back()->with('message','Popup Deleted');
    }
    public function status(Popup $popup,$status){
        if($status==1){
            Popup::where('id','>',0)->update(['active'=>0]);
        }
        $popup->active=$status;
        $popup->save();
        return redirect()->back()->with('message',"Popup". $status==1?'Activated':'Deactivated');
    }

}
