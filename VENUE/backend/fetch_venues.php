<?php
require_once('db.php');

// Get filters from the index page
$resourceFilter = $_POST['resourceFilter'];
$collegeFilter = $_POST['collegeFilter'];
$capacityFilter = $_POST['capacityFilter'];

// Build the SQL query based on filters
$sql = "SELECT * FROM venues WHERE 1=1";

if (!empty($resourceFilter)) {
    $sql .= " AND resources LIKE '%$resourceFilter%'";
}

if (!empty($collegeFilter)) {
    $sql .= " AND college = '$collegeFilter'";
}

if (!empty($capacityFilter)) {
    list($minCapacity, $maxCapacity) = explode('-', $capacityFilter);
    $sql .= " AND capacity >= $minCapacity AND capacity <= $maxCapacity";
}

// Execute the query and fetch venues
$result = $conn->query($sql);

// Display venues
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="col-md-4 mb-4">';
        echo '<div class="card">';
        echo '<img src="' . $row['image'] . '" class="card-img-top" alt="' . $row['name'] . '">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title" data-venue-id="' . $row['id'] . '" data-toggle="tooltip" data-placement="top" title="Click here to view profile">' . $row['name'] . '</h5>';
         echo '<p class="card-text">' . $row['description'] . '</p>';
        echo '<ul>';
        echo '<li>Capacity: ' . $row['capacity'] . '</li>';
        // echo '<li>Location: ' . $row['location'] . '</li>';
        echo '<li>Resources: ' . $row['resources'] . '</li>';
        echo '<li>College: ' . $row['college'] . '</li>';
        echo '</ul>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo 'No venues found';
}

$conn->close();
?>
