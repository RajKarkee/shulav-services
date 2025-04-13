<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FrontPageSection;
use App\Models\FrontPageSectionProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontPageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->getMethod() == "POST") {
            $frontsection = new FrontPageSection();
            $frontsection->section_name = $request->section_name;
            $frontsection->design_type = $request->design_type;
            $frontsection->position = $request->position;
            $frontsection->save();
            cache()->forget('front_page_sections');
        } else {
            $sections = DB::table('front_page_sections')->get(['id', 'section_name', 'design_type', 'position']);
            return view('admin.frontpage.index', compact('sections'));
        }
    }
    public function edit(Request $request,$section_id)
    {
        $frontsection = FrontPageSection::where('id', $section_id)->first();
        $frontsection->section_name = $request->section_name;
        $frontsection->design_type = $request->design_type;
        $frontsection->position = $request->position;
        $frontsection->save();
        cache()->forget('front_page_sections');
    }
    public function del($section_id)
    {
        FrontPageSectionProduct::where('front_page_section_id', $section_id)->delete();
        FrontPageSection::where('id', $section_id)->delete();
        cache()->forget('front_page_sections');
        cache()->forget('service_categories');
        return redirect()->back()->with('message', 'Section Deleted Successfully');
    }

    public function productIndex(Request $request,$section_id)
    {
        if ($request->getMethod() == "POST") {
            $exists = FrontPageSectionProduct::where('front_page_section_id', $section_id)
                ->where('product_id', $request->product_id)
                ->exists();

            if ($exists) {
               return redirect()->back()->with('error', 'Product Already Exists in this Section');
            }

            $sectionProduct = new FrontPageSectionProduct();
            $sectionProduct->front_page_section_id = $section_id;
            $sectionProduct->product_id = $request->product_id;
            $sectionProduct->save();
            cache()->forget('front_page_sections');
            
            return redirect()->back()->with('message', 'Section Product Added Successfully');
        } else {
            $products = DB::table('products')->get(['id', 'name']);
            $sectionProducts = DB::table('front_page_section_products')->where('front_page_section_id', $section_id)->get(['id', 'product_id']);
            return view('admin.frontpage.product.index',compact('products', 'section_id','sectionProducts'));
        }
    }
    public function productDel($sectionProduct_id)
    {
        FrontPageSectionProduct::where('id', $sectionProduct_id)->delete();
        cache()->forget('front_page_sections');
        return redirect()->back()->with('message', 'Section Product Deleted Successfully');
    }
}
