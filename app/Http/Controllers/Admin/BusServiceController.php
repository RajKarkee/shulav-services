<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusRouteLocation;
use App\Models\Bus_type;

class BusServiceController extends Controller
{
    public function index()
    {
        return view('admin.bus_services.index');
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
        // Store the location in the database
        // Location::create($request->all());

        return redirect()->route('admin.busServices.location.index')->with('success', 'Location added successfully.');
    }

    public function del(BusRouteLocation $location)
    {
        $location->delete();
        return redirect()->route('admin.busServices.location.index')->with('success', 'Location deleted successfully.');
    }

    public function type()
    {
        $busTypes = Bus_type::all();

        return view('admin.bus_services.type', compact('busTypes'));
    }
    public function typeStore(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('admin.bus_services.type_create');
        } else {

            // Validation (you can enable this if needed)
            // $request->validate([
            //     'bus_type_name' => 'required|string|max:255',
            //     'short_desc' => 'nullable|string',
            //     'desc' => 'nullable|string',
            //     'image1' => 'nullable|image|mimes:jpg,jpeg,png',
            //     ...
            // ]);
            $bus_type = new Bus_type();
            $bus_type->bus_type_name = $request->input('bus_type_name');
            $bus_type->short_description = $request->input('short_desc');
            $bus_type->long_description = $request->input('desc');



            for ($i = 1; $i <= 7; $i++) {
                if ($request->hasFile('image_' . $i)) {
                    $bus_type->{'image_' . $i} = $request->file('image_' . $i)->store('images/bus_types', 'public');
                }
            }
            $bus_type->save();
            // Handle images (check before storing)

            // Create the record


            return redirect()->route('admin.busServices.type.index')->with('success', 'Bus Type added successfully.');
        }

    }

    public function typeDel($id)
    {
        $bus_type = Bus_type::findOrFail($id);
        $bus_type->delete();
        return redirect()->route('admin.busServices.type.index')->with('success', 'Bus Type deleted successfully.');
    }
}
