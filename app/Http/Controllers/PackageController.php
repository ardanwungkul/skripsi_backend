<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PackageDomain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Package::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'package_name' => 'required|string|max:255',
            'package_price' => 'required|numeric',
            'package_description' => 'nullable|string',
            'package_hosting_storage' => 'nullable|integer',
            'package_hosting_email' => 'nullable|integer',
            'package_support' => 'required',
            'package_video_profile' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $package = new Package();
        $package->package_name = $request->package_name;
        $package->package_price = $request->package_price;
        $package->package_description = $request->package_description;
        $package->package_hosting_storage = $request->package_hosting_storage;
        $package->package_hosting_email = $request->package_hosting_email;
        $package->package_support = $request->package_support;
        $package->package_video_profile = $request->package_video_profile;
        $package->save();

        return response()->json($package);
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($package)
    {
        $package = Package::find($package);
        if ($package) {
            return response()->json([
                'package' => $package,
            ]);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Package $package)
    {
        $validator = Validator::make($request->all(), [
            'package_name' => 'required|string|max:255',
            'package_price' => 'required|numeric',
            'package_description' => 'nullable|string',
            'package_hosting_storage' => 'nullable|integer',
            'package_hosting_email' => 'nullable|integer',
            'package_support' => 'required',
            'package_video_profile' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $package->package_name = $request->package_name;
        $package->package_price = $request->package_price;
        $package->package_description = $request->package_description;
        $package->package_hosting_storage = $request->package_hosting_storage;
        $package->package_hosting_email = $request->package_hosting_email;
        $package->package_support = $request->package_support;
        $package->package_video_profile = $request->package_video_profile;
        $package->save();

        return response()->json($package);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        $package->delete();
        return response()->json($package);
    }
}
