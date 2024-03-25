<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        try {
            // Retrieve user from the database based on the email
            $user = DB::table('users')->where('email', $email)->first();

            // Check if user exists and verify password
            if (!$user || !Hash::check($password, $user->password)) {
                return response()->json(['error' => 'Invalid email or password'], 401);
            }

            // Authentication successful, return user data
            return response()->json(['user' => $user]);
        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return response()->json(['error' => 'Login failed'], 500);
        }
    }
}
