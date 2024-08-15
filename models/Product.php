<?php

class Product extends Database
{

    public function newCategory($categName)
    {

        try {
            $sql = "INSERT INTO ProductCategories (categName) VALUES (?)";
            $stmt = $this->db->prepare($sql);

            if ($stmt === false) {
                throw new Exception("Prepare statement failed: " . $this->db->error);
            }

            $stmt->bind_param("s", $categName);

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


    public function categoryDelete($categId)
    {
        $sql = "DELETE from `ProductCategories` where `categId`='$categId'";
        $result = $this->db->query($sql);
    }

    public function displayCategories()
    {

        try {
            $sql = "SELECT * from `ProductCategories`";
            $result = $this->db->query($sql);

            if (!$result) {
                throw new Exception("Query failed: " . $this->db->error);
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

    public function linkProductToCategory($sku, $categId)
    {
        try {
            // getting sno of the inserted product
            $sql = "SELECT * from `Products` where `sku`='$sku'";
            $result = $this->db->query($sql);

            if ($result) {
                $row = $result->fetch_assoc();

                $sql = "INSERT INTO ProductCategoryLink (categId, Productsno) VALUES (?, ?)";
                $stmt = $this->db->prepare($sql);

                if (!$stmt) {
                    throw new Exception("Prepare statement failed: " . $this->db->error);
                }

                $stmt->bind_param("ii", $categId, $row['sno']);


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



    // admin view all products

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


    // admin view all products category wise

    public function displayProdCategWise($categId, $categName)
    {
        try {
            $bootstrapLinks = '
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>';

            $sql = "SELECT * FROM Products inner join ProductCategoryLink on `Products`.`sno`=`ProductCategoryLink`.`Productsno` where `ProductCategoryLink`.`categId`= '$categId'";

            $result = $this->db->query($sql);

            if (!$result) {
                throw new Exception("Query failed: " . $this->db->error);
            }

            echo '<h3 style = "margin-left:550px; margin-top: 25px; margin-bottom:25px">' . $categName . '</h3>';

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




    // admin view all customers

    public function displayCustomers()
    {
        try {
            $bootstrapLinks = '
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>';

            $sql = "SELECT * FROM Customer";
            $result = $this->db->query($sql);

            if (!$result) {
                throw new Exception("Query failed: " . $this->db->error);
            }

            echo '<h3 class="text-center my-3">Customers</h3>';

            // Start generating the output
            $output = $bootstrapLinks . '
            <div class="d-flex justify-content-center">
                <table class="table table-bordered w-auto">
                    <thead>
                        <tr>
                            <th scope="col">CUSTOMER ID</th>
                            <th scope="col">CUSTOMER NAME</th>
                        </tr>
                    </thead>
                    <tbody>';

            // Generate table rows
            while ($row = $result->fetch_assoc()) {
                $output .= '<tr>';
                $output .= '<td>' . htmlspecialchars($row["customerId"]) . '</td>';
                $output .= '<td>' . htmlspecialchars($row["customerName"]) . '</td>';
                $output .= '</tr>';
            }

            $output .= '</tbody>
                </table>
            </div>';

            return $output;
        } catch (Exception $e) {
            // Handle the exception        
            // case 'checkout':
            //     $orders = (new Product())->getOrders();
            //     include '/var/www/html/ptest/ShopHere/views/checkout.html';
            //     break;
        }
    }

    // admin view all Orders

    public function displayOrders()
    {
        try {
            $bootstrapLinks = '
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
          <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>';

            $sql = "SELECT orderId FROM Orders group by orderId";
            $result = $this->db->query($sql);

            if (!$result) {
                throw new Exception("Query failed: " . $this->db->error);
            }

            echo '<h3 class="text-center my-3">Orders</h3>';

            // Start generating the output
            $output = $bootstrapLinks . '
          <div class="d-flex justify-content-center">
              <table class="table table-bordered w-auto">
                  <thead>
                      <tr>
                          <th scope="col">ORDER ID</th>
                           <th scope="col">ACTION</th>
                         
                      </tr>
                  </thead>
                  <tbody>';

            // Generate table rows
            while ($row = $result->fetch_assoc()) {
                $output .= '<tr>';
                $output .= '<td>' . htmlspecialchars($row["orderId"]) . '</td>';
                $output .= '<td><a href="routes.php?page=View_specificOrder&orderId=' . urlencode($row['orderId']) . '" class="view btn btn-sm btn-primary">View</a></td>';
  
                $output .= '</tr>';
            }

            $output .= '</tbody>
              </table>
          </div>';

            return $output;
        } catch (Exception $e) {
            // Handle the exception
            return 'An error occurred while displaying customers: ' . $e->getMessage();
        }
    }



    // customer  view orders info in checkout

    public function checkoutOrdersInfo()
    {
        try {

         

            $cust_id = $_SESSION['customerId'];
            $sql = "SELECT Products.*, ProductImages.image, OrderItems.*
            FROM Products
            INNER JOIN ProductImages ON Products.sno = ProductImages.sno
            INNER JOIN OrderItems ON Products.sno = OrderItems.product_sno inner join `Orders` on `Orders`.`order_sno` = `OrderItems`.`order_sno` where `Orders`.`cust_id` = '$cust_id'";
            
            $result = $this->db->query($sql);

            if (!$result) {
                throw new Exception("Query failed: " . $this->db->error);
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




    //customer view all products

    public function displayProducts()
    {
        try {


            $sql = "SELECT p.sno, p.sku, p.name, p.price, GROUP_CONCAT(pi.image) AS images
                    FROM Products p
                    LEFT JOIN ProductImages pi ON p.sno = pi.sno
                    GROUP BY p.sno, p.sku, p.name, p.price";
            $result = $this->db->query($sql);

            if (!$result) {
                throw new Exception("Query failed: " . $this->db->error);
            }

            return $result;
        } catch (Exception $e) {
            // Handle the exception
            return 'An error occurred while displaying products: ' . $e->getMessage();
        }
    }

    // specific product for admin
    public function displaySpecificProduct($sno)
    {
        try {
            $sql = "SELECT * FROM `Products` inner join `ProductCategoryLink` on  `ProductCategoryLink`.`Productsno` = '$sno' and `Products`.`sno` = '$sno' inner join `ProductCategories` on `ProductCategoryLink`.`categId` = `ProductCategories`.`categId`";
            $result = $this->db->query($sql);

            return $result->fetch_assoc();

            // if (!$stmt) {
            //     throw new Exception("Prepare statement failed: " . $this->db->error);
            // }

            // $stmt->bind_param("s", $sno);

            // if (!$stmt->execute()) {
            //     throw new Exception("Execute failed: " . $stmt->error);
            // }

            // $result = $stmt->get_result();

            // if ($result === false) {
            //     throw new Exception("Get result failed: " . $stmt->error);
            // }

            
        } catch (Exception $e) {
            // Handle the exception
            echo 'An error occurred while fetching the product: ' . $e->getMessage();
            return false;
        }
    }


     // specific order for admin
     public function displaySpecificOrder($orderId)
     {
         try {
             $sql = "SELECT * FROM `Orders` WHERE `orderId` = ?";
             $stmt = $this->db->prepare($sql);
 
             if (!$stmt) {
                 throw new Exception("Prepare statement failed: " . $this->db->error);
             }
 
             $stmt->bind_param("s", $orderId);
 
             if (!$stmt->execute()) {
                 throw new Exception("Execute failed: " . $stmt->error);
             }
 
             $result = $stmt->get_result();
 
             if ($result === false) {
                 throw new Exception("Get result failed: " . $stmt->error);
             }
 
             return $result;
         } catch (Exception $e) {
             // Handle the exception
             echo 'An error occurred while fetching the product: ' . $e->getMessage();
             return false;
         }
     }

    //specific product for customer
    public function CustomerSpecificProduct($sno)
    {
        try {
            $sql = "SELECT p.sno, p.sku, p.name, p.price, p.quantity, GROUP_CONCAT(pi.image) AS images
            FROM Products p
            LEFT JOIN ProductImages pi ON p.sno = pi.sno
            WHERE p.sno = '$sno'
            GROUP BY p.sno, p.sku, p.name, p.price";


            $result = $this->db->query($sql);

            // if (!$stmt) {
            //     throw new Exception("Prepare statement failed: " . $this->db->error);
            // }

            // $stmt->bind_param("s", $sno);

            // if (!$stmt->execute()) {
            //     throw new Exception("Execute failed: " . $stmt->error);
            // }

            // $result = $stmt->get_result();

            // if ($result === false) {
            //     throw new Exception("Get result failed: " . $stmt->error);
            // }

            return $result->fetch_assoc();
        } catch (Exception $e) {
            // Handle the exception
            echo 'An error occurred while fetching the product: ' . $e->getMessage();
            return false;
        }
    }



    public function updateProduct($categName, $sno, $sku, $name, $price, $quantity)
    {
        try {
            $sql = "UPDATE Products SET sku = ?, name = ?, price = ?, quantity = ? WHERE sno = ?";
            $stmt = $this->db->prepare($sql);

            $sql2 = "SELECT * from ProductCategories where `categName`='$categName'";
            $result2 = $this->db->query($sql2);
            $row = $result2->fetch_assoc();

            $categId = $row['categId'];



            $sql3 = "UPDATE `ProductCategoryLink` set `categId`='$categId' where `Productsno`='$sno'";
            $result3 = $this->db->query($sql3);

            if (!$stmt) {
                throw new Exception("Prepare statement failed: " . $this->db->error);
            }

            $stmt->bind_param('ssiii', $sku, $name, $price, $quantity, $sno);

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

    

    public function getOrderItems(){

        try {

            $cust_id = $_SESSION['customerId'];
            $sql = "SELECT Products.*, ProductImages.image, OrderItems.*
            FROM Products
            INNER JOIN ProductImages ON Products.sno = ProductImages.sno
            INNER JOIN OrderItems ON Products.sno = OrderItems.product_sno inner join `Orders` on `Orders`.`order_sno` = `OrderItems`.`order_sno` where `Orders`.`cust_id` = '$cust_id'";
            
            $result = $this->db->query($sql);

            if (!$result) {
                throw new Exception("Query failed: " . $this->db->error);
            }

            return $result;
        } catch (Exception $e) {
            // Handle the exception
            return 'An error occurred while displaying products: ' . $e->getMessage();
        }

    } 

    public function updateOrders(){
        $cust_id = $_SESSION['customerId'];
        $total = $_SESSION['total'];

        $sql = "UPDATE `Orders` set `status`='placed', `grandTotal` = '$total' where `cust_id`='$cust_id'";
        $result = $this->db->query($sql);

        $sql1 = "DELETE from `OrderItems`";
        $result1 = $this->db->query($sql1);

    }
}
