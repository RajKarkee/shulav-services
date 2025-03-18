<?php

namespace App\Http\Controllers\Api\Rastaurant;

use App\Http\Controllers\Controller;
use App\Models\Realstate;
use App\Models\RealstateImage;
use App\Models\Restaurant;
use App\Models\RestaurantOrder;
use App\Models\RestaurantOrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RestaurantController extends Controller
{
    public function restaurantList(){
        $restaurants = DB::table('restaurants')->get(['id','name','logo','desc']);
        return response()->json([
            'data' => $restaurants,
            'status' => true
        ]);
    }


    public function restaurantMenu(Request $request){
        $restaurant = DB::table('restaurants')->where('id',$request->restaurant_id)->first();
        $menus = DB::table('menus')->where('restaurant_id',$restaurant->id)
        ->select('name','logo','rate','timetodeliver','desc')->get();
        return response()->json([
            'menus' => $menus,
            'restaurant' => $restaurant,
            'status' => true
        ]);
    }


    public function restaurantOrder(Request $request){
        $vendor = getVendor();
        // $restaurant = DB::table('restaurants')->where('id',$request->restaurant_id)->first();
        $order = new RestaurantOrder();
        $order->restaurant_name = "";
        $order->address = $request->address;
        $order->phone = $request->phone;
        $order->date_time = $request->date_time;
        $order->vendor_id = $vendor->id;
        $order->save();
        foreach ($request->items as $key => $itm_) {
            $itm = (object)$itm_;
            $item = new RestaurantOrderItem();
            $item->restaurant_order_id = $order->id;
            $item->restaurant_id = $itm->restaurant_id;
            $item->resturant_name = $itm->resturant_name;
            $item->menu_name = $itm->menu_name;
            $item->menu_id = $itm->menu_id;
            $item->qty = $itm->qty;
            $item->rate = $itm->rate;
            $item->save();
        }

        return response()->json([
            'message' => 'Order sent successfully',
            'status' => true
        ]);

    }

    public function restaurantOrderList(Request $request){
        $vendor = getVendor();
        $order = DB::table('restaurant_orders as ro')->where('ro.vendor_id',$vendor->id)
        ->join('restaurant_order_items as roi','roi.restaurant_order_id','=','ro.id')
        ->select('ro.*','roi.*')->get();

        return response()->json([
            'orders' => $order,
            'status' => true
        ]);
    }


    public function realstatesList(){
        $data = DB::table('realstates as r')
                ->select(DB::raw('r.name,
                r.desc,r.rate,r.contacts,r.image,r.city_id,r.location_id,
                (select group_concat(image) from realstate_images where realstate_id=r.id) as images'))->get();

        return response()->json([
            'data' => $data,
            'status' => true
        ]);
    }


}
