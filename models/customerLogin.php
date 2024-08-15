

<?php

class customerLogin extends Database
{


    public function customerLogin()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get the raw POST data
            $json = file_get_contents('php://input');

            // Decode the JSON data
            $data = json_decode($json, true);

            // Extract username and password from the decoded data
            $customerName = $data['customerName'];
            $customerPassword = $data['customerPassword'];





            $sql = "SELECT * FROM Customer WHERE customerName='$customerName' AND CustomerPassword='$customerPassword'";
            $result = $this->db->query($sql);


            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                // session_start();
                $customerId = $row['customerId'];

                $_SESSION['customerId'] = $customerId;


                $sqlO = "SELECT * FROM `Orders` WHERE `cust_id`='$customerId' AND `status`='que'";


                $resultO = $this->db->query($sqlO);

                if ($resultO->num_rows == 0) {

                    $orderId = "OD" . $customerName;


                    $sqlOO = "INSERT into `Orders` (`orderId`, `cust_id`, `status`, `grandTotal`) VALUES ('$orderId', '$customerId', 'que', 0)";

                    $resultOO = $this->db->query($sqlOO);
                }




                // If the user exists, send a success response
                echo json_encode(['status' => 'success', 'message' => 'Login successful']);
            } else {
                // If the user does not exist, send an error response
                echo json_encode(['status' => 'error', 'message' => 'Invalid username or password']);
            }
        }
    }
}
?>
