<?php
// Database connection parameters
$host = 'localhost';     // Change this to your database host
$username = 'root';       // Change this to your database username
$password = '';           // Change this to your database password
$database = 'bhlocator';  // Change this to your database name

// Create a database connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start(); // Start the session to access user information

// Check if the user is logged in
if (!isset($_SESSION['owner_id'])) {
    // If not logged in, redirect to the login page
    header("Location: ../login.php");
    exit;
}

$owner_id = $_SESSION['owner_id'];

// Check if the form is submitted to update data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['edit']) && $_POST['edit'] === 'true') {
        // Edit mode: retrieve values from the form
        $owner_name = mysqli_real_escape_string($conn, $_POST['owner_name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);
        
        // Display the form with editable input fields
    } elseif (isset($_POST['update']) && $_POST['update'] === 'true') {
        // Update mode: update the data in the boarding_house_owner table
        $owner_name = mysqli_real_escape_string($conn, $_POST['owner_name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);
        
        $sql = "UPDATE boarding_house_owner SET owner_name = ?, username = ?, email_address = ?, password = ?, address = ?, contact_number = ? WHERE owner_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssssssi", $owner_name, $username, $email, $password, $address, $contact_number, $owner_id);
            mysqli_stmt_execute($stmt);
            
            echo '<script>alert("Profile updated successfully!");</script>';
            
            mysqli_stmt_close($stmt);
        } else {
            echo '<script>alert("Error: ' . mysqli_error($conn) . '");</script>';
        }
    }
}

// Fetch boarding_house_owner details
$query = "SELECT * FROM boarding_house_owner WHERE owner_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $owner_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    // Handle the case when no results are returned, set default values or redirect
    // For example, you can set default values like $row = ['owner_name' => '', 'username' => '', 'email_address' => ''];
    // or redirect to another page
    // header("Location: some_error_page.php");
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="../css/footer.css">
</head>
<style>
    form {
        display: flex;
        flex-direction: column;
        max-width: 400px;
        margin: 0 auto;
    }

    label {
        margin-bottom: 8px;
    }

    input, textarea {
        width: 100%;
        padding: 8px;
        margin-bottom: 16px;
    }

    button {
        background-color: #4CAF50;
        color: white;
        padding: 10px;
        border: none;
        cursor: pointer;
    }

    button:hover {
        background-color: #45a049;
    }
    footer {
        position: relative;
        background-color: #333;
    }
</style>
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
            <section class="dashboard-content">
                <h2>Profile</h2>
                <!-- Display boarding_house_owner details and allow editing -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <label for="owner_name">Owner Name:</label>
                    <input type="text" id="owner_name" name="owner_name" value="<?php echo isset($row['owner_name']) ? $row['owner_name'] : ''; ?>" required>

                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" value="<?php echo isset($row['username']) ? $row['username'] : ''; ?>" required>

                    <label for="email">Email:</label>
                    <input type="text" id="email" name="email" value="<?php echo isset($row['email_address']) ? $row['email_address'] : ''; ?>" required>

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" value="<?php echo isset($row['password']) ? $row['password'] : ''; ?>" required>

                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" value="<?php echo isset($row['address']) ? $row['address'] : ''; ?>" required>

                    <label for="contact_number">Contact Number:</label>
                    <input type="text" id="contact_number" name="contact_number" value="<?php echo isset($row['contact_number']) ? $row['contact_number'] : ''; ?>" required>

                    <?php
                    if (isset($_POST['edit']) && $_POST['edit'] === 'true') {
                        // Display the Update button if in edit mode
                        echo '<button type="submit" name="update" value="true">Update Profile</button>';
                    } else {
                        // Display the Edit button if not in edit mode
                        echo '<button type="submit" name="edit" value="true">Edit Profile</button>';
                    }
                    ?>
                </form>
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