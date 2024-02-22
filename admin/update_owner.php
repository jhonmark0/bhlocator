<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "bhlocator";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'editOwner') {
    $owner_id = $_POST['owner_id'];
    $owner_name = $_POST['owner_name'];
    $boarding_house_name = $_POST['boarding_house_name'];
    $contact_number = $_POST['contact_number'];
    $address = $_POST['address'];
    $email_address = $_POST['email_address'];
    $account_status = $_POST['account_status'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Update the owner information in the database
    $updateQuery = "UPDATE boarding_house_owner
                    SET owner_name = '$owner_name', boarding_house_name = '$boarding_house_name', 
                        contact_number = '$contact_number', address = '$address', 
                        email_address = '$email_address', account_status = '$account_status', 
                        username = '$username', password = '$password'
                    WHERE owner_id = $owner_id";

    if ($conn->query($updateQuery) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Owner information updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error updating owner information: " . $conn->error]);
    }
}

$conn->close();
?>
