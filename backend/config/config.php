<?php

function connectDB(){

    // Load environment variables
    $host = $_ENV['DB_HOST'];
    $user = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASSWORD'];
    $dbname = $_ENV['DB_DBNAME'];


    $conn = new mysqli($host, $user, $password, $dbname);
    
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

?>