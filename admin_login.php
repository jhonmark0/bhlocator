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

    $enteredUsername = isset($_POST['username']) ? $_POST['username'] : '';
    $enteredPassword = isset($_POST['password']) ? $_POST['password'] : '';

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $enteredUsername, $enteredPassword);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Admin authentication successful, redirect to an admin panel or dashboard
        header("Location: admin/admin_panel.php");
        exit;
    } else {
        echo '<script>alert("Admin login failed. Please check your credentials.");</script>';
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
    <title>Admin Login</title>
    <style>
        body {
            font-family: 'Oswald', sans-serif;
            font-family: 'Roboto', sans-serif;
        }
        #container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            flex-direction: column;
            width: 50%;
            margin: auto;
            margin-top: 70px;
        }
        #logo {
            width: 16%;
            margin-top: -40px;
            margin-left: -220px;
            margin-bottom: 30px;
        }
        #login {
            display: flex;
            justify-content: space-around;
            flex-direction: column;
            width: 45%;
        }
        h1 {
            font-size: 29.5px;
        }
        label {
            margin-top: 20px;
            margin-bottom: 10px;
            font-size: 13px;
            font-weight: bolder;
            margin: 2px;
        }
        input {
            padding: 15px 15px;
            border-radius: 10px;
            margin: 10px 2px;
            width: 88%;
            border: 1px solid rgb(163, 155, 155);
        }
        button {
            padding: 15px;
            border-radius: 10px;
            margin: 5px 2px;
            width: 97.5%;
            background-color: rgb(62, 123, 203);
            border: none;
            color: rgb(255, 255, 255);
            font-weight: bolder;
            font-size: 16px;
        }
        button:hover {
            background-color: #2d6995;
        }
        p {
            padding: 0px 10px;
            font-size: 15px;
        }
        a {
            color: #56a7e1;
        }
        b {
            margin-top: 20px;
            margin-left: -120px;
        }
        #id {
            position: relative;
            right: 8%;
        }
    </style>
</head>
<body>
    <div id="container">
        <img id="logo" src="logo.png" alt="">
        <p id="id"></p>
        <div id="login">
            <form action="" method="post">
                <h1>Admin Login</h1>
                <label for="username">Username</label>
                <input type="text" id="username" name="username">
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
                <button id="btn" type="submit">Login</button>
            </form>
        </div>
    </div>
</body>
</html>