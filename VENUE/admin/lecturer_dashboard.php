<?php
session_start(); // Start the session
require_once('../backend/db.php'); // Include your database connection

// Check if the user is logged in and has the role 'lecturer'
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "lecturer") {
    header("Location: login.php"); // Redirect to login page if not logged in or not a lecturer
    exit();
}

// Retrieve the assigned classes for the lecturer from the database
$username = $_SESSION["username"];
$sql = "SELECT assigned_classes FROM users WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $assignedClasses = explode(",", $row["assigned_classes"]);
} else {
    $assignedClasses = [];
}

// Retrieve the timetable entries for the lecturer's assigned classes
$timetableEntries = [];
foreach ($assignedClasses as $class) {
    $sql = "SELECT * FROM timetable WHERE activity = '$class'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $timetableEntries[] = $row;
        }
    }
}

// Function to update the activity to "Free" for a given timetable entry ID
function markAsFree($entryId) {
    global $conn;
    
    $sql = "UPDATE timetable SET activity = 'Free' WHERE id = $entryId";
    
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Check if a form is submitted to mark an entry as "Free"
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["mark_as_free"])) {
    $entryId = $_POST["entry_id"];
    if (markAsFree($entryId)) {
        echo "Activity marked as Free successfully.";
    } else {
        echo "Error marking activity as Free.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Dashboard</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Add your custom CSS -->
    <style>
        body {
            padding: 20px;
        }
        h1 {
            margin-bottom: 20px;
        }
        .assigned-classes {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .mark-as-free-btn {
            background-color: #ffbf00;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .mark-as-free-btn:hover {
            background-color: #ffcc33;
        }
    </style>
</head>
<body>
    <h1>Lecturer Dashboard</h1>
    
    <h2>Assigned Classes</h2>
    <ul class="assigned-classes">
        <?php foreach ($assignedClasses as $class) : ?>
            <li><?= $class ?></li>
        <?php endforeach; ?>
    </ul>
    
    <h2>Timetable for Assigned Classes</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Day</th>
                <th>Time Slot</th>
                <th>Activity</th>
                <th>Venue</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($timetableEntries as $entry) : ?>
                <tr>
                    <td><?= $entry["day"] ?></td>
                    <td><?= $entry["time_slot"] ?></td>
                    <td><?= $entry["activity"] ?></td>
                    <td><?= $entry["venue_name"] ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="entry_id" value="<?= $entry["id"] ?>">
                            <button type="submit" name="mark_as_free" class="mark-as-free-btn">Mark as Free</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <!-- Add your dashboard content here -->
    
    <!-- Add Bootstrap and jQuery JavaScript from CDNs -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

