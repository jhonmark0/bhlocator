<?php
// Connection details
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'bhlocator';

// Establish database connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the necessary parameters are set
if (isset($_GET['maxPrice'])) {
    // Sanitize and validate input (you should perform more thorough validation)
    $maxPrice = floatval($_GET['maxPrice']);
    
    // Construct the SQL query based on room type
    if (isset($_GET['roomType']) && $_GET['roomType'] !== 'NoLimit') {
        $roomType = $conn->real_escape_string($_GET['roomType']);
        $query = "SELECT bh.boarding_house_name, bh.address, bh.longitude, bh.latitude, r.room_type, r.room_price
                  FROM boarding_house bh
                  INNER JOIN rooms r ON bh.boarding_house_id = r.boarding_house_id
                  WHERE r.room_price <= $maxPrice AND r.room_type = '$roomType'";
    } else {
        $query = "SELECT bh.boarding_house_name, bh.address, bh.longitude, bh.latitude, r.room_type, r.room_price
                  FROM boarding_house bh
                  INNER JOIN rooms r ON bh.boarding_house_id = r.boarding_house_id
                  WHERE r.room_price <= $maxPrice";
    }

    // Execute the query
    $result = $conn->query($query);

    // Fetch the results into an array
    $filteredBoardingHouses = [];
    while ($row = $result->fetch_assoc()) {
        $filteredBoardingHouses[] = $row;
    }

    // Close the database connection
    $conn->close();

    // Send the results as JSON
    header('Content-Type: application/json');
    echo json_encode($filteredBoardingHouses);
} else {
    // If maxPrice parameter is not set, return an empty array or an error message
    header('Content-Type: application/json');
    echo json_encode([]);
}
?>
