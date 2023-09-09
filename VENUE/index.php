<?php include 'resources/header.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Venue Reservation</title>
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS for color scheme */
        body {
            background-color: #fff;
            color: #333;
        }
        .card {
            background-color: #f3f3f3;
            border-color: #ddd;
        }
        .card-title {
            color: #333;
            cursor: pointer; /* Add cursor pointer for clickable card title */
        }
        .btn-primary {
            background-color: #ffbf00;
            border-color: #ffbf00;
        }
        .btn-primary:hover {
            background-color: #ffcc33;
            border-color: #ffcc33;
        }
        .filter-box {
            background-color: #336699;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- <h1 class="text-center">Available Venues</h1> -->
        <!-- Venue filter options -->
        <div class="form-group filter-box p-3">
            <label for="resources" class="text-white">Filter by Resources:</label>
            <select id="resources" class="form-control">
                <option value="">All</option>
                <option value="projector">Projector</option>
                <option value="sound">Sound System</option>
                <!-- Add more resource options if needed -->
            </select>
            <label for="college" class="mt-3 text-white">Filter by College:</label>
            <select id="college" class="form-control">
                <option value="">All</option>
                <option value="coict">COICT</option>
                <option value="coet">COET</option>
                <option value="coss">COSS</option>
                <option value="conas">CONAS</option>
                <option value="main_campus">Main Campus</option>
                <option value="sjmc">SJMC</option>
                <option value="cohu">COHU</option>
                <!-- Add more college options if needed -->
            </select>
            <label for="capacity" class="mt-3 text-white">Filter by Capacity:</label>
            <input type="number" id="capacity" class="form-control" placeholder="Capacity Range" readonly>
        </div>

        <!-- Venue list -->
        <div class="row" id="venue-list">
            <!-- Venues will be dynamically added here using JavaScript -->
        </div>
    </div>

    <!-- Include Bootstrap and jQuery JavaScript from CDNs -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Function to fetch and display venues
        function displayVenues() {
            const resourceFilter = document.getElementById("resources").value;
            const collegeFilter = document.getElementById("college").value;
            const capacityFilter = document.getElementById("capacity").value;

            // Fetch venues from a PHP script and display them
            $.ajax({
                url: 'backend/fetch_venues.php',
                method: 'POST',
                data: {
                    resourceFilter: resourceFilter,
                    collegeFilter: collegeFilter,
                    capacityFilter: capacityFilter
                },
                success: function (data) {
                    // Update the venue list with the fetched data
                    $('#venue-list').html(data);
                }
            });
        }

        // Event listeners for filter changes
        $('#resources').on('change', displayVenues);
        $('#college').on('change', displayVenues);
        $('#capacity').on('input', displayVenues);

        // Event listener for clicking on venue names
        $(document).on('click', '.card-title', function () {
            // Get the venue ID from the clicked card
            const venueID = $(this).data('venue-id');
            // Redirect to the venue profile page with the venue ID as a parameter
            window.location.href = `venue/venue_profile.php?id=${venueID}`;
        });

        // Initial display of venues
        $(document).ready(function () {
            displayVenues(); // Fetch and display venues when the page loads
        });
    </script>

<?php 
    include 'resources/footer.php';?>
</body>
</html>
