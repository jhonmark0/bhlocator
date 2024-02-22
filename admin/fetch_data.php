<?php
// Create a database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "bhlocator";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the database using a JOIN operation
$query = "SELECT o.*, b.boarding_house_name 
          FROM boarding_house_owner o
          LEFT JOIN boarding_house b ON o.owner_id = b.owner_id";

$result = $conn->query($query);

// Check if the query was successful
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td contenteditable='true'>" . $row['owner_name'] . "</td>";
        echo "<td contenteditable='true'>" . $row['boarding_house_name'] . "</td>";
        echo "<td contenteditable='true'>" . $row['contact_number'] . "</td>";
        echo "<td contenteditable='true'>" . $row['address'] . "</td>";
        echo "<td contenteditable='true'>" . $row['email_address'] . "</td>";
        echo "<td contenteditable='true'>" . $row['account_status'] . "</td>";
        echo "<td contenteditable='true'>" . $row['username'] . "</td>";
        echo "<td contenteditable='true'>" . $row['password'] . "</td>";
        echo "<td><button class='edit-update-btn' onclick='updateOwner(" . $row['owner_id'] . ")'>Update</button></td>";
        echo "<td><button onclick='deleteOwner(" . $row['owner_id'] . ")'>Delete</button></td>";
        echo "</tr>";
    }
} else {
    // Handle the case when no owners are found
    echo "<tr><td colspan='10'>No owners found</td></tr>";
}

// Close the database connection
$conn->close();
?>
