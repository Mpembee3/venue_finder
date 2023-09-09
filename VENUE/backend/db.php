<?php
$servername = "localhost"; // Change to your database server name
$username = "makilagied"; // Change to your database username
$password = "password"; // Change to your database password
$dbname = "VENUE"; // Change to your desired database name

// Create a connection to MySQL
$conn = new mysqli($servername, $username, $password,$dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>