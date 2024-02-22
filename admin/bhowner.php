<!DOCTYPE html>
<html lang="en">

<head>
    <title>Boarding House Management - Tenants</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="../css/footer.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        h2 {
            margin-top: -10%;
        }

        th,
        td {
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
                <li><a href="admin_panel.php">Dashboard</a></li>
                <li class="active"><a href="bhowner.php">Boarding House Owner</a></li>
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
                <h2>Boarding House Owner</h2>
                <table class="editable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Boarding House Name</th>
                            <th>Contact Number</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Account Status</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $database = "bhlocator";

                        $conn = new mysqli($servername, $username, $password, $database);

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $query = "SELECT o.*, b.boarding_house_name 
                                  FROM boarding_house_owner o
                                  LEFT JOIN boarding_house b ON o.owner_id = b.owner_id";

                        $result = $conn->query($query);

                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td contenteditable='true' class='editable-field' data-field='owner_name'>" . $row['owner_name'] . "</td>";
                                echo "<td contenteditable='true' class='editable-field' data-field='boarding_house_name'>" . $row['boarding_house_name'] . "</td>";
                                echo "<td contenteditable='true' class='editable-field' data-field='contact_number'>" . $row['contact_number'] . "</td>";
                                echo "<td contenteditable='true' class='editable-field' data-field='address'>" . $row['address'] . "</td>";
                                echo "<td contenteditable='true' class='editable-field' data-field='email_address'>" . $row['email_address'] . "</td>";
                                echo "<td contenteditable='true' class='editable-field' data-field='account_status'>" . $row['account_status'] . "</td>";
                                echo "<td contenteditable='true' class='editable-field' data-field='username'>" . $row['username'] . "</td>";
                                echo "<td contenteditable='true' class='editable-field' data-field='password'>" . $row['password'] . "</td>";
                                echo "<td><button class='edit-btn' onclick='editOwner(" . $row['owner_id'] . ")'>Edit</button></td>";
                                echo "<td><button class='delete-btn' onclick='deleteOwner(" . $row['owner_id'] . ")'>Delete</button></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='10'>No owners found</td></tr>";
                        }

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
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI/tf8QIIt9z5P0NqG9aPq1T0tYytz9E9uQQ9+I="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script>

        function deleteOwner(owner_id) {
            if (confirm("Are you sure you want to delete this owner?")) {
                window.location.href = "delete_owner.php?delete_owner=true&owner_id=" + owner_id;
            }
        }

    </script>
</body>

</html>
