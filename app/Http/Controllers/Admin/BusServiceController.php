<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusRouteLocation;

class BusServiceController extends Controller
{
    public function index(){
return view('admin.bus_services.index');
    }

    public function location(){

        $locations= BusRouteLocation::all();
        return view('admin.bus_services.locations', compact('locations'));
        
    }
    public function locationStore(Request $request){
  
        
        BusRouteLocation::create([
            'location_name' => $request->input('location_name'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
        ]);
        // Store the location in the database
        // Location::create($request->all());

       return redirect()->route('admin.busServices.location.index')->with('success', 'Location added successfully.');
    }

    public function del(BusRouteLocation $location)
    {
        $location->delete();
        return redirect()->route('admin.busServices.location.index')->with('success', 'Location deleted successfully.');
    }
}
