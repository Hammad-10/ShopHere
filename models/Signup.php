

<?php

class Signup extends Database{

public function adminSignup(){

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get the raw POST data
        $json = file_get_contents('php://input');
    
        // Decode the JSON data
        $data = json_decode($json, true);
    
        // Extract username and password from the decoded data
       
        $adminName = $data['adminName'];
        $adminPassword = $data['adminPassword'];
    
        // Construct the SQL query to insert the new user
        $sql = "INSERT INTO Admin (adminName, adminPassword) VALUES ('$adminName', '$adminPassword')";
    
        // Execute the SQL query
        $result = $this->db->query($sql);
    
        // Check the result of the query
        if ($result) {

            
            // If the query was successful, send a success response
            echo json_encode(['status' => 'success', 'message' => 'User registered successfully']);
        } else {
            // If the query failed, send an error response
            echo json_encode(['status' => 'error', 'message' => 'Failed to insert record']);
        }
    }
}


}
?>
