<?php
class ConnectionDB{
    private $conn;
    
    function __construct($user, $password, $host, $database){
        $this->conn=new mysqli($host, $user, $password,$database);
        if($this->conn->connect_error){
            die('Error al conectar con MySQL');
        }
        $this->conn->set_charset("utf8mb4");
    }

    function getConnection(){
        return $this->conn;
    }
}