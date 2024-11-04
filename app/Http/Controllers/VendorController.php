<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class VendorController extends Controller
{
    public function index()
    {
        return response()->json(Vendor::all());
    }
    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
        return response()->json($vendor);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vendor_name' => 'required|unique:vendors',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }
        $vendor = new Vendor();
        $vendor->vendor_name = $request->vendor_name;
        $vendor->save();

        return response()->json($vendor);
    }
    public function update(Request $request, Vendor $vendor)
    {
        $validator = Validator::make($request->all(), [
            'vendor_name' => 'required|' . Rule::unique('vendors')->ignore($vendor->id),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }
        $vendor->vendor_name = $request->vendor_name;
        $vendor->save();

        return response()->json($vendor);
    }
}
