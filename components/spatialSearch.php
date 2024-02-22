<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'bhlocator';

$yourDbConnection = mysqli_connect($host, $username, $password, $database);

if (!$yourDbConnection) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Retrieve the coordinates from the GET request
$latitude = $_GET['latitude'];
$longitude = $_GET['longitude'];

// Sanitize the input
$latitude = mysqli_real_escape_string($yourDbConnection, $latitude);
$longitude = mysqli_real_escape_string($yourDbConnection, $longitude);

// Construct the SQL query for spatial search
$sql = "SELECT * FROM boarding_house WHERE MBRContains(Point(?, ?), coordinates)";

// Prepare and bind parameters
$stmt = mysqli_prepare($yourDbConnection, $sql);
mysqli_stmt_bind_param($stmt, 'dd', $latitude, $longitude);

// Execute the query
mysqli_stmt_execute($stmt);

// Get the result
$result = mysqli_stmt_get_result($stmt);

// Check if the query was successful
if ($result) {
    // Fetch all boarding houses within the spatial boundary
    $boardingHouses = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $boardingHouses[] = $row;
    }

    // Return the data as JSON
    header('Content-Type: application/json');
    echo json_encode($boardingHouses);
} else {
    // Return an error message as JSON
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Error fetching boarding house data']);
}

// Close the statement and database connection
mysqli_stmt_close($stmt);
mysqli_close($yourDbConnection);
?>
