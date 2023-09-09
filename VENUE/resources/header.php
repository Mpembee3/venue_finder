 <style>
        /* Custom CSS for header */
        .navbar-heading {
            font-size: 24px;
            font-weight: bold;
        }

        .navbar-logo {
            max-height: 40px; /* Adjust the logo height as needed */
        }
    </style>

    <!-- Header section -->
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
                    <a class="nav-link" href="../index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admin/admin_panel.php">Admin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">CR</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Staff</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Status</a>
                </li>
                <!-- Add more navigation links as needed -->
            </ul>
        </div>
    </nav>



    <!-- Include Bootstrap and jQuery JavaScript from CDNs -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

