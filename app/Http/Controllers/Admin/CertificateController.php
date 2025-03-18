<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CertificateController extends Controller
{

    public function index(){
        $user = Auth::user();
        $certificates = Certificate::where('user_id',$user->id)->get();
        // dd($certificates);
        return view('vendor.certificate.index',compact('certificates','user'));
    }

    public function add(){
        $user = Auth::user();
        return view('vendor.certificate.add',compact('user'));
    }

    public function store(Request $request){
        // dd($request->all());
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
            "file" => "mimes:pdf,docx"
        ]);

        $certificate = new Certificate();
        $certificate->title = $request->title;
        if($request->hasFile('image')){
            $certificate->image = $request->image->store('image/certificate/img');
        }
        if($request->hasFile('file')){
            $certificate->file = $request->file->store('image/certificate/file');
        }
        $certificate->user_id = Auth::user()->id;
        $certificate->save();
        return redirect()->route('vendor.certificate.index');
    }



    public function update(Request $request){
        $certificate = Certificate::where('id',$request->id)->first();
        $certificate->title = $request->title;
        if($request->hasFile('image')){
            // unlink($certificate->image);
            $certificate->image = $request->image->store('image/certificate/img');
        }

        if($request->hasFile('file')){
            unlink($$certificate->file);
            $certificate->file = $request->file->store('image/certificate/file');
        }

        $certificate->user_id = Auth::user()->id;
        $certificate->save();
        return redirect()->back()->with('success','Certificate update successfully');

    }

    public function certificateList(){
        // $certificates = Certificate::where('user_id',Auth::user()->id)->get();
        $certificates = DB::table('certificates')->where('user_id',Auth::user()->id)->select('id','title','image','file')->get();
        return response()->json([
            'status'=> true,
            'certificates' => $certificates
        ]);
    }

    public function delete(Request $request){
        $certificate = Certificate::where('id',$request->id)->first();
        $certificate->delete();
        return redirect()->back()->with('success','Certificate deleted successfully');
    }


}
