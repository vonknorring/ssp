<?php
    $server = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "ssp";


    $conn = mysqli_connect($server, $user, $pass, $dbname);
    if(!$conn) {
        die("connection failure:" . mysqli_connect_error());}
        

?>