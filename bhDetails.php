<?php
if (isset($_GET['boarding_house_id'])) {
    $boarding_house_id = $_GET['boarding_house_id'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bhlocator";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to fetch detailed information from multiple tables using joins
    $sql = "SELECT bh.*, bho.owner_name, bho.address AS owner_address, rooms.*, bho.contact_number
        FROM boarding_house bh
        JOIN boarding_house_owner bho ON bh.owner_id = bho.owner_id
        JOIN rooms ON bh.boarding_house_id = rooms.boarding_house_id
        WHERE bh.boarding_house_id = $boarding_house_id";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Close the database connection
        $conn->close();
    } else {
        echo "No details found for the selected boarding house.";
        // Close the database connection
        $conn->close();
    }
} else {
    echo "Invalid request. Boarding house ID not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="1.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <title>Home</title>
    <style>
        #map {
            height: 400px;
            width: 50%;
            margin-top: 8%;
            margin-left: 25%;
            z-index: 0;
        }
  </style>
  </head>
  <body>

    <!-- nav -->
    <div>
        <nav>
          <div id="nav-left-option">
            <div class="dropdown">
              <a
                class="btn btn-secondary dropdown-toggle"
                href="#"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
                id="nav-menuBTN"
              >
                Menu
              </a>
              <ul class="dropdown-menu" id="dropdown-menu-id">
                  <li><a class="dropdown-item" href="admin_login.php">Login as Admin</a></li>
                  <li><a class="dropdown-item" href="bhowner_login.php">Login as BH Owner</a></li>
              </ul>
            </div>
          </div>
        </nav>

        <div id="nav-Bar-2">
          <div id="nav-Deals-from">
            <div class="nav-Img-logo">
              <a href="index.html">
                <img
                  src="logo.png"
                  alt="logo"
                />
              </a>
            </div>

            <div id="nav-text-Deals-from">
              <div><b><span id="detail-span">Deals from your favorite locator site</span></b></div>
              <div>
                <p>
                  Try searching for your Boarding House!
                </p>
              </div>
            </div>
          </div>
        </div>
    </div>
    <!-- End -->








    <div id="a-body">
    <div id="content">
    <?php if (isset($row)) : ?>

      <!-- Start -->
      <div id="a-image">
        <div id="a-bigimage">
          <img src="https://th.bing.com/th/id/OIP.opVhYb_CnFUNySzyNLChLQHaEP?rs=1&pid=ImgDetMain" alt="">
        </div>
        <div id="a-smallimage">
            <div><img src="https://pix8.agoda.net/hotelImages/302/302210/302210_15081213590034115196.jpg?ca=5&ce=1&s=375x" alt="">
            </div><div><img src="https://pix8.agoda.net/property/24109304/333086257/ef28622c82e4140d130a6730bffc684b.jpg?ca=20&ce=0&s=375x" alt="">
            </div><div><img id = "a-righttop"src="https://pix8.agoda.net/hotelImages/302/302210/302210_15081213590034115199.jpg?ca=5&ce=1&s=375x" alt="">
            </div><div><img src="https://pix8.agoda.net/hotelImages/302/302210/302210_15081213590034115175.jpg?ca=5&ce=1&s=375x" alt="">
            </div><div><img src="https://pix8.agoda.net/hotelImages/302/302210/302210_15081213590034115191.jpg?ca=5&ce=1&s=375x" alt="">
            </div><div><img id = "a-rightbottom"src="https://pix8.agoda.net/hotelImages/302/302210/302210_15081213590034115194.jpg?ca=5&ce=1&s=375x" alt="">
            </div>
        </div>
      </div>

      <div id="a-options">
            <div class="a-option-hover">
                <h4 class="hover-underline-animation"><a href="#a-hotelDetail">Overview</a></h4>
               <h4 class="hover-underline-animation"><a href="#a-rooms">Rooms</a></h4> 
                <h4 class="hover-underline-animation"><a href="#map">Location</a></h4>
            </div>
            <div  id="a-from" style="width:150px;"><h5 >Price </h5><span style="color: red;"><?= $row['room_price'] ?></span></div>
        </div>
      <!-- End -->

      <div>
        <div id="a-hotelDetail">
            <div id="a-leftdiv">
                <div id="a-abouthotel">
                    <img id="a-logo" src="logo.png" alt="">
                    <div>
                        <h2 id="a-HotelName"><?= $row['boarding_house_name'] ?></h2>
                        <p id="a-HotelAdd"><?= $row['address'] ?></p>
                        <hr>
                        <p><?= $row['description'] ?></p>
                    </div>
                </div>

                <div id="a-highlights">
                    <div><h3>Highlights</h3></div>
                    <!-- Add dynamic highlights based on data -->
                    <div>
                        <div>
                            <img src="https://ncsmadison.com/wp-content/uploads/2018/01/Security-Icon-2.png" alt="">
                            <p>Secure</p>
                        </div>
                        <div>
                            <img src="https://cdn2.iconfinder.com/data/icons/education-icons-4/200/SCHOOL15-512.png" alt="">
                            <p>Near School</p>
                        </div>
                        <div>
                            <img src="https://th.bing.com/th/id/R.5d4d859e01eda92728c27753aacda1ec?rik=Rj3ncTT%2bkRy5yQ&riu=http%3a%2f%2fgetdrawings.com%2ffree-icon%2fretail-store-icon-65.png&ehk=%2f%2fAQQaxTriDmE9Rh%2bUo%2fbbw%2bCx0bH1g0qs3Tt7Q2sQI%3d&risl=&pid=ImgRaw&r=0" alt="">
                            <p>Near Store</p>
                        </div>
                        <!-- Add other highlights -->
                    </div>
                </div>

                <div id="a-facility">
                    <h3>Facilities</h3>
                    <div>
                        <div>
                            <ul>
                                    <li><?= $row['facilities'] ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Room Selection Button -->
            <div id="a-rightdiv1">
                <div id="a-right1">
                    <button id="a-room"><a href="#a-rooms">SELECT ROOM</a></button>
                </div>

                <!-- Google Map and Contact Information -->
                <div id="map1">
                  <style>
                    #map1 {
                      margin-bottom: 20px;
                      height: 20vh;
                    }
                  </style>
                    <h5>Number of available room: <?= $row['total_room'] ?></h5>
                    <p>Contact Person: <?= $row['owner_name'] ?></p>
                    <p>Contact Number: <?= $row['contact_number'] ?></p>
                </div>

                <!-- Popular Landmarks -->
                <h3>Popular landmarks</h3>
                <div id="a-popular">
                    <h5>🔎 ACC Mini</h5>
                    <h5>🔎 Landbank</h5>
                    <h5>🔎 Catanduanes State University</h5>
                </div>
            </div>
        </div>

        <!-- Room Details -->
        <div id="a-rooms">
            <div>
                <h2 style="margin:0 0 -7px 10px;"><?= $row['room_type'] ?></h2>
                <div>
                    <div>
                        <!-- Display room photos dynamically -->
                            <img class="upperimg" src="<?= $room_type_photos ?>" alt="">

                    <!-- Display room details dynamically -->
                    <ul style="margin-top: 30px;">
                        <h6><li>Comfort room: <?= $row['comfort_room'] ?></li></h6>
                        <h6><li>Pets allowed: <?= $row['pets_allowed'] ?></li></h6>
                        <h6><li>Electricity bill: <?= $row['electricity_bill'] ?></li></h6>
                        <h6><li>Water bill: <?= $row['water_bill'] ?></li></h6>
                        <h6><li>Amenities: <?= $row['amenities'] ?></li></h6>
                    </ul>
                </div>

                <!-- Room Inclusions -->
                <div>
                    <div id="a-benifits">
                        <h2>Inclusions</h2>
                        <h3>Your price includes:</h3>
                        <ul>
                            <li><?= $row['inclutions'] ?></li>
                        </ul>
                    </div>
                </div>

                <!-- Room Capacity -->
                <div id="a-sleep">
                    <h2>Good For</h2>
                    <h3><?= $row['room_capacity'] ?> Person(s)</h3>
                </div>
            </div>
        </div>

        <!-- Location Map -->
        <div id="map-text"><h1> Location</h1></div>
        <div id="map">
            <style>
              #map {
                width: 100%;   /* Set the desired width */
                height: 50vh;
                margin: auto;
                margin-top: 10px;
              }
              #map-text {
                margin-top: 50px;
              }
            </style>
        </div>
        
    <?php else : ?>
        <!-- Display a message if no details are found -->
        <p>No details found for the selected boarding house.</p>
    <?php endif; ?>
