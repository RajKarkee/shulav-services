<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FrontPageSection;
use Illuminate\Http\Request;

class FrontPageController extends Controller
{
    public function index(Request $request)
    {
        if($request->getMethod()=="POST"){
            $frontsection = new FrontPageSection();
            $frontsection=$request->section_name;
            $frontsection=$request->design_type;
            $frontsection=$request->position;
            $frontsection->save();
            return redirect()->back()->with('message','Section Created');
        }
        else{
            return view('admin.frontpage.index');
        }
    }
}
