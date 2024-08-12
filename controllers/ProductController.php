<?php

$insert = false;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ProductController
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }


    // admin view all products
    public function viewAllProducts(){
        echo $this->productModel->display();

    }

     // admin view all products category wise
     public function productCategWise($categId, $categName){
        echo $this->productModel->displayProdCategWise($categId, $categName);

    }

    // admin view all customers
    public function viewAllCustomers(){
        echo $this->productModel->displayCustomers();

    }

    // admin view all products
    public function viewAllOrders(){
        echo $this->productModel->displayOrders();
    
    }



    // customer view all products
    public function showProducts()
    {
    
      

        return $this->productModel->displayProducts();

        include '/ptest/ShopHere/views/footer.html';
    }

    // public function adminDashboard()
    // {
    //     try {
    //         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //             $result = $this->insertProduct();

    //             if($result){
    //             $insert = $result;
    //             }
    //         }

    //         include '/var/www/html/ptest/ShopHere/views/admin/adminDashboard.html';
        
            
    //     } catch (Exception $e) {
    //         $error = 'An error occurred: ' . $e->getMessage();
    //         include '/var/www/html/ptest/ShopHere/views/admin/adminDashboard.html';
    //         echo '<div style="color: red;">' . htmlspecialchars($error) . '</div>';
    //     }
    // }

    public function addNewCategory(){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $categName = $_POST['categoryName'];

            $this->productModel->newCategory($categName);

            $categories = $this->productModel->displayCategories();
            include 'C:\xampp\htdocs\ptest\ShopHere\views\admin\categories.html';
        }

        else{
            $categories = $this->productModel->displayCategories();
            include 'C:\xampp\htdocs\ptest\ShopHere\views\admin\categories.html';
        }

    }

    public function deleteCategory($categId){

        $this->productModel->categoryDelete($categId);

    }

    public function insertProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $selectedCategories = $_POST['category']; // This will be an array
            $sku = $_POST['sku'];
            $productname = $_POST['productname'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];
    
            // Insert product details into the database
            $this->productModel->insertProduct($sku, $productname, $price, $quantity);
    
            // Loop through each selected category and link it to the product
            foreach ($selectedCategories as $categId) {
                $this->productModel->linkProductToCategory($sku, $categId);
            }
    
            $targetDir = "ProductImagesUpload/";
    
            if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
                $totalFiles = count($_FILES['images']['name']);
    
                for ($i = 0; $i < $totalFiles; $i++) {
                    $targetFile = $targetDir . basename($_FILES['images']['name'][$i]);
    
                    if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $targetFile)) {
                        $imagePath = $targetFile;
                        $this->insertProductImage($sku, $imagePath);
                    } else {
                        echo "Sorry, there was an error uploading the file " . basename($_FILES['images']['name'][$i]) . ".<br>";
                    }
                }
            }
        }
    }
    

    private function insertProductImage($sku, $imagePath)
    {
       
        $this->productModel->insertProductImage($sku, $imagePath);
    }



    public function specificProduct($sno)
    {
        try {
            $result = $this->productModel->displaySpecificProduct($sno);
            if ($result) {
                // session_start();
                $_SESSION['sno'] = $result['sno'];
                $_SESSION['sku'] = $result['sku'];
                $_SESSION['name'] = $result['name'];
                $_SESSION['price'] = $result['price'];
                $_SESSION['quantity'] = $result['quantity'];
                $_SESSION['image'] = $result['image'];
                // echo $_SESSION['sku'];
                header('Location: /ptest/ShopHere/views/admin/viewSpecificProduct.php');
                exit();
            }
        } catch (Exception $e) {
            // Handle the exception
            $error = 'An error occurred: ' . $e->getMessage();
            exit();
        }
    }


    // specific product for customer


    public function Customer_specificProduct($sno)
    {
        try {
            $result = $this->productModel->CustomerSpecificProduct($sno);
            if ($result) {
                // session_start();
                $_SESSION['sno'] = $result['sno'];
                $_SESSION['sku'] = $result['sku'];
                $_SESSION['name'] = $result['name'];
                $_SESSION['price'] = $result['price'];
                $_SESSION['quantity'] = $result['quantity'];
                $_SESSION['images'] = $result['images'];
                // echo $_SESSION['sku'];

                // i am here now just take data to customer/Product.html
                include '/ptest/ShopHere/views/Product.html';
                
                // header('Location: /ptest/ShopHere/views/');
                exit();
            }
        } catch (Exception $e) {
            // Handle the exception
            $error = 'An error occurred: ' . $e->getMessage();
            exit();
        }
    }



    public function updateDelete()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $sno = $_POST['sno'];
                $action = $_POST['action'];

                $sku = $_POST['sku'];
                $name = $_POST['productname'];

                $price = $_POST['price'];
                $quantity = $_POST['quantity'];

                if ($action == 'update') {
                   
                    $this->updateProduct($sno, $sku, $name, $price, $quantity);

                } else if ($action == 'delete') {
                    $this->deleteProduct($sno);
                } else {
                    throw new Exception('Invalid action specified.');
                }
            }
        } catch (Exception $e) {
            // Handle the exception
            $error = 'An error occurred: ' . $e->getMessage();


            echo '<div style="color: red;">' . htmlspecialchars($error) . '</div>';
        }
    }

    private function updateProduct($sno, $sku, $name, $price, $quantity)
    {
        try {
            $resultupdate = $this->productModel->updateProduct($sno, $sku, $name, $price, $quantity);

            if ($resultupdate) {
                echo 'Product updated';
            } else {
                throw new Exception('Error updating product');
            }
        } catch (Exception $e) {
            // Handle the exception
            $error = 'An error occurred while updating the product: ' . $e->getMessage();

            echo '<div style="color: red;">' . htmlspecialchars($error) . '</div>';
        }
    }

    private function deleteProduct($sno)
    {
        try {
            $resultdelete = $this->productModel->deleteProduct($sno);

            if ($resultdelete) {
                echo 'Product deleted';
            } else {
                throw new Exception('Error deleting product');
            }
        } catch (Exception $e) {
            // Handle the exception
            $error = 'An error occurred while deleting the product: ' . $e->getMessage();

            echo '<div style="color: red;">' . htmlspecialchars($error) . '</div>';
        }
    }

}
?>
