<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'message' => 'User created successfully',
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'token' => $token,
            'user' => $user
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Token deleted successfully',
        ]);
    }

    public function restaurantRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'required|string',
            'restaurant_name' => 'required|string',
            'restaurant_address' => 'required|string',
            'image' => 'required|image',
            'latlong' => 'required|string',
        ]);

        $data = $request->all();
        $data['roles'] = 'restaurant';
        $data['password'] = Hash::make($request->password);

        $user = User::create($data);

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $image_name);
            $user->image = $image_name;
            $user->save();
        }

        return response()->json([
            'message' => 'Restaurant created successfully',
        ], 201);
    }

    public function driverRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'required|string',
            'license_plate' => 'required|string',
            'image' => 'required|image',
        ]);

        $data = $request->all();
        $data['roles'] = 'driver';
        $data['password'] = Hash::make($request->password);

        $user = User::create($data);

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $image_name);
            $user->image = $image_name;
            $user->save();
        }

        return response()->json([
            'message' => 'Driver created successfully',
        ], 201);
    }

    public function updateLatlong(Request $request)
    {
        $request->validate([
            'latlong' => 'required|string',
        ]);

        $user = $request->user();
        $user->latlong = $request->latlong;
        $user->save();

        return response()->json([
            'message' => 'Latlong updated successfully',
            'data' => $user,
        ]);
    }

    public function getRestaurants()
    {
        $restaurants = User::where('roles', 'restaurant')->get();

        return response()->json([
            'message' => 'Success',
            'data' => $restaurants,
        ]);
    }
}
