<?php
$servername = "localhost"; // Change to your database server name
$username = "makilagied"; // Change to your database username
$password = "password"; // Change to your database password
$dbname = "VENUE"; // Change to your desired database name

// Create a connection to MySQL
$conn = new mysqli($servername, $username, $password);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Select the database
$conn->select_db($dbname);


// SQL query to create a "users" table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
)";

// Execute the query
if ($conn->query($sql) === TRUE) {
    echo "Table 'users' created successfully.";
} else {
    echo "Error creating table: " . $conn->error;
}


// User data
$username = "admin";
$password = password_hash("admin", PASSWORD_DEFAULT); // Hash the password

// SQL query to insert the admin user into the "users" table
$sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

// Execute the query
if ($conn->query($sql) === TRUE) {
    echo "Admin user created successfully.";
} else {
    echo "Error creating admin user: " . $conn->error;
}

// Create the venues table
$sql = "CREATE TABLE IF NOT EXISTS venues (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    capacity INT NOT NULL,
    location VARCHAR(255) NOT NULL,
    resources TEXT,
    college VARCHAR(255) NOT NULL,
    image VARCHAR(255)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'venues' created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}


// Define the SQL query to create the reservations table with a status column
$createTableSql = "CREATE TABLE IF NOT EXISTS reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venue_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    reservation_date DATE NOT NULL,
    time_slot VARCHAR(50) NOT NULL,
    comments TEXT,
    status ENUM('Pending', 'Accepted', 'Rejected') DEFAULT 'Pending', -- Add a status column
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (venue_id) REFERENCES venues(id)
)";


// Execute the SQL query to create the table
if ($conn->query($createTableSql) === TRUE) {
    echo 'Reservations table created successfully!';
} else {
    echo 'Error creating table: ' . $conn->error;
}


$conn->close();
?>
