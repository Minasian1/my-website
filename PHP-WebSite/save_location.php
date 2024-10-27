<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection
    $conn = new mysqli("localhost", "root", "", "php-website");
}
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $message = $_POST['message'];

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if file is an actual image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
if ($check !== false) {
    $uploadOk = 1;
} else {
    echo "File is not an image.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) { // limit to 5MB
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {
    // if everything is okay, try to upload file
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
    }


        $stmt = $conn->prepare("INSERT INTO `nfs_fans` (`latitude`, `longitude`, `message`, `file_path`) 
    VALUES ('$latitude', '$longitude', '$message', '$target_file')");

    $stmt->execute();

    $stmt->close();
    $conn->close();

    header("Location: contacts.html");
}

