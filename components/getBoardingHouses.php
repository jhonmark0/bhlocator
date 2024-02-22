<?php
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

// Fetch data from rooms and boarding_house tables
$sql = "SELECT rooms.*, boarding_house.boarding_house_name, boarding_house.address, boarding_house.longitude, boarding_house.latitude, boarding_house.description, boarding_house.boarding_house_photo
        FROM rooms
        JOIN boarding_house ON rooms.boarding_house_id = boarding_house.boarding_house_id";
$result = $conn->query($sql);

$boardingHouses = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $boardingHouses[] = [
            'room_id' => $row['room_id'],
            'boarding_house_id' => $row['boarding_house_id'],
            'total_room' => $row['total_room'],
            'room_type' => $row['room_type'],
            'room_price' => $row['room_price'],
            'amenities' => $row['amenities'],
            'comfort_room' => $row['comfort_room'],
            'pets_allowed' => $row['pets_allowed'],
            'electricity_bill' => $row['electricity_bill'],
            'water_bill' => $row['water_bill'],
            'room_availability_status' => $row['room_availability_status'],
            'room_photos' => $row['room_photos'],
            'room_type_photos' => $row['room_type_photos'],
            'inclutions' => $row['inclutions'],
            'room_capacity' => $row['room_capacity'],
            'boarding_house_name' => $row['boarding_house_name'],
            'address' => $row['address'],
            'longitude' => $row['longitude'],
            'latitude' => $row['latitude'],
            'description' => $row['description'],
            'boarding_house_photo' => $row['boarding_house_photo'],

        ];
    }
}

$conn->close();

echo json_encode($boardingHouses);
?>
