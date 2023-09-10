<?php
session_start(); // Start the session

// Check if the user is authenticated
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php"); // Redirect to the login page if not logged in
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-ezFmnxlFfV3ITkupjK5fLFE9pT6aGfGfx2Cp4u9S8ea4K4Kj0UxHU8f5DlsFUHzvx" crossorigin="anonymous">
 <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS for styling the admin panel */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .card-container {
            display: inline-block; /* Display cards in inline-block layout */
            vertical-align: top; /* Align cards to the top */
            margin-right: 20px; /* Add space between cards */
            margin-bottom: 20px; /* Add space between rows of cards */
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            width: 300px; /* Set a fixed width for cards */
        }
        .card:hover {
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
        }
        .card-header {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .card-body {
            padding: 15px;
        }
        .card-title {
            font-size: 20px;
            margin-bottom: 10px;
            color: #333;
        }
        .card-text {
            font-size: 16px;
            color: #666;
        }
        .action-buttons {
            text-align: right;
            margin-top: 10px;
        }
        .btn-accept {
            background-color: #28a745;
            color: #fff;
        }
        .btn-reject {
            background-color: #dc3545;
            color: #fff;
        }
         /* Custom CSS for header */
         .navbar-heading {
            font-size: 24px;
            font-weight: bold;
        }

        .navbar-logo {
            max-height: 40px; /* Adjust the logo height as needed */
        }
    </style>
</head>
<body>
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
                <a class="nav-link" href="../index.php">
                    <i class="fas fa-home"></i> Home
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../admin/admin.php">
                    <i class="fas fa-plus"></i> Register Venue
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../admin/admin_panel.php">
                    <i class="fas fa-calendar-alt"></i> Reservations
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../backend/logout.php">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
            <!-- Add more navigation links as needed -->
        </ul>
    </div>
</nav>
    <div class="container">
        <h1>Reservation Requests</h1>
        <!-- Fetch and display reservation requests from the database here -->
        <?php
        // Include the database connection file (db.php)
        require_once('../backend/db.php');

        // Define a SQL query to retrieve reservation requests with venue names
        $reservationSql = "SELECT reservations.*, venues.name AS venue_name 
                           FROM reservations 
                           JOIN venues ON reservations.venue_id = venues.id
                           WHERE reservations.status = 'pending'";

        // Execute the SQL query
        $result = $conn->query($reservationSql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card-container">';
                echo '<div class="card">';
                echo '<div class="card-header">Request ID: ' . $row['id'] . '</div>';
                echo '<div class="card-body">';
                echo '<div class="card-title">Venue: ' . $row['venue_name'] . '</div>';
                echo '<div class="card-text">Name: ' . $row['name'] . '</div>';
                echo '<div class="card-text">Email: ' . $row['email'] . '</div>';
                echo '<div class="card-text">Reservation Date: ' . $row['reservation_date'] . '</div>';
                echo '<div class="card-text">Time Slot: ' . $row['time_slot'] . '</div>';
                echo '<div class="card-text">Comments: ' . $row['comments'] . '</div>';
                echo '<div class="card-text">Created At: ' . $row['created_at'] . '</div>';
                echo '<div class="action-buttons">';
                // Add buttons for accepting and rejecting requests
                echo '<button class="btn btn-accept" onclick="acceptRequest(' . $row['id'] . ')">Accept</button>';
                echo '<button class="btn btn-reject" onclick="rejectRequest(' . $row['id'] . ')">Reject</button>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo '<div class="card-text">No reservation requests found.</div>';
            echo '</div>';
            echo '</div>';
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>

    <!-- Include Bootstrap and jQuery JavaScript from CDNs -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Add this JavaScript code to your HTML file -->
<script>
// JavaScript functions to handle accepting and rejecting requests
function acceptRequest(requestId) {
    // Send an AJAX request to your backend to accept the request
    $.post('../backend/accept_request.php', { requestId: requestId }, function(response) {
        if (response.success) {
            // Request accepted successfully
            // Reload the card or update the UI as needed
            location.reload(); // Reload the page to reflect changes
        } else {
            // Handle error
            console.error('Error accepting request:', response.error);
        }
    });
}

function rejectRequest(requestId) {
    // Send an AJAX request to your backend to reject the request
    $.post('../backend/reject_request.php', { requestId: requestId }, function(response) {
        if (response.success) {
            // Request rejected successfully
            // Reload the card or update the UI as needed
            location.reload(); // Reload the page to reflect changes
        } else {
            // Handle error
            console.error('Error rejecting request:', response.error);
        }
    });
}

</script>

</body>
</html>
