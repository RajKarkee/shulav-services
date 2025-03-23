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
function generateImageThumbnail($imagePath)
{
    $thumbnailPath = dirname($imagePath) . '/thumb_' . basename($imagePath);

    $fullPath=storage_path('app/'. $imagePath);
    $fullPathThumb=storage_path('app/'. $thumbnailPath);

    $imageType = exif_imagetype($fullPath);

    switch ($imageType) {
        case IMAGETYPE_JPEG:
            $source = imagecreatefromjpeg($fullPath);
            break;
        case IMAGETYPE_PNG:
            $source = imagecreatefrompng($fullPath);
            break;
        case IMAGETYPE_GIF:
            $source = imagecreatefromgif($fullPath);
            break;
        case IMAGETYPE_WEBP: // IMAGETYPE_WEBP constant not available in PHP < 7.4, use its value directly
            $source = imagecreatefromwebp($fullPath);

        default:
            // Unsupported image type
    }

    // Get the image dimensions
    list($originalWidth, $originalHeight) = getimagesize($fullPath);

    // Calculate new dimensions for the thumbnail
    $maxSize = 200;
    if ($originalWidth > $originalHeight) {
        $newWidth = $maxSize;
        $newHeight = intval($originalHeight / $originalWidth * $maxSize);
    } else {
        $newWidth = intval($originalWidth / $originalHeight * $maxSize);
        $newHeight = $maxSize;
    }

    // Create a new image resource
    $thumb = imagecreatetruecolor($newWidth, $newHeight);
    // Resize the image
    imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

    // Save the thumbnail
    imagejpeg($thumb, $fullPathThumb); // Adjust function according to the image type

    // Free up memory
    imagedestroy($thumb);
    imagedestroy($source);

    return $thumbnailPath;
}
