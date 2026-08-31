<?php
// Database configuration
$host = 'localhost';
$dbname = 'velyora'; //
$username = 'root';  // 
$password = '';      // 
try {
    // Create a new PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Tell PDO to throw an error if something goes wrong with a query
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set default fetch mode to Associative Array (e.g., $product['name'])
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    // If connection fails, stop the page and show the error
    die("Database connection failed: " . $e->getMessage());
}
?>