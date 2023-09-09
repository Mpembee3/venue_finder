<?php
session_start(); // Start the session
session_destroy(); // Destroy all session data

// Redirect the user to the login page after logout
header("Location: ../admin/login.php");
exit;
?>
