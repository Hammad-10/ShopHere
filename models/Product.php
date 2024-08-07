<?php


class Product extends Database
{
    private $db;

    public function __construct()
    {
        $this->db = parent::__construct();
    }

    public function insertProduct($sku, $productname, $price, $quantity)
    {
        try {
            $sql = "INSERT INTO Products (sku, name, price, quantity) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);

            if ($stmt === false) {
                throw new Exception("Prepare statement failed: " . $this->db->error);
            }

            $stmt->bind_param("ssii", $sku, $productname, $price, $quantity);

            $result = $stmt->execute();

            if ($result === false) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            return $result;
        } catch (Exception $e) {
            // Handle the exception
            $error = 'An error occurred while inserting the product: ' . $e->getMessage();

            // Optionally, log the error or display it
            echo '<div style="color: red;">' . htmlspecialchars($error) . '</div>';

            return false;
        }
    }

    public function insertProductImage($sku, $imagePath){
        try {

            // getting sno of the inserted product
            $sql = "SELECT * from `Products` where `sku`='$sku'";
            $result = $this->db->query($sql);

            if($result){
                $row = $result->fetch_assoc();

                $sql = "INSERT INTO ProductImages (sno, image) VALUES (?, ?)";
            $stmt = $this->db->prepare($sql);

            if (!$stmt) {
                throw new Exception("Prepare statement failed: " . $this->db->error);
            }

            $stmt->bind_param("is", $row['sno'], $imagePath);
           

            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            return true;
                
            }
            

           


           // inserting Product images
            
        } catch (Exception $e) {
            // Handle the exception
            echo 'An error occurred while updating the product: ' . $e->getMessage();
            return false;
        }

    }


}