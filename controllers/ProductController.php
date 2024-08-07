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

    public function adminDashboard()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $this->insertProduct();
            }

            $productList = $this->productModel->display();
            include '/var/www/html/ptest/ShopHere/views/admin/adminDashboard.html';
        } catch (Exception $e) {
            $error = 'An error occurred: ' . $e->getMessage();
            include '/var/www/html/ptest/ShopHere/views/admin/adminDashboard.html';
            echo '<div style="color: red;">' . htmlspecialchars($error) . '</div>';
        }
    }

    public function insertProduct()
    {
        $sku = $_POST['sku'];
        $productname = $_POST['productname'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];

        $this->productModel->insertProduct($sku, $productname, $price, $quantity);

        $targetDir = "/var/www/html/ptest/ShopHere/ProductImagesUpload/";

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

    private function insertProductImage($sku, $imagePath)
    {
        $this->productModel->insertProductImage($sku, $imagePath);
    }
}
?>
