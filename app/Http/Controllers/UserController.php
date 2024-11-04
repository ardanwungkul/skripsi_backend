<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all());
    }
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json($user);
    }
    public function edit(User $user)
    {
        if ($user) {
            return response()->json([
                'user' => $user
            ]);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:255|unique:users',
            'username' => 'required|max:255|unique:users',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->role = $request->role;
        $user->save();

        return response()->json($user);
    }
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:255|' . Rule::unique('users')->ignore($user->id),
            'username' => 'required|max:255|' . Rule::unique('users')->ignore($user->id),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        if ($request->password && $request->password !== null) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return response()->json($user);
    }
    public function show($user)
    {
        $user = User::where('id', $user)->with('domain')->first();

        return response()->json($user);
    }
}
