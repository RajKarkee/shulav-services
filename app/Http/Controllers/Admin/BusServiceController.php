<?php

namespace App\Http\Controllers\Admin;

use App\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusRouteLocation;
use App\Models\Bus_type;
use App\Models\BusType;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;

class BusServiceController extends Controller
{
    public function index()
    {
        $locations = BusRouteLocation::all();
        $busTypes = BusType::all();
        return view('admin.bus_services.busRoutes.index', compact('locations', 'busTypes'));
    }

    public function location()
    {

        $locations = BusRouteLocation::all();
        return view('admin.bus_services.locations', compact('locations'));
    }
    public function locationStore(Request $request)
    {
        BusRouteLocation::create([
            'location_name' => $request->input('location_name'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
        ]);
        return redirect()->route('admin.busServices.location.index')->with('success', 'Location added successfully.');
    }

    public function del(BusRouteLocation $location)
    {
        $location->delete();
        return redirect()->route('admin.busServices.location.index')->with('success', 'Location deleted successfully.');
    }

    public function vehicleTypeIndex()
    {
        $busTypes = BusType::all();

        return view('admin.bus_services.type', compact('busTypes'));
    }
    public function vehicleTypeAdd(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('admin.bus_services.type_create');
        } else {
            $bus_type = new BusType();
            $bus_type->bus_type_name = $request->input('bus_type_name');
            $bus_type->short_description = $request->input('short_desc');
            $bus_type->long_description = $request->input('desc');
            for ($i = 1; $i <= 3; $i++) {
                if ($request->hasFile('image_' . $i)) {
                    $bus_type->{'image_' . $i} = $request->file('image_' . $i)->store('uploads/bus_types');
                }
            }
            $bus_type->save();
            return redirect()->back()->with('success', 'Bus Type added successfully.');
        }
    }

    public function vehicleTypeDelete($id)
    {
        BusType::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Bus Type deleted successfully.');
    }

    public function vehicleIndex(Request $request)
    {
        $vehicles = DB::table('vehicles')->get();
        return view('admin.bus_services.vehicle.index', compact('vehicles'));
    }

    public function vehicleAdd(Request $request)
    {
        if ($request->isMethod('get')) {
            $busTypes = DB::table('bus_types')->get(['id', 'bus_type_name']);
            return view('admin.bus_services.vehicle.add', compact('busTypes'));
        } else {
            $Vehicle = new Vehicle();
            $Vehicle->name = $request->input('name');
            $Vehicle->capacity = $request->input('capacity');
            $Vehicle->bus_type_id = $request->input('bus_type_id');
            for ($i = 1; $i <= 7; $i++) {
                if ($request->hasFile('image_' . $i)) {
                    $Vehicle->{'image_' . $i} = $request->file('image_' . $i)->store('uploads/vehicles');
                }
            }
            $Vehicle->save();
            return redirect()->back()->with('success', 'Bus added successfully.');
        }
    }

    public function vehicleEdit(Request $request, $vehicle_id)
    {
        $Vehicle = Vehicle::where('id', $vehicle_id)->first();
        if ($request->isMethod('get')) {
            $busTypes = DB::table('bus_types')->get(['id', 'bus_type_name']);
            return view('admin.bus_services.vehicle.edit', compact('Vehicle','busTypes'));
        } else {
            $Vehicle->name = $request->input('name');
            $Vehicle->capacity = $request->input('capacity');
            $Vehicle->bus_type_id = $request->input('bus_type_id');
            for ($i = 1; $i <= 3; $i++) {
                if ($request->hasFile('image_' . $i)) {
                    $Vehicle->{'image_' . $i} = $request->file('image_' . $i)->store('uploads/vehicles');
                }
            }
            $Vehicle->save();
            return redirect()->back()->with('success', 'Bus updated successfully.');
        }
    }

    public function vehicleDelete($id)
    {
        Vehicle::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Bus deleted successfully.');
    }
}
