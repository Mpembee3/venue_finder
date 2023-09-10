<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $name = $_POST["name"];
    $capacity = $_POST["capacity"];
    $description = $_POST["description"];
    // $location = $_POST["location"];
    $resources = $_POST["resources"];
    $college = $_POST["college"];
    
    // Capture latitude and longitude from user input
    $latitude = $_POST["latitude"];
    $longitude = $_POST["longitude"];
    
    // File upload code
    $targetDirectory = "../img/"; // Directory where you want to store uploaded images
    $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if the file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, the file already exists.";
        $uploadOk = 0;
    }

    // Check file size (adjust to your requirements)
    if ($_FILES["image"]["size"] > 1000000) { // 1 MB
        echo "Sorry, the file is too large.";
        $uploadOk = 0;
    }

    // Allow only certain image file formats (e.g., you can customize this)
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your image was not uploaded.";
    } else {
        // Move the uploaded image to the target directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            // Insert data into the database (you should customize this part according to your database structure)
            require_once('db.php');

            // Prepare an INSERT statement (you should use prepared statements for security)
            $sql = "INSERT INTO venues (name, capacity, description, latitude, longitude, resources, college, image)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sissdsss", $name, $capacity, $description, $latitude, $longitude, $resources, $college, $targetFile);

            if ($stmt->execute()) {
                echo "Venue added successfully.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $stmt->close();
            $conn->close();
        } else {
            echo "Sorry, there was an error uploading your image.";
        }
    }
}

?>
