<?php

require_once 'database_connection.php';


function createUsersTable() {
	$conn = connectToSupabase();

    $query = "
        CREATE TABLE IF NOT EXISTS users (
            id SERIAL PRIMARY KEY,
            username VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ";

    $result = pg_query($conn, $query);
    if (!$result) {
        die("Error creating users table: " . pg_last_error($conn));
    }

    echo "Users table created successfully";
}

// createUsersTable();
