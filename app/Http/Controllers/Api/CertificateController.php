<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CertificateController extends Controller
{
    public function addCertificate(Request $request){
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
        return response()->json([
            'status' => true,
            'msg' => 'certificate added successfully'
        ]);
    }

    public function updateCertificate(Request $request){
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
        return response()->json([
            'status' => true,
            'msg' => 'certificate updated successfully'
        ]);
    }

    public function certificateList(){
        // $certificates = Certificate::where('user_id',Auth::user()->id)->get();
        $certificates = DB::table('certificates')->where('user_id',Auth::user()->id)->select('id','title','image','file')->get();
        return response()->json([
            'status'=> true,
            'certificates' => $certificates
        ]);
    }

    public function certificateDelete(Request $request){
        $certificate = Certificate::where('id',$request->id)->first();
        $certificate->delete();
        return response()->json([
            'status'=> true,
            'msg' => 'Certificate deleted successfully!'
        ]);
    }

}
