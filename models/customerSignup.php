<?php

ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);

class customerSignup extends Database{

    private $db;

    public function __construct()
    {
        $this->db = parent::__construct();
    }

public function customerSignup(){


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get the raw POST data
        $json = file_get_contents('php://input');
    
        // Decode the JSON data
        $data = json_decode($json, true);
    
        // Extract username and password from the decoded data
        $customerId = $data['customerId'];
        $customerName = $data['customerName'];
        $customerPassword = $data['customerPassword'];
    
        // Construct the SQL query to insert the new user
        $sql = "INSERT INTO Customer (customerId, customerName, CustomerPassword) VALUES ('$customerId', '$customerName', '$customerPassword')";
    
        // Execute the SQL query
        $result = $this->db->query($sql);
    
        // Check the result of the query
        if ($result) {
            // If the query was successful, send a success response
            echo json_encode(['status' => 'success', 'message' => 'Customer registered successfully']);
        } else {
            // If the query failed, send an error response
            echo json_encode(['status' => 'error', 'message' => 'Failed to Register customer']);
        }
    }
}



}
?>
