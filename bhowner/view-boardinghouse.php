<!DOCTYPE html>
<html>
<head>
    <title>View Boarding House</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="../css/footer.css">
    <style>
        .dashboard-buttons {
            margin-bottom: 20px;
        }

        .dashboard-buttons button {
            margin-right: 10px;
            padding: 10px;
            cursor: pointer;
        }

        .dashboard-buttons button.active {
            background-color: #4CAF50;
            color: white;
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
                <li><a href="boardinghouses.php">Boarding Houses</a></li>
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
            <div class="dashboard-buttons">
                <button id="btnBoardingHouse" class="active" onclick="showDetails('boardingHouse')">Boarding House Details</button>
                <button id="btnRoom" onclick="showDetails('room')">Room Details</button>
                <button id="btnPhotos" onclick="showDetails('photos')">Photos</button>
            </div>
            <section class="dashboard-content" id="boardingHouseDetails">
                <h2>Boarding House Details</h2>

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
                        // Display boarding house details
                        echo "<p><strong>Boarding House Name:</strong> {$row['boarding_house_name']}</p>";
                        echo "<p><strong>Address:</strong> {$row['address']}</p>";
                        echo "<p><strong>Description:</strong> {$row['description']}</p>";
                        echo "<p><strong>Facilities:</strong> {$row['facilities']}</p>";
                        // Add more boarding house details as needed
                        echo "<button><a href='update-boardinghouse.php?owner_id={$owner_id}'>Update Boarding House</a></button>";
                    }
                } else {
                    echo "<p>No boarding houses found for the owner.</p>";
                }

                $stmt->close();
                $conn->close();
                ?>
            </section>

            <section class="dashboard-content" id="roomDetails" style="display: none;">
                <h2>Room Details</h2>

                <?php
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
                        echo "<p><strong>Total Room:</strong> {$row['total_room']}</p>";
                        echo "<p><strong>Room Type:</strong> {$row['room_type']}</p>";
                        echo "<p><strong>Room Price:</strong> {$row['room_price']}</p>";
                        echo "<p><strong>Amenities:</strong> {$row['amenities']}</p>";
                        echo "<p><strong>Comfort Room:</strong> {$row['comfort_room']}</p>";
                        echo "<p><strong>Pets Allowed:</strong> {$row['pets_allowed']}</p>";
                        echo "<p><strong>Electricity Bill:</strong> {$row['electricity_bill']}</p>";
                        echo "<p><strong>Water Bill:</strong> {$row['water_bill']}</p>";
                        echo "<p><strong>Room Availability:</strong> {$row['room_availability_status']}</p>";
                        echo "<p><strong>Inclutions:</strong> {$row['inclutions']}</p>";
                        echo "<p><strong>Room Capacity:</strong> {$row['room_capacity']}</p>";
                        echo "<button><a href='update-boardinghouse.php?owner_id={$owner_id}'>Update Boarding House</a></button>";
                    }
                } else {
                    echo "<p>No boarding houses found for the owner.</p>";
                }

                $stmt->close();
                $conn->close();
                ?>
            </section>

            <section class="dashboard-content" id="photos" style="display: none;">
                <h2>Photos</h2>

                <?php
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
                        echo "<p><strong>Boarding House Photo:</strong> {$row['boarding_house_photo']}</p>";
                        echo "<p><strong>Room Photos:</strong> {$row['room_photos']}</p>";
                        echo "<p><strong>Room Type Photos:</strong> {$row['room_type_photos']}</p>";
                        echo "<button><a href='update-boardinghouse.php?owner_id={$owner_id}'>Update Boarding House</a></button>";
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
            <div id="footer">
                <div id="main-footer-5">
                    <h3>BHlocator</h3>
                    <p>Copyright 2023 BHlocator | All rights reserved.</p>
                </div>
            </div>
    </footer>
    <script>
        function showDetails(section) {
            document.getElementById('boardingHouseDetails').style.display = 'none';
            document.getElementById('roomDetails').style.display = 'none';
            document.getElementById('photos').style.display = 'none';

            document.getElementById(`btnBoardingHouse`).classList.remove('active');
            document.getElementById(`btnRoom`).classList.remove('active');
            document.getElementById(`btnPhotos`).classList.remove('active');

            if (section === 'boardingHouse') {
                document.getElementById('boardingHouseDetails').style.display = 'block';
                document.getElementById(`btnBoardingHouse`).classList.add('active');
            } else if (section === 'room') {
                document.getElementById('roomDetails').style.display = 'block';
                document.getElementById(`btnRoom`).classList.add('active');
            } else if (section === 'photos') {
                document.getElementById('photos').style.display = 'block';
                document.getElementById(`btnPhotos`).classList.add('active');
            }
        }
    </script>
</body>
</html>
