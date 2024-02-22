<!DOCTYPE html>
<html>
<head>
    <title>Boarding Houses</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="../css/footer.css">
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
        <div id="boardinghouses" class="dashboard">
            <section class="dashboard-content">
                <h2>My Boarding House</h2>
                <div class="boarding-house-list">
                    <?php
                    session_start();

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
                    $query = "SELECT * FROM boarding_house WHERE owner_id = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $owner_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Check if there are boarding houses for the owner
                    if ($result->num_rows > 0) {
                        // Fetch and display information for each boarding house
                        while ($row = $result->fetch_assoc()) {
                            $boarding_house_name = $row['boarding_house_name'];
                            $description = $row['description'];
                            ?>
                            <div class="boarding-house">
                                <p>Boarding House Name:</p>
                                <h3><?php echo $boarding_house_name; ?></h3>
                                <button><a href="view-boardinghouse.php?boarding_house_name=<?php echo urlencode($boarding_house_name); ?>">View</a></button>
                            </div>
                        <?php
                        }
                    } else {
                        // If no boarding houses are found for the owner
                        echo "<p>No boarding houses found!.</p>";
                    }

                    $stmt->close();
                    $conn->close();
                    ?>
                </div>
                <button><a href="add-boardinghouse.php?owner_id=<?php echo $owner_id; ?>">Add New Boarding House</a></button>
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
</body>
</html>