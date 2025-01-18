<?php

// namespace Config;

// use mysqli;

class Database{
    private $host="localhost";
    private $user="root";
    private $password="";
    private $db="task_api";

    private $conn;

    public function __construct(){
        
        $this->conn = new mysqli($this->host,$this->user,$this->password,$this->db);
         if($this->conn->connect_error){
            die(
                json_encode(["error_message"=>"connection failed!"])
            );
        }

    }

    public function getConnection(){
        return $this->conn;
    }
}






?>