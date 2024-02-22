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

// Fetch data from the database
$query = "SELECT 
COUNT(DISTINCT b.boarding_house_id) AS total_boarding_houses,
SUM(r.total_room) AS total_rooms,
SUM(r.room_availability_status) AS available_rooms
FROM boarding_house b
LEFT JOIN rooms r ON b.boarding_house_id = r.boarding_house_id
";

$result = $conn->query($query);

// Check if the query was successful
if ($result) {
    $data = $result->fetch_assoc();
} else {
    // Handle the case when the query fails
    $data = array(
        'total_boarding_houses' => 0,
        'total_rooms' => 0,
        'available_rooms' => 0
    );
}

// Check if it's an AJAX request
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    // Output as JSON for AJAX requests
    echo json_encode($data);
    // Exit to prevent further HTML output
    exit;
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Boarding House Management</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" type="text/css" href="../css/footer.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    #map {
      height: 400px;
      margin-bottom: 5%;
      z-index: 0;
    }
    nav ul li a {
        color: black;
        text-decoration: none;
    }
    footer {
        position: relative;
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
          <li><a href="bhowner.php">Boarding House Owner</a></li>
          <li><a href="boardinghouses.php">Boarding House</a></li>
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
            <section class="dashboard-content">
                <h2>Admin Dashboard</h2>
                <div class="summary">
                    <div class="card">
                        <h3>Total Boarding Houses</h3>
                        <p><?= $data['total_boarding_houses'] ?></p>
                    </div>
                    <div class="card">
                        <h3>Total Rooms</h3>
                        <p><?= $data['total_rooms'] ?></p>
                    </div>
                    <div class="card">
                        <h3>Available Rooms</h3>
                        <p><?= $data['available_rooms'] ?></p>
                    </div>
                </div>
            </section>
        </div>
    </main>

<div id="map"></div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
  let map;

  $(document).ready(function () {
    $.ajax({
      url: '../components/getBoardingHouses.php',
      type: 'GET',
      dataType: 'json',
      success: function (boardingHouses) {
        initMap(boardingHouses);
      },
      error: function (error) {
        console.error('Error fetching boarding houses:', error);
      }
    });
  });

  function initMap(boardingHouses) {
    map = L.map('map').setView([13.587644, 124.208216], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    boardingHouses.forEach(boardingHouse => {
      const marker = L.marker([boardingHouse.latitude, boardingHouse.longitude]).addTo(map);

      const popupContent = `
        <b>${boardingHouse.boarding_house_name}</b><br>
        <i>${boardingHouse.address}</i><br>
        Rooms Available: ${boardingHouse.total_room}<br>
        Average Price: ${boardingHouse.room_price}<br>
      `;

      marker.bindPopup(popupContent);
    });
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
