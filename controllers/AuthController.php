<?php

$insert = false;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class AuthController
{
    public function adminLogout(){

       
        session_start();
        session_unset();
        session_destroy();

        header('location: \ptest\ShopHere\views\admin\adminLogin.html');
    }

    public function customerLogout(){
        session_start();
        session_unset();
        session_destroy();

        header('location: \ptest\ShopHere\views\customer\customerLogin.html');
    }
}
?>
