<?php
// Database configuration
$host = 'localhost';    // Host of the database server
$dbname = 'eli_sweet';   // Database name
$username = 'root';      // Database username
$password = '';      // Leave password empty if there is none

try {
    // Set DSN (Data Source Name)
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

    // Create a PDO instance (this is the connection)
    $pdo = new PDO($dsn, $username, $password);

    // Set PDO error mode to exception for error handling
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // If the connection is successful, display a message
    echo "Database connected successfully.";
} catch (PDOException $e) {
    // If connection fails, display the error message
    echo "Connection failed: " . $e->getMessage();
}
?>
