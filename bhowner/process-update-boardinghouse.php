<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    if (!isset($_SESSION['owner_id'])) {
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

    // Retrieve and validate data from the form
    $boarding_house_name = isset($_POST['boarding_house_name']) ? $_POST['boarding_house_name'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';

    // Add more variables as needed

    // Update the boarding house details
    $update_query = "UPDATE boarding_house SET
                     boarding_house_name = ?,
                     address = ?,
                     description = ?
                     WHERE owner_id = ?";

    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("sssi", $boarding_house_name, $address, $description, $owner_id);

    if ($update_stmt->execute()) {
        // Success: Return a JSON response
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode(['success' => true]);
    } else {
        // Error: Return a JSON response with the error message
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'An unexpected error occurred.']);
    }

    $update_stmt->close();
    $conn->close();
} else {
    // Redirect if accessed directly
    header("Location: ../index.php");
    exit;
}
?>
