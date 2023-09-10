<?php
session_start(); // Start the session if not already started
require_once('../backend/db.php'); // Include the database connection file (db.php)

// Initialize variables to store reservation information
$venue = '';
$reservationDate = '';
$timeSlot = '';
$status = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $name = $_POST["name"];
    $email = $_POST["email"];

    // Define a SQL query to check the reservation status based on name and email
    $checkReservationSql = "SELECT r.*, v.name AS venue_name FROM reservations r
    LEFT JOIN venues v ON r.venue_id = v.id
    WHERE r.name = '$name' AND r.email = '$email'";

    // Execute the SQL query
    $result = $conn->query($checkReservationSql);

    if ($result->num_rows > 0) {
        // Reservation found, fetch details
        $reservation = $result->fetch_assoc();
        $venue = $reservation['venue_name'];
        $reservationDate = $reservation['reservation_date'];
        $timeSlot = $reservation['time_slot'];
        $status = $reservation['status'];
        // You can fetch other reservation details as needed

        // Close the database connection
        $conn->close();
    } else {
        // No reservation found
        $status = 'No Reservation Found';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Status Checker</title>

    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Custom CSS for styling -->
    <style>
        /* Custom CSS for header */
        .navbar-heading {
            font-size: 24px;
            font-weight: bold;
        }

        .navbar-logo {
            max-height: 40px; /* Adjust the logo height as needed */
        }

        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        .reservation-info {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Header section -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="../index.php">
            <img src="../img/logo_ud.png" alt="Logo" class="navbar-logo"> <!-- Replace 'your-logo.png' with your logo image URL -->
        </a>
        <span class="navbar-heading">UDSM Venue Finder</span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tooltip" data-placement="top" title="For registered users only" href="../admin/admin_panel.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tooltip" data-placement="top" title="Click here to view your reservation request status" href="status.php">Status</a>
                </li>
                <!-- Add more navigation links as needed -->
            </ul>
        </div>
    </nav>
    <div class="container">
        <h1>Reservation Status Checker</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Check Reservation</button>
        </form>

        <!-- Display reservation information -->
        <div class="reservation-info">
            <?php
            if (!empty($status)) {
                echo "<h2>$status</h2>";
                if ($status !== 'No Reservation Found') {
                    echo "<p>Venue: $venue</p>";
                    echo "<p>Reservation Date: $reservationDate</p>";
                    echo "<p>Time Slot: $timeSlot</p>";
                    // Display other reservation details as needed
                }
            }
            ?>
        </div>
    </div>

    <!-- Add Bootstrap and jQuery JavaScript from CDNs -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
