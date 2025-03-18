<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SkillsController extends Controller
{
    public function addSkill(Request $request){
        $skill = new Skill();
        $skill->title = $request->title;
        $skill->type = $request->type;
        $skill->user_id = Auth::user()->id;
        $skill->save();
        return response()->json([
            'status' => true,
            'msg' => 'Skill added successfully'
        ]);
    }

    public function updateSkill(Request $request){
        $skill = Skill::where('id',$request->id)->first();
        $skill->title = $request->title;
        $skill->type = $request->type;
        $skill->user_id = Auth::user()->id;
        $skill->save();
        return response()->json([
            'status' => true,
            'msg' => 'Skill updaed successfully'
        ]);
    }

    public function skillList(){
        // $skillList = Skill::where('user_id',Auth::user()->id)->get();
        $skillList = DB::table('skills')->where('user_id',Auth::user()->id)->select('id','title','type')->get();

        return response()->json([
            'status' => true,
            'skills' => $skillList
        ]);
    }

    public function skillDelete(Request $request){
        $skill = Skill::where('id',$request->id)->first();
        $skill->delete();
        return response()->json([
            'status' => true,
            'msg' => 'Skill deleted successfully'
        ]);
    }
}
