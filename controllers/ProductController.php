<?php


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

  

    public function insertProduct()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){


            $sku = $_POST['sku'];
            $productname = $_POST['productname'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];

            $this->productModel->insertProduct($sku,$productname, $price, $quantity);

    

             // Directory where the uploaded files will be moved
             $targetDir = "/var/www/html/ptest/ShopHere/ProductImagesUpload/";


             if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {

                

                
                $totalFiles = count($_FILES['images']['name']);

              
                
        
                for ($i = 0; $i < $totalFiles; $i++) {
                    // Set the target file path for each file
                    $targetFile = $targetDir . basename($_FILES['images']['name'][$i]);
                    
                    // Move the uploaded file to the target directory
                    if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $targetFile)) {
                        // Bind parameters and execute the statement
                 
                        // $sno = $_POST['sno'];       
                        $imagePath = $targetFile;

                        $this->insertProductImage($sku, $imagePath);
        

                    } else {
                        echo "Sorry, there was an error uploading the file " . basename($_FILES['images']['name'][$i]) . ".<br>";
                    }
                }
            }
        }

       
    }


    private function insertProductImage($sno, $imagePath){
        $this->productModel->insertProductImage($sno, $imagePath);


    }


    

 


}