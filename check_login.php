<?php

require_once "code/database/connect_dtb.php";
$cookie_name = "_old.notepr.xyz";
if (isset($_COOKIE[$cookie_name])) {
    $cookie = mysqli_real_escape_string($connect, $_COOKIE[$cookie_name]);
    $sql    = "SELECT * from admin where random_key='${cookie}'";
    $array  = mysqli_query($connect, $sql);
    if (mysqli_num_rows($array) == 1) {
    } else {
        header("location:../../index.php");
    }
} else {
    header("location:../../index.php");
}
?>