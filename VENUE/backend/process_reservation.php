<?php
// Include the database connection file (db.php)
require_once('../backend/db.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $venueID = $_POST['venueID'];
    $name = $_POST['name'];
    $identity=$_POST['identity'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $comments = $_POST['comments'];

    // You should perform validation on the data here to ensure it meets your requirements.

    // Insert reservation data into the database
    $insertSql = "INSERT INTO reservations (venue_id, name, identification, email, reservation_date, time_slot, comments)
                  VALUES ('$venueID', '$name', '$identity','$email', '$date', '$time', '$comments')";

    if ($conn->query($insertSql) === TRUE) {
        // Reservation data inserted successfully
        echo '
            <script>
            alert("Venue Reserved. Click OK to continue.");
            window.location.href = "../index.php";
            </script>';   } else {
        // Error occurred while inserting data
        echo 'Error: ' . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // Redirect back to the reservation form if the form is not submitted
    header('Location: ../venue/reservation_form.php');
    exit();
}
?>
