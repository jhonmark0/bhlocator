<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Boarding House</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="../css/footer.css">
    <style>
        .dashboard {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
}

/* Style the form */
form {
    max-width: 400px;
    margin: 0 auto;
}

label {
    display: block;
    margin-bottom: 5px;
}

input,
textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    box-sizing: border-box;
}

button {
    background-color: #333;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #555;
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
            <a href="../index.html"><img src="logo.png" alt="logo" width="160" height="70" /></a>
        </div>
        <nav>
            <ul>
                <li><a href="bhowner_panel.php">Dashboard</a></li>
                <li class="active"><a href="#boardinghouses">Boarding Houses</a></li>
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

    <main>
        <div class="dashboard">
            <section class="dashboard-content">
                <h2>Update Boarding House</h2>

                <?php
                session_start();

                if (!isset($_SESSION['owner_id'])) {
                    header("Location: ../login.php");
                    exit;
                }

                $owner_id = $_SESSION['owner_id'];

                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "bhlocator";

                $conn = new mysqli($servername, $username, $password, $database);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch details of the boarding houses for the owner
                $query = "SELECT bh.*, r.* FROM boarding_house_owner bo
                          JOIN boarding_house bh ON bo.owner_id = bh.owner_id
                          JOIN rooms r ON bh.boarding_house_id = r.boarding_house_id
                          WHERE bo.owner_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $owner_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Display boarding house details in a form for updating
                        ?>
                        <form id="updateForm" action="process-update-boardinghouse.php" method="post">
                            <input type="hidden" name="owner_id" value="<?php echo $owner_id; ?>">
                            
                            <!-- Boarding House Fields -->
                            <label for="boarding_house_name">Boarding House Name:</label>
                            <input type="text" name="boarding_house_name" value="<?php echo $row['boarding_house_name']; ?>" required><br>

                            <label for="address">Address:</label>
                            <input type="text" name="address" value="<?php echo $row['address']; ?>" required><br>

                            <label for="longitude">Longitude:</label>
                            <input type="text" name="longitude" value="<?php echo $row['longitude']; ?>" required><br>

                            <label for="latitude">Latitude:</label>
                            <input type="text" name="latitude" value="<?php echo $row['latitude']; ?>" required><br>

                            <label for="description">Description:</label>
                            <textarea name="description" required><?php echo $row['description']; ?></textarea><br>

                            <label for="facilities">Facilities:</label>
                            <input type="text" name="facilities" value="<?php echo $row['facilities']; ?>" required><br>

                            <label for="boarding_house_photo">Boarding House Photo:</label>
                            <input type="text" name="boarding_house_photo" value="<?php echo $row['boarding_house_photo']; ?>" required><br>

                            <!-- Room Fields -->
                            <label for="total_room">Total Room:</label>
                            <input type="text" name="total_room" value="<?php echo $row['total_room']; ?>" required><br>

                            <label for="room_type">Room Type:</label>
                            <input type="text" name="room_type" value="<?php echo $row['room_type']; ?>" required><br>

                            <label for="room_price">Room Price:</label>
                            <input type="text" name="room_price" value="<?php echo $row['room_price']; ?>" required><br>

                            <label for="amenities">Amenities:</label>
                            <input type="text" name="amenities" value="<?php echo $row['amenities']; ?>" required><br>

                            <label for="comfort_room">Comfort Room:</label>
                            <input type="text" name="comfort_room" value="<?php echo $row['comfort_room']; ?>" required><br>

                            <label for="pets_allowed">Pets Allowed:</label>
                            <input type="text" name="pets_allowed" value="<?php echo $row['pets_allowed']; ?>" required><br>

                            <label for="electricity_bill">Electricity Bill:</label>
                            <input type="text" name="electricity_bill" value="<?php echo $row['electricity_bill']; ?>" required><br>

                            <label for="water_bill">Water Bill:</label>
                            <input type="text" name="water_bill" value="<?php echo $row['water_bill']; ?>" required><br>

                            <label for="room_availability_status">Room Availability</label>
                            <input type="text" name="room_availability_status" value="<?php echo $row['room_availability_status']; ?>" required><br>

                            <label for="inclutions">Inclutions:</label>
                            <input type="text" name="inclutions" value="<?php echo $row['inclutions']; ?>" required><br>

                            <label for="room_capacity">Room Capacity:</label>
                            <input type="text" name="room_capacity" value="<?php echo $row['room_capacity']; ?>" required><br>

                            <label for="room_photos">Boarding House Photos:</label>
                            <input type="text" name="room_photos" value="<?php echo $row['room_photos']; ?>" required><br>

                            <label for="room_type_photos">Room Types Photo:</label>
                            <input type="text" name="room_type_photos" value="<?php echo $row['room_type_photos']; ?>" required><br>

                            <button type="button" onclick="updateBoardingHouse()">Update Boarding House</button>
                        </form>
                        <?php
                    }
                } else {
                    echo "<p>No boarding houses found for the owner.</p>";
                }

                $stmt->close();
                $conn->close();
                ?>
            </section>
        </div>
    </main>
    <footer>
        <div id="body-footer">
            <div id="footer">
                <div id="main-footer-5">
                    <h3>BHlocator</h3>
                    <p>Copyright 2023 BHlocator | All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    <script>
function updateBoardingHouse() {
    var form = document.getElementById('updateForm');
    var formData = new FormData(form);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', form.action, true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                alert('Boarding house details updated successfully.');
            } else {
                alert('Error updating boarding house details: ' + response.error);
            }
        }
    };

    xhr.send(formData);
}
</script>
</body>
</html>
