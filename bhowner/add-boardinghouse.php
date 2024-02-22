<?php
session_start(); // Start the session to store user information

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "bhlocator";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Your existing code for form submission

    $owner_id = isset($_SESSION['owner_id']) ? $_SESSION['owner_id'] : '';

    $boarding_house_name = isset($_POST['boarding_house_name']) ? $_POST['boarding_house_name'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $longitude = isset($_POST['longitude']) ? $_POST['longitude'] : '';
    $latitude = isset($_POST['latitude']) ? $_POST['latitude'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';

    // Handle file uploads
    $boardingHousePhoto = uploadPhoto('boarding_house_photo', '../images/');
    $roomPhoto = uploadPhoto('room_photos', '../images/room_photos/');
    $roomTypePhoto = uploadPhoto('room_type_photos', '../images/room_type_photos/');

    // Additional validation and sanitation if needed

    $stmt = $conn->prepare("INSERT INTO boarding_house (owner_id, boarding_house_name, address, longitude, latitude, description, boarding_house_photo) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssss", $owner_id, $boarding_house_name, $address, $longitude, $latitude, $description, $boardingHousePhoto);

    if ($stmt->execute()) {
        // Insert into rooms table or other related tables as needed
        // Use the boarding_house_id from the inserted boarding_house record

        $boarding_house_id = $stmt->insert_id;

        // Insert room details into the rooms table
        $stmt = $conn->prepare("INSERT INTO rooms (boarding_house_id, total_room, room_type, room_price, amenities, comfort_room, pets_allowed, electricity_bill, water_bill, room_availability_status, room_photos, room_type_photos, inclutions, room_capacity) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iisdsisssisssi", $boarding_house_id, $total_room, $room_type, $room_price, $amenities, $comfort_room, $pets_allowed, $electricity_bill, $water_bill, $room_availability_status, $roomPhoto, $roomTypePhoto, $inclutions, $room_capacity);

        // Set values for room details
        $total_room = isset($_POST['total_room']) ? $_POST['total_room'] : '';
        $room_type = isset($_POST['room_type']) ? $_POST['room_type'] : '';
        $room_price = isset($_POST['room_price']) ? $_POST['room_price'] : '';
        $amenities = isset($_POST['amenities']) ? $_POST['amenities'] : '';
        $comfort_room = isset($_POST['comfort_room']) ? $_POST['comfort_room'] : '';
        $pets_allowed = isset($_POST['pets_allowed']) ? $_POST['pets_allowed'] : '';
        $electricity_bill = isset($_POST['electricity_bill']) ? $_POST['electricity_bill'] : '';
        $water_bill = isset($_POST['water_bill']) ? $_POST['water_bill'] : '';
        $room_availability_status = isset($_POST['room_availability_status']) ? $_POST['room_availability_status'] : '';
        $inclutions = isset($_POST['inclutions']) ? $_POST['inclutions'] : '';
        $room_capacity = isset($_POST['room_capacity']) ? $_POST['room_capacity'] : '';

        if ($stmt->execute()) {
            echo '<script>alert("Boarding House added successfully!"); window.location.href = "bhowner_panel.php";</script>';
            exit;
        } else {
            echo '<p style="color: red;">Error adding Boarding House. Please try again.</p>';
        }
    } else {
        echo '<p style="color: red;">Error adding Boarding House. Please try again.</p>';
    }

    $stmt->close();
    $conn->close();
}

// Function to handle file upload
function uploadPhoto($inputName, $targetDir)
{
    $uploadedFileNames = array();

    foreach ($_FILES[$inputName]['tmp_name'] as $key => $tmp_name) {
        $uploadedFileName = basename($_FILES[$inputName]['name'][$key]);
        $targetFilePath = $targetDir . $uploadedFileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Check if file is a valid image
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            // Upload file to the server
            if (move_uploaded_file($tmp_name, $targetFilePath)) {
                $uploadedFileNames[] = $uploadedFileName;
            }
        }
    }

    return implode(', ', $uploadedFileNames);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="../css/footer.css">
    <title>Add Boarding House</title>
    <style>
        body {
            font-family: 'Oswald', sans-serif;
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        #container {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
            color: #333;
        }

        input {
            padding: 10px;
            border-radius: 5px;
            margin: 5px 0;
            border: 1px solid #ddd;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
        #map {
            display: none;
            height: 400px; /* Adjust the height as needed */
            margin-bottom: 10px;
        }
        footer {
            position: relative;
            background-color: #333;
        }
    </style>
</head>
<body>
    <header class="sticky">
        <div class="logo">
            <a href="../index.html"><img src="logo.png" alt="logo" width="180" height="70" /></a>
        </div>
        <nav>
            <ul>
                <li class="active"><a href="#dashboard">Dashboard</a></li>
                <li><a href="boardinghouses.php">My Boarding Houses</a></li>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Menu</a>
                    <div class="dropdown-content">
                        <a href="profile.php">Profile</a>
                        <a href="../index.html">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
    </header>
    <div id="container">
        <h1>Add Boarding House</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="boarding_house_name">Boarding House Name</label>
            <input type="text" id="boarding_house_name" name="boarding_house_name" required>

            <label for="address">Address</label>
            <input type="text" id="address" name="address" required>

            <label for="longitude">Longitude</label>
            <input type="text" id="longitude" name="longitude" required>

            <label for="latitude">Latitude</label>
            <input type="text" id="latitude" name="latitude" required>

            <div id="map"></div>
            <button type="button" id="setLocationBtn">Set Location</button>

            <label for="description">Description</label>
            <input type="text" id="description" name="description" required>

            <label for="boarding_house_photo">Boarding House Photo</label>
            <input type="file" id="boarding_house_photo" name="boarding_house_photo" accept="image/*" required>

            <label for="facilities">Facilities</label>
            <input type="text" id="facilities" name="facilities" required>

            <label for="total_room">Total Room</label>
            <input type="text" id="total_room" name="total_room" required>

            <label for="room_type">Room Type</label>
            <input type="text" id="room_type" name="room_type" required>

            <label for="room_price">Room Price</label>
            <input type="text" id="room_price" name="room_price" required>

            <label for="amenities">Amenities</label>
            <input type="text" id="amenities" name="amenities" required>

            <label for="comfort_room">Comfort Room</label>
            <input type="text" id="comfort_room" name="comfort_room" required>

            <label for="pets_allowed">Pets Allowed</label>
            <input type="text" id="pets_allowed" name="pets_allowed" required>

            <label for="electricity_bill">Electricity Bill</label>
            <input type="text" id="electricity_bill" name="electricity_bill" required>

            <label for="water_bill">Water Bill</label>
            <input type="text" id="water_bill" name="water_bill" required>

            <label for="room_availability_status">Room Availability Status</label>
            <input type="text" id="room_availability_status" name="room_availability_status" required>

            <label for="room_photos">Room Photos</label>
            <input type="file" id="room_photos" name="room_photos[]" accept="image/*" multiple>

            <label for="room_type_photos">Room Type Photos</label>
            <input type="file" id="room_type_photos" name="room_type_photos[]" accept="image/*" multiple>

            <label for="inclusions">Inclusions</label>
            <input type="text" id="inclusions" name="inclusions" required>

            <label for="room_capacity">Room Capacity</label>
            <input type="text" id="room_capacity" name="room_capacity" required>

            <button type="submit">Add Boarding House</button>
        </form>
    </div>
    <script>
        var map;
        var marker;

        function initializeMap() {
            // Initialize Leaflet map with the default location in the Philippines
            map = L.map('map').setView([13.587552388782884, 124.20829296112062], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Create a marker with a popup
            marker = L.marker([13.587552388782884, 124.20829296112062], { draggable: true }).addTo(map);
            marker.bindPopup("Drag me to set the location").openPopup();

            // Update latitude and longitude fields based on marker movement
            marker.on('dragend', function (e) {
                document.getElementById('latitude').value = e.target.getLatLng().lat;
                document.getElementById('longitude').value = e.target.getLatLng().lng;
            });
        }

        document.getElementById('setLocationBtn').addEventListener('click', function () {
            // Show the map when the button is clicked
            document.getElementById('map').style.display = 'block';

            // Initialize the map if not already initialized
            if (!map) {
                initializeMap();
            }

            // Set the marker position based on existing latitude and longitude values
            var lat = parseFloat(document.getElementById('latitude').value) || 13.587552388782884;
            var lng = parseFloat(document.getElementById('longitude').value) || 124.20829296112062;
            marker.setLatLng([lat, lng]);
            map.setView([lat, lng], 15);
        });

        // Function to hide the map when the "Done" button is clicked
        function hideMap() {
            document.getElementById('map').style.display = 'none';
        }
    </script>
    <footer>
            <div id="footer">
                <div id="main-footer-5">
                    <h3>BHlocator</h3>
                    <p>Copyright 2023 BHlocator | All rights reserved.</p>
                </div>
            </div>
    </footer>
</body>
</html>