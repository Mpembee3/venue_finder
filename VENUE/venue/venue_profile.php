<?php
require_once('../backend/db.php');
include '../resources/header.php'; 

// Get venue ID from the URL parameter
$venueID = $_GET['id'];

// Query to retrieve venue details based on the ID
$sql = "SELECT * FROM venues WHERE id = $venueID";

// Execute the query
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $venue = $result->fetch_assoc();
    // Venue details are available here
    $name = $venue['name'];
    $description = $venue['description'];
    $capacity = $venue['capacity'];
    $location = $venue['location'];
    $resources = $venue['resources'];
    $college = $venue['college'];
    $image = $venue['image'];
} else {
    // Venue not found with the provided ID
    $name = "Venue not found";
    $description = "The requested venue does not exist.";
    $capacity = "";
    $location = "";
    $resources = "";
    $college = "";
    $image = "";
}

// Sample data for the weekly timetable
$sampleWeekTimetable = [
    [
        'day' => 'Monday',
        'time_slot' => '08:00 AM - 09:00 AM',
        'activity' => 'CS174 - Introduction to Programming',
    ],
    [
        'day' => 'Tuesday',
        'time_slot' => '10:00 AM - 12:00 PM',
        'activity' => 'MATH101 - Calculus',
    ],
    // Add more sample data as needed
];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venue Profile</title>
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS for color scheme */
        body {
            background-color: #fff;
            color: #333;
        }
        .card {
            background-color: #f3f3f3;
            border-color: #ddd;
        }
        .card-title {
            color: #333;
        }
        .btn-primary {
            background-color: #ffbf00;
            border-color: #ffbf00;
        }
        .btn-primary:hover {
            background-color: #ffcc33;
            border-color: #ffcc33;
        }
        /* Style for inline content */
        .inline-content {
            vertical-align: top;
            margin-right: 20px;
        }
    </style>
</head>
<!-- ... Previous code ... -->

<body>
    <div class="container mt-5">
        <h1 class="text-center">Venue Profile</h1>
        <div class="card">
            <img src="<?php echo $image; ?>" class="card-img-top" alt="<?php echo $name; ?>">
            <!-- Add a Google Maps link with coordinates and an icon -->
<div class="card-body">
    <h5 class="card-title"><?php echo $name; ?></h5>
    <p class="card-text"><?php echo $description; ?></p>
    <ul>
        <li>Capacity: <?php echo $capacity; ?></li>
        <li>Location: <?php echo $location; ?></li>
        <li>Resources: <?php echo $resources; ?></li>
        <li>College: <?php echo $college; ?></li>
    </ul>
    <!-- Add a Google Maps link with coordinates and an icon -->
    <div class="row">
        <div class="col-md-6">
            <a href="https://www.google.com/maps?q=<?php echo $latitude; ?>,<?php echo $longitude; ?>" target="_blank" class="btn btn-info">
                <i class="fa fa-map-marker"></i> View on Google Maps
            </a>
        </div>
        <div class="col-md-6">
            <!-- Button to request venue reservation -->
            <button class="btn btn-primary" id="reservationBtn">Request Reservation</button>
        </div>
    </div>
</div>

        <!-- Table to show detailed week timetable -->
        <h2 class="mt-4">Detailed Week Timetable</h2>
        <div class="row">
            <?php
            foreach ($sampleWeekTimetable as $entry) {
                echo '<div class="col-md-4">';
                echo '<div class="card inline-content h-100">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $entry['day'] . '</h5>';
                echo '<p class="card-text">' . $entry['time_slot'] . '</p>';
                echo '<p class="card-text">' . $entry['activity'] . '</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>

        <!-- User Comments / Ratings Section -->
        <div class="card mt-4">
            <div class="card-header">
                User Comments and Ratings
            </div>
            <div class="card-body">
                <!-- Add a form for users to submit comments or ratings -->
                <form>
                    <div class="form-group">
                        <label for="userComment">Write a Comment:</label>
                        <textarea class="form-control" id="userComment" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="userRating">Rate this Venue:</label>
                        <select class="form-control" id="userRating">
                            <option value="1">1 (Terrible)</option>
                            <option value="2">2 (Poor)</option>
                            <option value="3">3 (Average)</option>
                            <option value="4">4 (Good)</option>
                            <option value="5">5 (Excellent)</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

                <!-- Display user comments and ratings here (if available) -->
            </div>
        </div>
    </div>

    <!-- Include Bootstrap and jQuery JavaScript from CDNs -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Event listener for the reservation button
        $('#reservationBtn').on('click', function () {
            // Redirect to the reservation form page with venue ID as a parameter
            window.location.href = `reservation_form.php?venueID=<?php echo $venueID; ?>`;
        });
    </script>
</body>
</html>

