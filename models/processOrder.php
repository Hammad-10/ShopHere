<?php
// processOrder.php

include 'db_connection.php'; // Include your database connection

// Get the cart data from the AJAX request
$cartData = json_decode(file_get_contents('php://input'), true);

if ($cartData) {
    $user_id = $_SESSION['user_id']; // Assuming you have user sessions
    $total_price = calculateTotal($cartData); // Function to calculate total price

    // Insert order into the orders table
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_price, order_date, status) VALUES (?, ?, NOW(), 'Pending')");
    $stmt->bind_param("id", $user_id, $total_price);
    $stmt->execute();

    $order_id = $stmt->insert_id;

    // Insert each item into the order_items table
    foreach ($cartData['items'] as $item) {
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
        $stmt->execute();
    }

    // Return success response
    echo json_encode(['success' => true]);
} else {
    // Return error response
    echo json_encode(['success' => false, 'message' => 'No cart data found']);
}

function calculateTotal($cartData) {
    $total = 0;
    foreach ($cartData['items'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}
?>
