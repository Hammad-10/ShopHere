<?php
session_start();

require 'models/Database.php';
require 'models/Product.php';

require 'controllers/ProductController.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {
    case 'adminDashboard':
        (new ProductController())->adminDashboard();
        break;
    default:
        include 'index.html';
        break;
}
?>
