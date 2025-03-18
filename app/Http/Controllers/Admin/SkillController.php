<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillController extends Controller
{
    public function index(){
        $user = Auth::user();
        $skills = Skill::where('user_id',$user->id)->get();
        return view('vendor.skills.index',compact('skills','user'));
    }

    public function add(){
        $user = Auth::user();
        return view('vendor.skills.adde',compact('user'));
    }

    public function store(Request $request){
        $skill = new Skill();
        $skill->title = $request->title;
        $skill->type = $request->level;
        $skill->user_id = Auth::user()->id;
        $skill->save();
        return redirect()->route('vendor.skill.index');
    }

    public function edit($id){
        $skill = Skill::where('id',$id)->first();
        return view('front.page.skill.edit',compact('skill'));
    }

    public function update(Request $request,$id){
        $skill = Skill::where('id',$id)->first();
        $skill->title = $request->title;
        $skill->type = $request->type;
        $skill->user_id = Auth::user()->id;
        $skill->save();
        return redirect()->back()->with('success','Skill added successfully!');
    }

    public function delete($id){
        $skill = Skill::where('id',$id)->first();
        $skill->delete();
        return redirect()->back()->with('success','Skill deleted successfully!');
    }

}
