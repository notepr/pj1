<?php
require_once "code/database/connect_dtb.php";
function randomKey($length = 256) {
    return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
}
$dem = 0;
if (isset($_GET['user']) && !empty($_GET['user'])) {
    $user = $_GET['user'];
    $user = mysqli_real_escape_string($connect, $user);
    $dem++;
}
if (isset($_GET['password']) && !empty($_GET['password'])) {
    $password = $_GET['password'];
    $password = sha1($password);
    $password = md5($password) . "check";
    $password = sha1($password);
    // die($password);
    $password = mysqli_real_escape_string($connect, $password);
    $dem++;
}
if ($dem == 2) {
    $sql   = "SELECT * FROM `admin` WHERE (username='${user}' OR email='${user}') AND mat_khau='${password}'";
    $array = mysqli_query($connect, $sql);
    if (mysqli_num_rows($array) == 1) {
        $key = randomKey();
        $sql = "UPDATE admin set random_key='$key' WHERE (username='${user}' OR email='${user}') AND mat_khau='${password}'";
        mysqli_query($connect, $sql);
        setcookie('.old.notepr.xyz', $key, time() + 3600 * 30);
        header("location:code/view/home.php");
    } else {
        header("location:index.php");
    }
} else {
    header("location:index.php");
}
; // var_dump($_COOKIE);; // echo $_COOKIE['_bkacad_xyz'];; // echo htmlspecialchars($_COOKIE[".old.notepr.xyz"]);
?>