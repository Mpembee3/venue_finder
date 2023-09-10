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
        $role = $row["role"];

        // Verify the provided password against the stored hashed password
        if (password_verify($password, $storedPassword)) {
            // Authentication successful
            $_SESSION["user_id"] = $row["id"]; // Store the user ID in the session
            $_SESSION["username"] = $username; // Store the username in the session
            $_SESSION["role"] = $role; // Store the user role in the session
            
            // Redirect based on user role
            if ($role == 'admin') {
                echo '
                <script>
                alert("Welcome to Venue Finder Admin.");
                window.location.href = "../admin/admin_panel.php";
                </script>';
            } elseif ($role == 'lecturer') {
                echo '
                <script>
                alert("Welcome, Lecturer.");
                window.location.href = "../admin/lecturer_dashboard.php";
                </script>';
            } elseif ($role == 'cr') {
                echo '
                <script>
                alert("Welcome, CR.");
                window.location.href = "../admin/cr_dashboard.php";
                </script>';
            } else {
                // Handle unknown roles or redirect to a default page
                echo '
                <script>
                alert("Unknown user role. Click OK to try again.");
                window.location.href = "../admin/login.php";
                </script>';
            }
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
