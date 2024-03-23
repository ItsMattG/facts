<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

require_once __DIR__ . '/../../../../api/database_connection.php';

class UserController extends Controller
{
    public function register(Request $request)
    {
        // Validate request data (if necessary)
        $validatedData = $request->validate([
            'username' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

		// Hash the password
		$hashedPassword = Hash::make($validatedData['password']);

        // Establish connection to Supabase database
        $conn = connectToSupabase();

        if (!$conn) {
            return response()->json(['error' => 'Failed to connect to database'], 500);
        }

        // Insert user data into users table
        $query = "INSERT INTO users (username, email, password) VALUES ($1, $2, $3)";
        $result = pg_query_params($conn, $query, [
            $validatedData['username'],
            $validatedData['email'],
			$hashedPassword,
        ]);

        // Check if the query was successful
        if ($result) {
            // User registration successful
            pg_close($conn); // Close the database connection
            return response()->json(['message' => 'User registered successfully']);
        } else {
            // User registration failed
            pg_close($conn); // Close the database connection
            return response()->json(['error' => 'User registration failed'], 500);
        }
    }
}
