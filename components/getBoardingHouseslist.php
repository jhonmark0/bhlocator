<?php
// Assuming you have a MySQL database connection
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

// SQL query to fetch boarding houses along with owner and room details
$sql = "SELECT b.*, o.owner_id, o.owner_name, o.address AS owner_address, o.username AS owner_username, o.password AS owner_password, o.contact_number AS contact_number, o.email_address AS owner_email_address, r.room_id, r.total_room, r.room_type, r.room_price, r.amenities, r.comfort_room, r.pets_allowed, r.electricity_bill, r.water_bill, r.room_availability_status, CONCAT('images/', b.boarding_house_photo) AS boarding_house_photo, CONCAT('images/', r.room_photos) AS room_photos
        FROM boarding_house b
        LEFT JOIN boarding_house_owner o ON b.owner_id = o.owner_id
        LEFT JOIN rooms r ON b.boarding_house_id = r.boarding_house_id";

$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Fetch the results and encode them as JSON
    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    echo json_encode($rows);
} else {
    echo "No data found";
}

// Close the connection
$conn->close();
?>
