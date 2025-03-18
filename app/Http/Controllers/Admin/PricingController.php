<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PricingController extends Controller
{
    //
    public function index()
    {
        return view('admin.pricing.index',[
            'pricings'=>DB::table('pricings')->orderBy('days')->get()
        ]);
    }

    public function add(Request $request)
    {
        $pricing=new Pricing();
        $pricing->price=$request->price;
        $pricing->days=$request->days;
        $pricing->msg=$request->msg??'';
        $pricing->save();
        return redirect()->back()->with('message','Pricing added sucessfully');
    }

    public function edit(Pricing $pricing,Request $request)
    {
        $pricing->price=$request->price;
        $pricing->days=$request->days;
        $pricing->msg=$request->msg??'';
        $pricing->save();
        return redirect()->back()->with('message','Pricing updated sucessfully');
    }

    public function del(Pricing $pricing,Request $request)
    {
        $pricing->delete();
        return redirect()->back()->with('message','Pricing deleted sucessfully');
    }
}
