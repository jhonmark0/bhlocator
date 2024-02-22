<!DOCTYPE html>
<html>
<head>
    <title>Boarding House Owner Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="../css/footer.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
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
    <main>
        <div id="dashboard" class="dashboard">
            <?php
            session_start(); // Start the session to access user information

            // Check if the user is logged in
            if (!isset($_SESSION['owner_id'])) {
                // If not logged in, redirect to the login page
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

            // Fetch information about the owner's boarding houses
            $query = "SELECT * FROM boarding_house b
                      JOIN rooms r ON b.boarding_house_id = r.boarding_house_id
                      WHERE b.owner_id = ?";

            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $owner_id);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if there are boarding houses for the owner
            if ($result->num_rows > 0) {
                // Fetch and display information for each boarding house
                while ($row = $result->fetch_assoc()) {
                    $boarding_house_name = $row['boarding_house_name'];
                    $total_rooms = $row['total_room'];
                    $available_rooms = $row['room_availability_status'];
                    $total_visits = 100;
                    $latitude = $row['latitude'];
                    $longitude = $row['longitude'];
                    ?>
                    <section class="dashboard-content">
                        <h2><?php echo $boarding_house_name; ?></h2>
                        <div class="summary">
                            <div class="card">
                                <h3>Total Room</h3>
                                <p><?php echo $total_rooms; ?></p>
                            </div>
                            <div class="card">
                                <h3>Available Rooms</h3>
                                <p><?php echo $available_rooms; ?></p>
                            </div>
                            <div class="card">
                                <h3>Total Visits</h3>
                                <p><?php echo $total_visits; ?></p>
                            </div>
                        </div>
                    </section>
                <?php
                }
            } else {
                // If no boarding houses are found for the owner
                echo "<p>No boarding houses found for the owner.</p>";
            }

            $stmt->close();
            $conn->close();
            ?>
        </div>
        <div class="map">
        <div id="map" style="height: 500px; max-width: 900px; margin-left: auto; margin-right: auto;"></div>
        </div>
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script>
            var mymap = L.map('map').setView([<?php echo $latitude; ?>, <?php echo $longitude; ?>], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(mymap);
            
            <?php
            // Resetting the result set pointer
            $result->data_seek(0);
            
            while ($row = $result->fetch_assoc()) {
                $boarding_house_name = $row['boarding_house_name'];
                $latitude = $row['latitude'];
                $longitude = $row['longitude'];
                ?>
                L.marker([<?php echo $latitude; ?>, <?php echo $longitude; ?>])
                    .addTo(mymap)
                    .bindPopup("<b><?php echo $boarding_house_name; ?></b><br>Calatagan Proper, Real Street, Virac, Catanduanes")
                    .openPopup();
            <?php
            }
            ?>
        </script>
    </main>
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
