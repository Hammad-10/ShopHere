<?php

class Database
{
    private $host = 'localhost';
    private $user = 'root';
    private $pass = 'MyStrongPassword1234$';
    private $dbname = 'ShopHere';

    public function __construct()
    {
        try {
            $mysqli = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
    
            if ($mysqli->connect_error) {
                throw new Exception("Connection failed: " . $mysqli->connect_error);
            }
            
            return $mysqli;
        } catch (Exception $e) {
            die('An error occurred while connecting to the database: ' . $e->getMessage());
        }
    }
    
}
?>