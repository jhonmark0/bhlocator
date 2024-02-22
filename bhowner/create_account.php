<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "bhlocator";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $ownerName = isset($_POST['owner_name']) ? $_POST['owner_name'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $contactNumber = isset($_POST['contact_number']) ? $_POST['contact_number'] : '';
    $emailAddress = isset($_POST['email_address']) ? $_POST['email_address'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Additional validation and sanitation if needed

    $stmt = $conn->prepare("INSERT INTO boarding_house_owner (owner_name, address, contact_number, email_address, username, password, account_status) VALUES (?, ?, ?, ?, ?, ?, 'Pending')");
    $stmt->bind_param("ssssss", $ownerName, $address, $contactNumber, $emailAddress, $username, $password);

    if ($stmt->execute()) {
        echo '<script>alert("Account created successfully! Please wait for admin account approval."); window.location.href = "../bhowner_login.php";</script>';
        exit;
    } else {
        echo '<p style="color: red;">Error creating account. Please try again.</p>';
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <style>
        body {
            font-family: 'Oswald', sans-serif;
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        #container {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
            color: #333;
        }

        input {
            padding: 10px;
            border-radius: 5px;
            margin: 5px 0;
            border: 1px solid #ddd;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        p {
            text-align: center;
            margin-top: 10px;
        }

        p a {
            color: #3498db;
        }

        p a:hover {
            text-decoration: underline;
        }

        #back-button {
            color: black;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        #back-button:hover {
            color: red;
        }

        #next-button {
            position: absolute;
            top: 20px;
            left: 20px;
            color: blue;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        #next-button:hover {
            color: darkblue;
        }
    </style>
</head>
<body>
    <div id="container">
        <a href="../bhowner_login.php" id="back-button">Back to Login</a>
        <h1>Create Account as Boarding House Owner</h1>
        <form action="" method="post">
            <label for="owner_name">Owner Name</label>
            <input type="text" id="owner_name" name="owner_name" required>

            <label for="address">Address</label>
            <input type="text" id="address" name="address" required>

            <label for="contact_number">Contact Number</label>
            <input type="text" id="contact_number" name="contact_number" required>

            <label for="email_address">Email Address</label>
            <input type="email" id="email_address" name="email_address" required>

            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Create Account</button>
        </form>
    </div>
</body>
</html>
