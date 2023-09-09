<?php
session_start(); // Start the session
require_once('db.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check username and password
    $username = $_POST["username"];
    $password = $_POST["password"];

    // SQL query to retrieve user data based on the provided username
    $sql = "SELECT * FROM users WHERE username = '$username'";

    // Execute the query
    $result = $conn->query($sql);

    // Check if a user with the provided username exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedPassword = $row["password"];

        // Verify the provided password against the stored hashed password
        if (password_verify($password, $storedPassword)) {
            // Authentication successful
            $_SESSION["user_id"] = $row["id"]; // Store the user ID in the session
            // Redirect to the admin panel or another page
            echo '
            <script>
            alert("Welcome to Venu Finder Admin.");
            window.location.href = "../admin/admin_panel.php";
            </script>';
            exit;
        } else {
            // Authentication failed (incorrect password)
            echo '
            <script>
            alert("Wrong Password. Click OK to try again.");
            window.location.href = "../admin/login.php";
            </script>';
            exit;
        }
    } else {
        // Authentication failed (user not found)
        echo '
        <script>
        alert("User not found. Click OK to try again.");
        window.location.href = "../admin/login.php";
        </script>';
        exit;
    }
}
?>
