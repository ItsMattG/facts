<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'username' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        // Hash the password
        $hashedPassword = Hash::make($validatedData['password']);

        try {
            // Insert user data into users table
            DB::table('users')->insert([
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
                'password' => $hashedPassword,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Return a success response
            return response()->json(['message' => 'User registered successfully']);
        } catch (\Exception $e) {
            // Return error response if registration fails
            return response()->json(['error' => 'User registration failed'], 500);
        }
    }
}
