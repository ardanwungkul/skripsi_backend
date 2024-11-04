<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $domain = Domain::orderBy('created_at', 'desc')->with('user')->get();
        return response()->json($domain);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vendor = Vendor::all();
        $user = User::where('role', 'user')->get();
        return response()->json(['vendor' => $vendor, 'user' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'domain_name' => 'required|string|max:255|unique:domains',
            'vendor' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }
        $domain = new Domain();
        $domain->domain_name = $request->domain_name;
        $domain->start_date = $request->start_date;
        $domain->expired_date = $request->expired_date;
        $domain->description = $request->description;
        $vendorExist = Vendor::where('vendor_name', $request->vendor)->first();
        if ($vendorExist) {
            $domain->vendor_id = $vendorExist->id;
        } else {
            $vendor = new Vendor();
            $vendor->vendor_name = $request->vendor;
            $vendor->save();
            $domain->vendor_id = $vendor->id;
        }
        if ($request->user !== 'null') {
            $domain->user_id = $request->user;
        } else {
            $user = new User();
            $user->name = $request->domain_name;
            $user->username = $request->domain_name;
            $user->email = $request->domain_name . '@gmail.com';
            $user->password = Hash::make(12345678);
            $user->role = 'user';
            $user->save();

            $domain->user_id = $user->id;
        }
        $domain->save();
        return response()->json($domain);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($domain)
    {
        $domain = Domain::with('user', 'vendor')->find($domain);
        $vendor = Vendor::all();
        $user = User::where('role', 'user')->get();
        if ($domain) {
            return response()->json([
                'domain' => $domain,
                'vendor' => $vendor,
                'user' => $user
            ]);
        } else {
            return response()->json(['error' => 'Domain not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Domain $domain)
    {
        $validator = Validator::make($request->all(), [
            'domain_name' => 'required|string|max:255|' . Rule::unique('domains')->ignore($domain->id),
            'vendor' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }
        $domain->domain_name = $request->domain_name;
        $domain->start_date = $request->start_date;
        $domain->expired_date = $request->expired_date;
        $domain->description = $request->description;
        $vendorExist = Vendor::where('vendor_name', $request->vendor)->first();
        if ($vendorExist) {
            $domain->vendor_id = $vendorExist->id;
        } else {
            $vendor = new Vendor();
            $vendor->vendor_name = $request->vendor;
            $vendor->save();
            $domain->vendor_id = $vendor->id;
        }
        if ($request->user !== 'null') {
            $domain->user_id = $request->user;
        } else {
            $user = new User();
            $user->name = $request->domain_name;
            $user->username = $request->domain_name;
            $user->email = $request->domain_name . '@gmail.com';
            $user->password = Hash::make(12345678);
            $user->role = 'user';
            $user->save();

            $domain->user_id = $user->id;
        }
        $domain->save();
        return response()->json($domain);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Domain $domain)
    {
        $domain->delete();
        return response()->json($domain);
    }
}
