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
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];
        }

        $this->productModel->insertProduct($sku, $price, $quantity);
    }


    

 


}