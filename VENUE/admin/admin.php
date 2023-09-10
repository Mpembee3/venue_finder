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
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-ezFmnxlFfV3ITkupjK5fLFE9pT6aGfGfx2Cp4u9S8ea4K4Kj0UxHU8f5DlsFUHzvx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS for styling the admin panel */
        body {
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
        }
        label {
            font-weight: bold;
        }
        .form-group {
            margin-bottom: 15px;
        }
        input[type="text"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 5px; /* Reduced padding */
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="file"] {
            margin-bottom: 15px;
        }
        input[type="submit"] {
            background-color: #ffbf00;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #ffcc33;
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
        <h1>Add Venue</h1>
        <form action="../backend/add_venue.php" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="capacity">Capacity:</label>
                        <input type="number" id="capacity" name="capacity" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" class="form-control" required></textarea>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="location">Location:</label>
                        <input type="text" id="location" name="latitude" class="form-control" placeholder="Latitude" required>
                        <input type="text" id="location" name="longitude" class="form-control" placeholder="Longitude" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="resources">Resources:</label>
                        <select id="resources" name="resources" class="form-control">
                            <option value="">None</option>
                            <option value="projector">Projector</option>
                            <option value="sound">Sound System</option>
                            <option value="sound system and projector">Sound system and Projector</option>
                            <option value="No installed devices">No Installed PRE-DEVICES</option>
                            <!-- Add more resource options if needed -->
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="college">College:</label>
                        <select id="college" name="college" class="form-control">
                            <option value="">Select College</option>
                            <option value="coict">COICT</option>
                            <option value="coet">COET</option>
                            <option value="coss">COSS</option>
                            <option value="conas">CONAS</option>
                            <option value="main_campus">Main Campus</option>
                            <option value="sjmc">SJMC</option>
                            <option value="cohu">COHU</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image">Upload Image:</label>
                        <input type="file" id="image" name="image" class="form-control-file" required  >
                    </div>
                </div>
            </div>
            <div class="form-group">
                <input type="submit" value="Add Venue" class="btn btn-primary">
            </div>
        </form>
    </div>
</body>
</html>
