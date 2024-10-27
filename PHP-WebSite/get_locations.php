<?php
// Database connection
$mysqli = new mysqli("localhost", "root", "", "php-website");

// Check connection
if ($mysqli->connect_errno) {
    echo json_encode(["error" => "Failed to connect to the database: " . $mysqli->connect_error]);
    exit();
}

// Query to get locations
$query = "SELECT latitude, longitude, message, file_path FROM `nfs_fans`";
$result = $mysqli->query($query);

// Check if the query was successful
if (!$result) {
    echo json_encode(["error" => "Error executing query: " . $mysqli->error]);
    exit();
}

// Prepare the data array
$locations = [];
while ($row = $result->fetch_assoc()) {
    // Ensure latitude and longitude are valid numbers
    if (is_numeric($row['latitude']) && is_numeric($row['longitude'])) {
        $locations[] = [
            'lat' => (float) $row['latitude'],
            'lng' => (float) $row['longitude'],
            'message' => $row['message'],
            'fileToUpload' => $row['file_path'] // Path to the image for popups
        ];
    } else {
        error_log("Invalid lat/lng: " . json_encode($row)); // Optional: log invalid data for debugging
    }
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($locations);

$mysqli->close();