

<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'ShopHere';

// Connect to the database
$conn = mysqli_connect($host, $user, $pass, $dbname);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the raw POST data
    $json = file_get_contents('php://input');

    // Decode the JSON data
    $data = json_decode($json, true);

    // Extract username and password from the decoded data
    $adminId = $data['adminId'];
    $adminPassword = $data['adminPassword'];

    $sql = "SELECT * FROM Admin WHERE adminId='$adminId' AND adminPassword='$adminPassword'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

        session_start();

        $_SESSION['adminId'] = $adminId;
     
        // If the user exists, send a success response
        echo json_encode(['status' => 'success', 'message' => 'Login successful']);
    } else {
        // If the user does not exist, send an error response
        echo json_encode(['status' => 'error', 'message' => 'Invalid username or password']);
    }
}


?>
