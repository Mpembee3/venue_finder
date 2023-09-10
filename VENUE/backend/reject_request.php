<?php
// Include the database connection file (db.php)
require_once('db.php');

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the request ID from the POST data
    $requestId = $_POST["requestId"];

    // Perform the rejection logic (modify as needed)
    // For example, you can update the status of the request in your database
    $updateSql = "UPDATE reservations SET status = 'Rejected' WHERE id = $requestId";

    if ($conn->query($updateSql) === TRUE) {
        // Success response
        $response = [
            'success' => true,
            'message' => 'Request rejected successfully',
        ];
    } else {
        // Error response
        $response = [
            'success' => false,
            'message' => 'Error rejecting request: ' . $conn->error,
        ];
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);

    // Close the database connection
    $conn->close();
} else {
    // Invalid request method
    http_response_code(405);
    echo 'Method Not Allowed';
}
?>
