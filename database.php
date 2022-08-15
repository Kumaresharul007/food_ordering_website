<?php
    $hostname = "localhost:3307";
    $username = "root";
    $password = "admin";
    $database = "foodie";

    $conn = mysqli_connect($hostname, $username, $password, $database);
    if(!$conn){
        die("There is a problem in connecting a database!");
    }
?>