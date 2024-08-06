<?php


class Product extends Database
{
    private $db;

    public function __construct()
    {
        $this->db = parent::__construct();
    }

    public function insertProduct($sku, $price, $quantity)
    {
        try {
            $sql = "INSERT INTO Products (sku, price, quantity) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($sql);

            if ($stmt === false) {
                throw new Exception("Prepare statement failed: " . $this->db->error);
            }

            $stmt->bind_param("sii", $sku, $price, $quantity);

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


}