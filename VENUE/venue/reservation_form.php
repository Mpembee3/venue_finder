<?php
include '../resources/header.php'; 

// Check if the venueID parameter is set in the URL
if (!isset($_GET['venueID'])) {
    echo 'Venue ID is missing.';
    exit();
}

$venueID = $_GET['venueID'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Form</title>
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS for color scheme */
        body {
            background-color: #fff;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
        }
        .btn-primary {
            background-color: #ffbf00;
            border-color: #ffbf00;
        }
        .btn-primary:hover {
            background-color: #ffcc33;
            border-color: #ffcc33;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Venue Reservation Request</h1>
        <form action="../backend/process_reservation.php" method="POST">
            <input type="hidden" name="venueID" value="<?php echo $venueID; ?>">

            <div class="form-group">
                <label for="name">Your Name:</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Full Name" required>
            </div>
            
            <div class="form-group">
                <label for="name">Identification Number:</label>
                <input type="text" class="form-control" id="name" name="identity" placeholder="NIN or Student ID or Staff ID " required>
            </div>

            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="mail@web.com" required>
            </div>

            <div class="form-group">
                <label for="date">Reservation Date:</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>

            <div class="form-group">
                <label for="time">Preferred Time Slot:</label>
                <input type="time" class="form-control" id="time" name="time" required>
            </div>

            <div class="form-group">
                <label for="comments">Additional Comments:</label>
                <textarea class="form-control" id="comments" name="comments" rows="4" placeholder="Describe Your request For further Considerations" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Submit Reservation Request</button>
        </form>
    </div>

    <!-- Include Bootstrap and jQuery JavaScript from CDNs -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
