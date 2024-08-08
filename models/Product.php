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

    public function insertProductImage($sku, $imagePath)
    {
        try {

            // getting sno of the inserted product
            $sql = "SELECT * from `Products` where `sku`='$sku'";
            $result = $this->db->query($sql);

            if ($result) {
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

    public function display()
    {
        try {
            $bootstrapLinks = '
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>';
     
            $sql = "SELECT * FROM Products";
            $result = $this->db->query($sql);

            if (!$result) {
                throw new Exception("Query failed: " . $this->db->error);
            }

            echo '<h3 style = "margin-left:550px; margin-top: 25px; margin-bottom:25px"> Products</h3>';

            // Start generating the output
            $output = $bootstrapLinks . '<table class="table">
            <thead>
                <tr>
                    <th scope="col">SKU</th>
                    <th scope="col">NAME</th>
                    <th scope="col">PRICE</th>
                    <th scope="col">QUANTITY</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>';

            // Generate table rows
            while ($row = $result->fetch_assoc()) {
                $output .= '<tr>';
                $output .= '<td>' . htmlspecialchars($row["sku"]) . '</td>';
                $output .= '<td>' . htmlspecialchars($row["name"]) . '</td>';
                $output .= '<td>' . htmlspecialchars($row["price"]) . '</td>';
                $output .= '<td>' . htmlspecialchars($row["quantity"]) . '</td>';
                $output .= '<td><a href="routes.php?page=View_specificProduct&sno=' . urlencode($row['sno']) . '" class="view btn btn-sm btn-primary">View</a></td>';
                $output .= '</tr>';
            }

            $output .= '</tbody>
        </table>';

            return $output;
        } catch (Exception $e) {
            // Handle the exception
            return 'An error occurred while displaying products: ' . $e->getMessage();
        }
    }

    public function displaySpecificProduct($sno)
    {
        try {
            $sql = "SELECT * FROM `Products` WHERE `sno` = ?";
            $stmt = $this->db->prepare($sql);

            if (!$stmt) {
                throw new Exception("Prepare statement failed: " . $this->db->error);
            }

            $stmt->bind_param("s", $sno);

            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            $result = $stmt->get_result();

            if ($result === false) {
                throw new Exception("Get result failed: " . $stmt->error);
            }

            return $result->fetch_assoc();
        } catch (Exception $e) {
            // Handle the exception
            echo 'An error occurred while fetching the product: ' . $e->getMessage();
            return false;
        }
    }

    public function updateProduct($sno, $sku, $name, $price, $quantity)
    {
        try {
            $sql = "UPDATE Products SET sku = ?, name = ?, price = ?, quantity = ? WHERE sno = ?";
            $stmt = $this->db->prepare($sql);

            if (!$stmt) {
                throw new Exception("Prepare statement failed: " . $this->db->error);
            }

            $stmt->bind_param('ssiii', $sku, $name, $price, $quantity,$sno);

            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            return true;
        } catch (Exception $e) {
            // Handle the exception
            echo 'An error occurred while updating the product: ' . $e->getMessage();
            return false;
        }
    }


    public function deleteProduct($sno)
    {
        try {
            $sql = "DELETE FROM Products WHERE sno = ?";
            $stmt = $this->db->prepare($sql);

            if (!$stmt) {
                throw new Exception("Prepare statement failed: " . $this->db->error);
            }

            $stmt->bind_param('i', $sno);

            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            return true;
        } catch (Exception $e) {
            // Handle the exception
            echo 'An error occurred while deleting the product: ' . $e->getMessage();
            return false;
        }
    }




}
