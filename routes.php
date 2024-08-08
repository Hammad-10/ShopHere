<?php
session_start();

require 'models/Database.php';
require 'models/Product.php';

require 'controllers/ProductController.php';
require 'controllers/AuthController.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {
    case 'adminDashboard':
        (new ProductController())->adminDashboard();
        break;
    case 'View_specificProduct':
        $sno = htmlspecialchars($_GET['sno']);
        (new ProductController())->specificProduct($sno);
        break;   
    case 'update_delete':
        (new ProductController())->updateDelete();
        break;
    case 'viewAllProducts':
        (new ProductController())->viewAllProducts();
        break; 
    case 'admin_logout':
        (new AuthController())->adminLogout();
        break; 
    default:
        include 'index.html';
        break;
}
?>
