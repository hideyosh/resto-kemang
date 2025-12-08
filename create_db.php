<?php
// Create database connection without specifying database
$conn = new mysqli("127.0.0.1", "root", "", null, 3306);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS resto_kemang";
if ($conn->query($sql) === TRUE) {
    echo "Database created or already exists successfully\n";
} else {
    echo "Error creating database: " . $conn->error . "\n";
}

$conn->close();
?>
