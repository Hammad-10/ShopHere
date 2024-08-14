

<?php


$host = 'localhost';
$user = 'root';
$pass = 'MyStrongPassword1234$';
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
    $adminName = $data['adminName'];
    $adminPassword = $data['adminPassword'];

    // Construct the SQL query to insert the new user
    $sql = "INSERT INTO Admin (adminId, adminName, adminPassword) VALUES ('$adminId', '$adminName', '$adminPassword')";

    // Execute the SQL query
    $result = mysqli_query($conn, $sql);

    // Check the result of the query
    if ($result) {
        // If the query was successful, send a success response
        echo json_encode(['status' => 'success', 'message' => 'User registered successfully']);
    } else {
        // If the query failed, send an error response
        echo json_encode(['status' => 'error', 'message' => 'Failed to insert record']);
    }
}
?>
