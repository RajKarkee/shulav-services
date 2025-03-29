<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index(Request $request){
        $cats=[];
        $parent_id=$request->parent_id;
        $parent=null;
        if($parent_id){
            $cats=DB::table(Category::tableName)->where('parent_id',$parent_id)->get();
            $parent=DB::table(Category::tableName)->where('id',$parent_id)->first();
        }else{
            $cats=DB::table(Category::tableName)->where('parent_id',null)->get();

        }

        return view('admin.setting.service.category',data: compact('cats','parent_id','parent'));
    }

    public function category(Category $cat){
        return view('admin.setting.service.index',compact('cat'));
    }

    public function add(Request $request){
        $category = new Category();
        $category->name = $request->name;
        $category->parent_id = $request->parent_id;
        if($request->filled('parent_id')){
            $parent = Category::find($request->parent_id);
            $category->type = $parent->type;
        }else{
            $category->type = $request->type??1;
        }
        $category->desc = $request->desc;
        $category->rate=$request->rate??0;
        if ($request->hasFile('image')) {
            $category->image = $request->image->store('uploads/category');
        }

        $category->save();
        Helper::clearCategoriesCache();

        return response()->json($category);
    }

    public function update(Request $request){
        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->type = $request->type??1;
        $category->desc = $request->desc;
        $category->rate=$request->rate??0;
        if ($request->hasFile('image')) {
            $category->image = $request->image->store('uploads/category');
        }
        $category->save();
        Helper::clearCategoriesCache();

        return response()->json($category);
    }

    public function delete(Request $request){
        Category::where('id',$request->id)->delete();
        Helper::clearCategoriesCache();
    }
}
