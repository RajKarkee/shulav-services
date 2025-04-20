<?php

namespace App\Http\Controllers\admin;


use App\Http\Controllers\Controller;
use App\Models\BusRoute;
use App\Models\Bus_type;
use App\Models\BusRouteLocation;
use Illuminate\Http\Request;
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
        $route = BusRoute::find($request->id);

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
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:bus_routes,id',
            'from_location_id' => 'required|exists:route_locations,id',
            'to_location_id' => 'required|exists:route_locations,id|different:from_location_id',
            'bus_type_id' => 'required|exists:bus_types,id',
            'distance' => 'required|numeric|min:0',
            'estimated_time' => 'required|numeric|min:0',
            'fare' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $route = BusRoute::find($request->id);

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
