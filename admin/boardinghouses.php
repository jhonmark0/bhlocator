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

// Fetch data from the database using JOIN operations
$query = "SELECT bh.*, bo.owner_name, r.total_room, r.room_price, r.room_availability_status
          FROM boarding_house bh
          LEFT JOIN boarding_house_owner bo ON bh.owner_id = bo.owner_id
          LEFT JOIN rooms r ON bh.boarding_house_id = r.boarding_house_id";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boarding House Management</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="../css/footer.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        h2 {
            margin-top: -10%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        a {
            text-decoration: none;
            color: #008CBA;
        }
        header.sticky {
        top: 0;
        width: 100%;
        z-index: 1000;
        }
        header.sticky a {
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
        <div class="dashboard">
            <section class="dashboard-content">
                <h2>Boarding Houses</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Boarding House Name</th>
                            <th>Owner Name</th>
                            <th>Address</th>
                            <th>Total Rooms</th>
                            <th>Room Price</th>
                            <th>Availability Status</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Check if the query was successful
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['boarding_house_name'] . "</td>";
                                echo "<td>" . $row['owner_name'] . "</td>";
                                echo "<td>" . $row['address'] . "</td>";
                                echo "<td>" . $row['total_room'] . "</td>";
                                echo "<td>" . $row['room_price'] . "</td>";
                                echo "<td>" . $row['room_availability_status'] . "</td>";
                                echo "<td><a href='edit.php?id=" . $row['boarding_house_id'] . "'>Edit</a></td>";
                                echo "<td><a href='delete.php?id=" . $row['boarding_house_id'] . "'>Delete</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            // Handle the case when no boarding houses are found
                            echo "<tr><td colspan='8'>No boarding houses found</td></tr>";
                        }

                        // Close the database connection
                        $conn->close();
                        ?>
                    </tbody>
                </table>
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
