<?php
// Database connection for AR Food
// Update these values if your MySQL credentials are different.

$DB_HOST = 'localhost';
$DB_USER = 'root'; // XAMPP default user
$DB_PASS = '';// XAMPP default has empty password
$DB_NAME = 'arfood_db';

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($conn->connect_error) {
    // For production you may want to log this instead of showing it
    http_response_code(500);
    die('Database connection failed: ' . $conn->connect_error);
}

// Ensure we use UTF-8
$conn->set_charset('utf8mb4');
