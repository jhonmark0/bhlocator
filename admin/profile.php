<?php
// Include your database connection code here
$servername = "localhost";
$username = "root";
$password = "";
$database = "bhlocator";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assume $adminId is the user's ID, you need to set it appropriately
$adminId = 1; // Replace with the actual admin ID

// Sample query to retrieve username and password
$query = "SELECT username, password FROM admin WHERE admin_id = $adminId";

$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = $row['username'];
    $password = $row['password'];
} else {
    // Handle the case when the user is not found
    $username = "User not found";
    $password = "Password not found";
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Boarding House Management - Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="../css/footer.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Include Font Awesome for the eye icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        /* Profile styles */
        .dashboard.profile {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            height: 350px;
            margin: 0 auto;
            text-align: center;
            margin-top: 5%;
            margin-bottom: 6%;
        }

        .dashboard.profile table {
            width: 100%;
            border-collapse: collapse;
        }

        .dashboard.profile table td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .dashboard.profile button {
            background-color: #2196F3;
            color: #fff;
            border: none;
            padding: 10px 20px;
            margin: 10px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .dashboard.profile button a {
            text-decoration: none;
            color: #fff;
        }

        /* Password reveal styles */
        .password-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .password-container .eye-icon {
            cursor: pointer;
        }

        .password-container .eye-icon i {
            font-size: 24px;
            color: #2196F3;
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
                <li class="active"><a href="admin_panel.php">Dashboard</a></li>
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
        <div class="dashboard profile">
            <section class="dashboard-content">
                <h2>Profile</h2>
                <table>
                    <tbody>
                        <tr>
                            <td>Username</td>
                            <td><?php echo $username; ?></td>
                        </tr>
                        <tr>
                            <td>Password</td>
                            <td><?php echo $password; ?></td>
                        </tr>
                    </tbody>
                </table>
                <button><a href="edit-profile.php">Edit Profile</a></button>
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
        function togglePasswordVisibility(eyeIcon) {
            var passwordField = eyeIcon.parentElement.previousSibling;
            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.innerHTML = '<i class="fa fa-eye-slash"></i>';
            } else {
                passwordField.type = "password";
                eyeIcon.innerHTML = '<i class="fa fa-eye"></i>';
            }
        }
    </script>
</body>
</html>
