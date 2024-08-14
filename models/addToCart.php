

<?php

session_start();

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
    $orderData = json_decode(file_get_contents('php://input'), true);

    // Extract username and password from the decoded data
    $customerId = $_SESSION['customerId'];

    $orderId = "OD".$customerId;



    // Insert each item into the Orders table
    foreach ($orderData['cartItems'] as $item) {
        $productName = $item['title'];
        $price = $item['price'];
        $date = date('Y-m-d H:i:s');

        $sql = "INSERT INTO Orders ( orderId, product, price, customerId, datetime) VALUES ('$orderId','$productName' , '$price', '$customerId', '$date')";
        $result = mysqli_query($conn, $sql);
    }


    if ($result) {

        // session_start();

        // $_SESSION['adminId'] = $adminId;
     
        // If the user exists, send a success response
        echo json_encode(['status' => 'success', 'message' => 'Entry successful']);
    } else {
        // If the user does not exist, send an error response
        echo json_encode(['status' => 'error', 'message' => 'Entry failed']);
    }
}


?>
