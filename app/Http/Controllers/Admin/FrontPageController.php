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
            if (!isset($request->product_id) || empty($request->product_id)) {
                return redirect()->back()->with('error', 'Please select at least one product');
            }

            $insertedCount = 0;
            $existingProducts = [];

            foreach ($request->product_id as $productId) {
                $exists = FrontPageSectionProduct::where('front_page_section_id', $section_id)
                    ->where('product_id', $productId)
                    ->exists();

                if (!$exists) {
                    $sectionProduct = new FrontPageSectionProduct();
                    $sectionProduct->front_page_section_id = $section_id;
                    $sectionProduct->product_id = $productId;
                    $sectionProduct->save();
                    $insertedCount++;
                } else {
                    $existingProducts[] = DB::table('products')->where('id', $productId)->value('name') ?? $productId;
                }
            }

            cache()->forget('front_page_sections');

            if ($insertedCount > 0) {
                $message = $insertedCount . ' Product(s) Added Successfully';
                if (!empty($existingProducts)) {
                    $message .= '. The following products already exist: ' . implode(', ', $existingProducts);
                }
                return redirect()->back()->with('message', $message);
            } else {
                return redirect()->back()->with('error', 'All selected products already exist in this section');
            }
        } else {
            $products = DB::table('products')->where('active',1)->get(['id', 'name']);
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
