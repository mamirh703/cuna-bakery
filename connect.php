<?php
    $servername = "localhost";
    $userName = "root";
    $password = "";
    $database = "cuna";

    $conn = new mysqli($servername, $userName, $password, $database);

    if ($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
?>