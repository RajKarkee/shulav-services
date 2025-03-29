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

    public const serviceTypes = [
        1 => 'Normal Service',
        2 => 'Hotel And Restaurant',
        3 => 'Ticketing',
        4 => 'Vehicle Renting',
        5 => 'House Renting',
        6 => 'Venue Ticketing',
    ];

    const service_type_normal = 1;
    const service_type_hotel = 2;
    const service_type_ticketing = 3;
    const service_type_vehicle_renting = 4;
    const service_type_house_renting = 5;
    const service_type_venue_ticketing = 6;

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
    public static function putCache($_filePath, $content)
    {
        $pathDatas=explode('.',$_filePath);
        //append .balde.php to last element if not exists
        if(count($pathDatas)>0){
            $lastElement=$pathDatas[count($pathDatas)-1];
            $pathDatas[count($pathDatas)-1].='.blade.php';

        }

        $filePath=implode('/',$pathDatas);


        $filePath = resource_path("views/front1/cache/".$filePath);
        // Extract the directory path from the file path
        $directoryPath = dirname($filePath);

        // Ensure the directory exists, if not create it
        if (!is_dir($directoryPath)) {
            mkdir($directoryPath, 0755, true);
        }

        // Put the content to the file path
        file_put_contents($filePath, $content);
    }
}
