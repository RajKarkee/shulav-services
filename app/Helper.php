<?php
namespace App;

use Illuminate\Support\Facades\File;

class Helper{
    // public static function allDataToArray($data)
    // {
    //     $d=[];
    //     $d['cities']=[];
    //     $d['services']=[];

    //     foreach (explode(',',$data->cities) as  $value) {
    //         $dd=explode(':',$value);
    //         array_push($d['cities'],(object)([
    //             'id'=>$dd[0],
    //             'name'=>$dd[1]
    //         ]))
    //     }
    // }
    public const iconmap=[
        'Facebook'=> "fa-facebook-f",
        'Twitter'=> "fa-twitter",
        'Instagram'=> "fa-instagram",
        'Youtube'=> "fa-youtube",
        'LinkedIN'=> "fa-linkedin-in",
        "Telegram">"fa-telegram"
    ];
    public const ratings=[
        '',
        'Bad',
        'Modrate',
        'Good',
        'Very Good',
        'Excellent'
    ];

    public static function createImage($img,$path='')
    {
        try {

            $folderPath = public_path($path).DIRECTORY_SEPARATOR;

            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $filename = uniqid() . '. '.$image_type;
            $filename=$path.DIRECTORY_SEPARATOR.uniqid() .$filename;
            $file=$folderPath.$filename;
            File::ensureDirectoryExists($folderPath);
            file_put_contents($file, $image_base64);
            return $filename;
        } catch (\Throwable $th) {
            //throw $th;
            return null;
        }

    }
}
