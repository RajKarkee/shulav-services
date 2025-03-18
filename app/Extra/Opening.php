<?php
namespace App\Extra;
use Illuminate\Http\Request;

class Opening{
    public const options=[
        'sun'=>'sunday',
        'mon'=>'monday',
        'tue'=>'tuesday',
        'wed'=>'wednesday',
        'thu'=>'thursday',
        'fri'=>'friday',
        'sat'=>'saturday'
    ];
    public Day $sun;
    public Day $mon;
    public Day $tue;
    public Day $wed;
    public Day $thu;
    public Day $fri;
    public Day $sat;

    public static function init(Request $request):Opening{
        $opening=new Opening();
        $opening->sun=self::getDay($request,'sun');
        $opening->mon=self::getDay($request,'mon');
        $opening->tue=self::getDay($request,'tue');
        $opening->wed=self::getDay($request,'wed');
        $opening->thu=self::getDay($request,'thu');
        $opening->fri=self::getDay($request,'fri');
        $opening->sat=self::getDay($request,'sat');
        return $opening;
    }

    public static function getDay(Request $request,string $day):Day
    {
        return new Day($request->filled('open_'.$day),$request->input('start_'.$day),$request->input('end_'.$day));

    }

    // public function
}
