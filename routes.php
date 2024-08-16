<?php
session_start();

require 'models/Database.php';
require 'models/Product.php';
require 'models/Login.php';
require 'models/Signup.php';
require 'models/customerLogin.php';
require 'models/customerSignup.php';
require 'models/cartajax.php';

require 'controllers/ProductController.php';
require 'controllers/AuthController.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {

    case 'adminDashboard':
        $categories = (new Product())->displayCategories();
        include '/var/www/html/ptest/ShopHere/views/admin/adminDashboard.html';
        break;

    case 'insertProduct':
        (new ProductController())->insertProduct();
        break;
    case 'View_specificProduct':
        $sno = htmlspecialchars($_GET['sno']);
        (new ProductController())->specificProduct($sno);
        break;

        //admin view specific order
    case 'View_specificOrder':
        $orderId = htmlspecialchars($_GET['orderId']);
        (new ProductController())->specificOrder($orderId);
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
        include '/var/www/html/ptest/ShopHere/views/admin/categories.html';
        break;

        // admin view products category wise   
    case 'productCategWise':
        $categId = htmlspecialchars($_GET['categoryId']);
        $categName = htmlspecialchars($_GET['categoryName']);
        (new ProductController())->productCategWise($categId, $categName);
        break;

        // customer view products category wise   
    case 'productCategWiseCustomer':
       
        $categId = htmlspecialchars($_GET['categoryId']);
        $categName = htmlspecialchars($_GET['categoryName']);
        $orderitems = (new Product())->getOrderItems();
        $result = (new ProductController())->productCategWiseCustomer($categId, $categName);
        include '/var/www/html/ptest/ShopHere/views/categoryListing.html';

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

        $orderitems = (new Product())->getOrderItems();
        $result = (new ProductController())->showProducts();
        include '/var/www/html/ptest/ShopHere/views/categoryListing.html';
        break;

    
    case 'cartajax':
    
        (new Cartajax())->cartAjax();
        break;

   
    case 'removeCartItem':
        (new Cartajax())->removeCartItem();
        break;

    case 'admin_logout':
        (new AuthController())->adminLogout();
        break;


    case 'admin_Login':
        (new Login())->adminLogin();
        break;

    case 'admin_Signup':
        (new Signup())->adminSignup();
        break;

    case 'customer_Login':
        (new customerLogin())->customerLogin();
        break;

    case 'customer_Signup':
        (new customerSignup())->customerSignup();
        break;

    case 'customer_logout':
        (new AuthController())->customerLogout();
        break;

        // case 'miniCart':


        //     $orderitems = (new Product())->getOrderItems();

        //     include '/var/www/html/ptest/ShopHere/views/miniCart.html';
        //     break;       

    case 'checkout':
        $orders = (new Product())->checkoutOrdersInfo();
        include '/var/www/html/ptest/ShopHere/views/checkout.html';
        break;

    case 'placeOrder':
      
        (new Product())->updateOrders();
        (new Product())->createAnotherOrder();
        include '/var/www/html/ptest/ShopHere/views/orderSuccessFailure.html';
        break;



    case 'index':
        $categories = (new Product())->displayCategoriesCustomer();

        include 'index.html';
        break;
}
