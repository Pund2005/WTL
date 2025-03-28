<?php
// Database connection settings
$host = "localhost";       // Change if needed (e.g., your server's IP address)
$username = "root";        // Default for XAMPP
$password = "root";            // Default for XAMPP (empty password)
$database = "inventory_db"; // Ensure your database is created

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Connection successful
// echo "Connected successfully";
?>
