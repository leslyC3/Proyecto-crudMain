<?php
 class Conexion{
    public static function conectar(){
        $servername = "localhost/ 127.0.0.1";
        $username = "mydb:msql://localhost:3036/Pasteleria";
        $password = "";
        $dbname = "PastelesDB";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
        
        
    }
 }