<?php

use App\Models\Popup;
use App\Models\Setting;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

function getIDPath($id){
      return implode('/', str_split(sprintf("%09d", $id),3));
}

function getDatePath($path){
    return $path.'/'.Carbon::now()->format('Y/m/d');
}
function getSetting($key,$direct=false){
    $s=DB::table('settings')->where('code',$key)->select('value')->first();
    return $direct?($s!=null?$s->value:null):($s!=null?json_decode($s->value):null);
}

function setSetting($key,$value,$direct=false){
    $s=Setting::where('code',$key)->first();
    if($s==null){
        $s=new Setting();
        $s->code=$key;
    }
    if($direct){
        $s->value=$value;
    }else{

        $s->value=json_encode($value);
    }
    $s->save();
    return $s;
}

function writeView($path1,$path2,$data=[]){

    file_put_contents(resource_path('views/'.str_replace('.','/',$path1).".blade.php"),view($path2,$data)->render());
}
function getPopup(){
    return Popup::where('active',1)->first();
}

function makeCache($file,$data){
    File::ensureDirectoryExists(public_path('api'));
    file_put_contents(public_path('api/'.$file.'.php'),"<?php
    return '".str_replace("'","\'",json_encode($data))."';");
}

function updateVersion(){
    $_ver=getSetting('ver');
    if($_ver==null){
        $ver=['ver'=>1];
    }else{
        $ver=['ver'=>$_ver->ver+1];
    }
    setSetting('ver',$ver);
    $ver_txt='<?php

    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST");
    header("Access-Control-Allow-Headers: X-Requested-With,Content-Type,accept,Authorization");

    $version='.$ver['ver'].';
    if($version==(isset($_REQUEST["v"])?$_REQUEST["v"]:0)){
        $data=[
            "s"=>true,
            "v"=>$version,
            "d"=>null,
        ];
    }else{
        $data=[
            "s"=>false,
            "v"=>$version,
            "d"=> json_decode(require("data.php")),
        ];
    }
    echo json_encode($data);';
    file_put_contents(public_path('api/ver.php'),$ver_txt);

}

function ddApi($data){
    // header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST");
    header("Access-Control-Allow-Headers: X-Requested-With,Content-Type,accept,Authorization");
    dd($data);

}
class authInfo{
    public static $vendor;
}

function getVendor(){
    if(authInfo::$vendor==null){
        $user = Auth::user()->id;
        authInfo::$vendor = Vendor::where('user_id',$user)->first();
    }
    return authInfo::$vendor;
}