</div>
</div>
</div>
</div>




    <!-- Footer -->
    <div id="body-footer">
      <div id="footer">
      <hr id="line-1"/>
      <!-- <div id="main-footer-3">
        <div>
          <a href="https://www.facebook.com/" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
          </svg></a>
        </div>
        <div>
          <a href="https://www.instagram.com/" target="_blank"><i class="fa fa-instagram" style="font-size:17px"></i></a>
        </div>
        <div>
          <a href="https://www.youtube.com/user/" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="27" fill="currentColor" class="bi bi-youtube" viewBox="0 0 16 16">
            <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408L6.4 5.209z"/>
          </svg></a>
        </div>
      </div> -->
  
        <!-- <div id="main-footer-4">
          <div>
            <a href="https://" target="_blank"><p>Help</p></a>
            <a href="https://" target="_blank"><p>Learn how bhlocator works</p></a>
            <a href="https://" target="_blank"><p>Terms and conditions</p></a>
            <a href="https://" target="_blank"><p>Legal information</p></a>
            <a href="https://" target="_blank"><p>Privacy notice</p></a>
            <a href="https://" target="_blank"><p>Cyber Security</p></a>
          </div>
        </div> -->
  
        <div id="main-footer-5">
          <h3>BHlocator</h3>
          <p>Copyright 2023 BHlocator | All rights reserved.</p>
        </div>
   </div> 
  </div>
    <!-- End -->



    <script>
      $(document).ready(function () {
        // Your existing PHP and other JavaScript code...

        <?php if (isset($row)) : ?>
          // Retrieve latitude and longitude from the PHP $row variable
          var latitude = <?= $row['latitude'] ?>;
          var longitude = <?= $row['longitude'] ?>;

          // Initialize Leaflet map
          var map = L.map('map').setView([latitude, longitude], 15);

          // Add a marker to the map
          L.marker([latitude, longitude]).addTo(map)
            .bindPopup('<b><?= $row['boarding_house_name'] ?></b><br><?= $row['address'] ?>');

          // Add a tile layer to the map (you can choose a different tile provider)
          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
          }).addTo(map);
        <?php endif; ?>
      });
    </script>

<script>
      $(document).ready(function () {
        // Your existing PHP and other JavaScript code...

        <?php if (isset($row)) : ?>
          // Retrieve latitude and longitude from the PHP $row variable
          var latitude = <?= $row['latitude'] ?>;
          var longitude = <?= $row['longitude'] ?>;

          // Initialize Leaflet map
          var map1 = L.map('map1').setView([latitude, longitude], 13);

          // Add a marker to the map
            L.marker([latitude, longitude]).addTo(map1)
            .bindPopup('<?= $row['boarding_house_name'] ?>');

          // Add a tile layer to the map (you can choose a different tile provider)
          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
          }).addTo(map1);
        <?php endif; ?>
      });
    </script>

  </body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  <script src="js/script.js"></script>
  <script src="1.js"></script>
</html>