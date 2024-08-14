

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
            $customerId = $data['customerId'];
            $customerPassword = $data['customerPassword'];

            $sql = "SELECT * FROM Customer WHERE customerId='$customerId' AND CustomerPassword='$customerPassword'";
            $result = $this->db->query($sql);

            if ($result->num_rows > 0) {

                // session_start();

                $_SESSION['customerId'] = $customerId;




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
