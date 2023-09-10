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


// SQL query to create a "users" table with assigned_classes field
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'lecturer', 'cr') NOT NULL,
    assigned_classes VARCHAR(255) NOT NULL,
    UNIQUE KEY (username)
)";

// Execute the query
if ($conn->query($sql) === TRUE) {
    echo "Table 'users' created successfully.<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// User data
$adminUsername = "admin";
$adminPassword = password_hash("admin", PASSWORD_DEFAULT); // Hash the password
$lecturerUsername = "lecturer";
$lecturerPassword = password_hash("venue", PASSWORD_DEFAULT); // Hash the password
$crUsername = "cr";
$crPassword = password_hash("venue", PASSWORD_DEFAULT); // Hash the password

// Assign roles and classes
$adminRole = "admin";
$lecturerRole = "lecturer";
$crRole = "cr";
$lecturerClasses = "workshop,seminar,lecture,meeting";
$crClasses = "lecture,workshop";

// SQL query to insert users into the "users" table
$sql = "INSERT INTO users (username, password, role, assigned_classes)
        VALUES
        ('$adminUsername', '$adminPassword', '$adminRole', ''),
        ('$lecturerUsername', '$lecturerPassword', '$lecturerRole', '$lecturerClasses'),
        ('$crUsername', '$crPassword', '$crRole', '$crClasses')";

// Execute the query
if ($conn->query($sql) === TRUE) {
    echo "Users created successfully.";
} else {
    echo "Error creating users: " . $conn->error;
}

// Create the venues table with location columns
$sql = "CREATE TABLE IF NOT EXISTS venues (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    capacity INT NOT NULL,
    latitude DECIMAL(10, 6) NOT NULL, -- Column for latitude (up to 6 decimal places)
    longitude DECIMAL(10, 6) NOT NULL, -- Column for longitude (up to 6 decimal places)
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
    identification VARCHAR(255) NOT NULL,
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


// SQL statement to create the timetable table
$createTableSql = "CREATE TABLE IF NOT EXISTS timetable (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venue_id INT NOT NULL,
    day VARCHAR(255) NOT NULL,
    time_slot VARCHAR(255) NOT NULL,
    activity TEXT,
    venue_name VARCHAR(255) NOT NULL
)";

// Check if the table creation was successful
if ($conn->query($createTableSql) === TRUE) {
    echo "Timetable table created successfully\n";
} else {
    echo "Error creating timetable table: " . $conn->error;
    exit();
}

// Days of the week
$daysOfWeek = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];

// Time slots
$timeSlots = [
    "08:00 AM - 09:00 AM",
    "09:00 AM - 10:00 AM",
    "10:00 AM - 11:00 AM",
    "11:00 AM - 12:00 PM",
    "12:00 PM - 01:00 PM",
    "02:00 PM - 03:00 PM",
    "03:00 PM - 04:00 PM",
    "04:00 PM - 05:00 PM",
    "05:00 PM - 06:00 PM",
    "06:00 PM - 07:00 PM",
    "07:00 PM - 08:00 PM",
];

// Random activities and venue names
$activities = ["Lecture", "Meeting", "Workshop", "Seminar", "Free"];
$venueNames = ["Luhanga", "Nkurumah", "Dlab", "Yombo", "Library"];

// Populate the timetable with random data for a week
foreach ($daysOfWeek as $day) {
    foreach ($timeSlots as $timeSlot) {
        // Randomly select an activity and venue name
        $activity = $activities[array_rand($activities)];
        $venueName = $venueNames[array_rand($venueNames)];

        // Insert the data into the timetable table
        $insertSql = "INSERT INTO timetable (venue_id, day, time_slot, activity, venue_name)
                      VALUES (1, '$day', '$timeSlot', '$activity', '$venueName')";

        if ($conn->query($insertSql) === TRUE) {
            echo "Inserted data for $day, $timeSlot\n";
        } else {
            echo "Error inserting data: " . $conn->error;
        }
    }
}





$conn->close();
?>
