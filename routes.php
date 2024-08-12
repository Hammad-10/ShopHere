<?php
session_start();

require 'models/Database.php';
require 'models/Product.php';

require 'controllers/ProductController.php';
require 'controllers/AuthController.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {

    case 'adminDashboard':
        $categories = (new Product())->displayCategories();
        include 'C:\xampp\htdocs\ptest\ShopHere\views\admin\adminDashboard.html';
        break;    

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

    case 'deleteCategory':
        $categId = htmlspecialchars($_GET['categoryId']);
        (new ProductController())->deleteCategory($categId);
        break;
       
    case 'categories':
        $categories = (new Product())->displayCategories();
        include 'C:\xampp\htdocs\ptest\ShopHere\views\admin\categories.html';
        break;
        
    case 'productCategWise':
        $categId = htmlspecialchars($_GET['categoryId']);
        $categName = htmlspecialchars($_GET['categoryName']);
        (new ProductController())->productCategWise($categId, $categName);
        break;   
        
    case 'update_delete':
        (new ProductController())->updateDelete();
        break;
    case 'viewAllProducts':
        (new ProductController())->viewAllProducts();
        break; 

    case 'viewAllCustomers':
        (new ProductController())->viewAllCustomers();
        break;

    case 'viewAllOrders':
        (new ProductController())->viewAllOrders();
        break;

    case 'addNewCategory':
        (new ProductController())->addNewCategory();
        break; 
        
    case 'showProducts':
        $result = (new ProductController())->showProducts();
        include '/ptest/ShopHere/views/categoryListing.html';
        break;         

    case 'admin_logout':
        (new AuthController())->adminLogout();
        break; 

    case 'customer_logout':
        (new AuthController())->customerLogout();
        break;
        
    case 'checkout':
        $orders = (new Product())->checkoutOrdersInfo();
        include '/ptest/ShopHere/views/checkout.html';
        break;

    default:
        include 'index.html';
        break;
}
?>
