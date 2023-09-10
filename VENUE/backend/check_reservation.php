<?php
session_start(); // Start the session if not already started
require_once('db.php'); // Include the database connection file (db.php)

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $name = $_POST["name"];
    $email = $_POST["email"];

    // Define a SQL query to check the reservation status based on name and email
    $checkReservationSql = "SELECT * FROM reservations WHERE name = '$name' AND email = '$email'";

    // Execute the SQL query
    $result = $conn->query($checkReservationSql);

    if ($result->num_rows > 0) {
        // Reservation found, display details
        $reservation = $result->fetch_assoc();
        echo "<h2>Your Reservation Details:</h2>";
        echo "Venue: " . $reservation['venue_id'] . "<br>";
        echo "Reservation Date: " . $reservation['reservation_date'] . "<br>";
        echo "Time Slot: " . $reservation['time_slot'] . "<br>";
        echo "Status: " . $reservation['status'] . "<br>";
        // Display other reservation details as needed
    } else {
        // No reservation found
        echo "<h2>No Reservation Found</h2>";
    }

    // Close the database connection
    $conn->close();
}
?>
