<?php
session_start();

require 'models/Database.php';
require 'models/Product.php';

require 'controllers/ProductController.php';
require 'controllers/AuthController.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';


switch ($page) {
    case 'insertProduct':
        (new ProductController())->insertProduct();
        break;
    case 'View_specificProduct':
        $sno = htmlspecialchars($_GET['sno']);
        (new ProductController())->specificProduct($sno);
        break;
        
    case 'Customer_specificProduct':
        $sno = htmlspecialchars($_GET['sno']);
        (new ProductController())->Customer_specificProduct($sno);
        break;
        
        
    case 'update_delete':
        (new ProductController())->updateDelete();
        break;
    case 'viewAllProducts':
        (new ProductController())->viewAllProducts();
        break; 
        
    case 'showProducts':
        $result = (new ProductController())->showProducts();
        include '/var/www/html/ptest/ShopHere/views/categoryListing.html';
        
        break;         
    case 'admin_logout':
        (new AuthController())->adminLogout();
        break; 
    case 'showProducts':
        (new ProductController())->showProducts();
        break; 
    default:
        include 'index.html';
        break;
}
?>
