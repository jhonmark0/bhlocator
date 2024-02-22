<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bhlocator";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the search query from the AJAX request
$query = $_GET['query'];

// Fetch suggestions from the database
$sql = "SELECT name FROM boarding_houses WHERE name LIKE '%$query%'";
$result = $conn->query($sql);

// Store suggestions in an array
$suggestions = [];
while ($row = $result->fetch_assoc()) {
    $suggestions[] = $row['name'];
}

// Close the database connection
$conn->close();

// Output the suggestions as JSON
header('Content-Type: application/json');
echo json_encode($suggestions);
?>
