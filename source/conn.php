<?php
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPass = "";
    $dbName = "duniafilm_db";

    $conn = mysqli_connect($dbHost,$dbUser,$dbPass,$dbName);

    if (!$conn) {
       die("Connection to database failed!");
    }
?>