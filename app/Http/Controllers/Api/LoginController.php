<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

require_once __DIR__ . '/../../../../api/database_connection.php';

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

		// Establish connection to Supabase database
		$conn = connectToSupabase();

        // Prepare and execute query to authenticate user
        $query = "SELECT * FROM users WHERE email = $1 LIMIT 1";
        $result = pg_query_params($conn, $query, [$email]);

        if (!$result) {
            die("Error executing query");
        }

        $user = pg_fetch_assoc($result);

        if (!$user || !password_verify($password, $user['password'])) {
            return response()->json(['error' => 'Invalid email or password'], 401);
        }

        // Authentication successful, return user data or JWT token
        return response()->json(['user' => $user]);
    }
}
