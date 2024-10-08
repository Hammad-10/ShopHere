<?php



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


class Cartajax extends Database
{


    public function cartAjax()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {



            $custId = $_SESSION['customerId'];

            $sqlO = "SELECT * FROM `Orders` where `cust_id`='$custId' and `status`='que' ";

            $resultO = $this->db->query($sqlO);

            $row = $resultO->fetch_assoc();

            $order_sno = $row['order_sno'];




            // Get the raw POST data
            $json = file_get_contents('php://input');

            // Decode the JSON data
            $data = json_decode($json, true);

            // Extract user ID, product ID, and quantity from the decoded data

            $productsno = $data['productsno'];
            $quantity = $data['quantity'];
            $productprice = $data['productprice'];


            // update the quantity of the product if it is already added in the cart
            $sql1 = "SELECT * from `OrderItems` where `product_sno`='$productsno'";
            $result1 = $this->db->query($sql1);
            $row1 = $result1->fetch_assoc();

          


            if($result1->num_rows > 0){

                $subtotal = $row1['subtotal'];
                $quantityU = $row1['quantity'];

                $sqlUpdate = "UPDATE `OrderItems` SET `quantity` = " . ($quantityU + 1) . ", `subtotal` = ".($subtotal+$productprice)." WHERE `product_sno` = '$productsno'";
                $resultUpdate = $this->db->query($sqlUpdate);
            }
            

       

            // query to insert the cart item
            $sql = "INSERT INTO OrderItems (order_sno, product_sno, quantity, subtotal) VALUES ('$order_sno', '$productsno', '$quantity', '$productprice')";
            $result = $this->db->query($sql);

            if ($result) {
                // Send a success response
                echo json_encode(['status' => 'success', 'message' => 'Product added to cart']);
            } else {
                // Send an error response
                echo json_encode(['status' => 'error', 'message' => 'Failed to add product to cart']);
            }
        }
    }

    public function removeCartItem(){

        $json = file_get_contents('php://input');

        // Decode the JSON data
        $data = json_decode($json, true);

        $product_sno = $data['product_sno'];

        $sql = "DELETE from `OrderItems` where `product_sno`='$product_sno'";
        $result = $this->db->query($sql);

        if ($result) {
            // Send a success response
            echo json_encode(['status' => 'success', 'message' => 'Product added to cart']);
        } else {
            // Send an error response
            echo json_encode(['status' => 'error', 'message' => 'Failed to add product to cart']);
        }

    }
}
