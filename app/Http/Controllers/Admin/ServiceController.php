<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use File;

class ServiceController extends Controller
{
    // Show list of services
    public function index()
    {
        $services = Service::all();
        $categories=Category::all();
        return view('admin.service.index', compact('services','categories'));
    }

    // Show form to create a new service
    public function create()
    {
        return view('admin.service.add');
    }

    // Store a new service
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'nullable|numeric',
            'desc' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
            'type' => 'nullable|in:1,2,3,4,5',  // Validating the type value
            'category_id' => 'nullable|exists:categories,id', // Ensure category exists in the categories table
        ]);

        $service = new Service();
        $service->name = $request->name;
        $service->rate = $request->rate ?? null;
        $service->desc = $request->desc;
        $service->type = $request->type;
        $service->category_id = $request->category_id;
        $service->active = $request->active ?? 1;
        if ($request->hasFile('image')) {
            $service->image = $request->file('image')->store('uploads/service');
        }
        $service->save();

        return redirect()->route('admin.service.index')->with('success', 'Service added successfully.');
    }

    // Show form to edit an existing service
    public function edit(Service $service)
    {
        return view('admin.service.edit', compact('service'));
    }

    // Update an existing service
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'nullable|numeric',
            'desc' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
            'type' => 'nullable|in:1,2,3,4,5',  // Validating the type value
            'category_id' => 'nullable|exists:categories,id', // Ensure category exists in the categories table
        ]);

        $service->name = $request->name;
        $service->rate = $request->rate ?? null;
        $service->desc = $request->desc;
        $service->type = $request->type;
        $service->category_id = $request->category_id;
        $service->active = $request->active ?? 1;

        // Handle Image Upload - Saving directly to 'uploads/service' directory
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($service->image && File::exists(public_path($service->image))) {
                File::delete(public_path($service->image));
            }

            $imagePath = 'uploads/service/';
            $fileName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path($imagePath), $fileName);
            $service->image = $imagePath . $fileName;
        }

        $service->save();

        return redirect()->route('admin.service.index')->with('success', 'Service updated successfully.');
    }

    // Delete a service
    public function destroy(Service $service)
    {
        // If image exists, delete the image from the uploads directory
        if ($service->image && File::exists(public_path($service->image))) {
            File::delete(public_path($service->image));
        }

        $service->delete();
        return redirect()->route('admin.service.index')->with('success', 'Service deleted successfully.');
    }
}

