<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'bhlocator';

// Create a database connection
$yourDbConnection = mysqli_connect($host, $username, $password, $database);

// Check the connection
if (!$yourDbConnection) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Retrieve the boarding house name from the GET request
$boardingHouseName = $_GET['name'];

// Sanitize the input to prevent SQL injection (you might want to use prepared statements for better security)
$boardingHouseName = mysqli_real_escape_string($yourDbConnection, $boardingHouseName);

// Construct the SQL query using prepared statements
$sql = "SELECT * FROM boarding_house WHERE boarding_house_name LIKE ? LIMIT 1";
$stmt = mysqli_prepare($yourDbConnection, $sql);

// Bind the parameter
mysqli_stmt_bind_param($stmt, 's', $param_boardingHouseName);
$param_boardingHouseName = '%' . $boardingHouseName . '%';

// Execute the query
mysqli_stmt_execute($stmt);

// Get the result
$result = mysqli_stmt_get_result($stmt);

// Check if the query was successful
if ($result) {
    // Fetch the boarding house data
    $boardingHouse = mysqli_fetch_assoc($result);

    // Return the data as JSON
    header('Content-Type: application/json');
    echo json_encode($boardingHouse);
} else {
    // Return an error message as JSON
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Error fetching boarding house data']);
}

// Close the statement and database connection
mysqli_stmt_close($stmt);
mysqli_close($yourDbConnection);
?>
