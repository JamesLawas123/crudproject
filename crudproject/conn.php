<?php
// Database configuration
$host = "localhost";     // Your database host
$dbname = "crudproject";    // Your database name
$username = "root";    // Your database username
$password = "";    // Your database password

try {
    // Create PDO connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Optional: Set character set to UTF-8
    $conn->exec("SET NAMES 'utf8'");
    
} catch(PDOException $e) {
    // Handle connection error
    die("Connection failed: " . $e->getMessage());
}
?>
