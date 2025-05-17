<?php

namespace App\Http\Controllers\admin;


use App\Http\Controllers\Controller;
use App\Models\BusRoute;
use App\Models\Bus_type;
use App\Models\BusRouteLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class BusRouteController extends Controller
{
    public function loadData()
    {
        $routes = BusRoute::with(['fromLocation', 'toLocation', 'busType'])->get();
        return response()->json([
            'status' => true,
            'routes' => $routes
        ]);
    }

    public function getVehicle(Request $request)
    {
        $vehicles = DB::table('vehicles')->where('bus_type_id', $request->bus_type_id)->get();
        return response()->json($vehicles);
    }
    public function add(Request $request)
    {
        $route = new BusRoute();
        $route->from_location_id = $request->from_location_id;
        $route->to_location_id = $request->to_location_id;
        $route->bus_type_id = $request->bus_type_id;
        $route->distance = $request->distance;
        $route->estimated_time = $request->estimated_time;
        $route->fare = $request->fare;
        $route->description = $request->description;
        $route->save();

        return response()->json([
            'status' => true,
            'message' => 'Route added successfully'
        ]);
    }

    public function edit(Request $request)
    {
        $route = BusRoute::where('id',$request->id)->first();
        if (!$route) {
            return response()->json([
                'status' => false,
                'message' => 'Route not found'
            ]);
        }
        return response()->json([
            'status' => true,
            'route' => $route
        ]);
    }

    public function update(Request $request)
    {

        $route = BusRoute::where('id', $request->id)->first();
        if (!$route) {
            return response()->json([
                'status' => false,
                'message' => 'Route not found'
            ]);
        }
        $route->from_location_id = $request->from_location_id;
        $route->to_location_id = $request->to_location_id;
        $route->bus_type_id = $request->bus_type_id;
        $route->distance = $request->distance;
        $route->estimated_time = $request->estimated_time;
        $route->fare = $request->fare;
        $route->description = $request->description;
        $route->save();

        return response()->json([
            'status' => true,
            'message' => 'Route updated successfully'
        ]);
    }

    public function delete(Request $request)
    {
        $route = BusRoute::find($request->id);

        if (!$route) {
            return response()->json([
                'status' => false,
                'message' => 'Route not found'
            ]);
        }

        $route->delete();

        return response()->json([
            'status' => true,
            'message' => 'Route deleted successfully'
        ]);
    }
}
