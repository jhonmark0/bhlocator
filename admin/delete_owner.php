<?php
if (isset($_GET['delete_owner'])) {
    $owner_id = $_GET['owner_id'];

    $conn = new mysqli("localhost", "root", "", "bhlocator");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $delete_query = "DELETE FROM boarding_house_owner WHERE owner_id = $owner_id";

    $delete_result = $conn->query($delete_query);

    if ($delete_result) {
        echo "<script>alert('Owner deleted successfully.'); window.location.href = 'bhowner.php';</script>";
    } else {
        echo "<script>alert('Error deleting owner: " . $conn->error . "'); window.location.href = 'bhowner.php';</script>";
    }

    $conn->close();
}
?>
