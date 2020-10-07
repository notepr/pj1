<?php
$servername = "localhost";
$username   = "admin";
$password   = "8a2bef85c8cc8c69e";
$database   = "bkacad";

$connect = mysqli_connect($servername, $username, $password, $database);

mysqli_set_charset($connect, "utf8");
?>