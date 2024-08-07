<?php
session_start();

require 'controllers/ProductController.php';
require 'models/Database.php';
require 'models/Product.php';




$page = isset($_GET['page']) ? $_GET['page'] : 'home';


switch ($page) {
    case 'insertProduct':
        (new ProductController())->insertProduct();
        break;
 

    default:
        include 'index.html';
        break;
}
?>