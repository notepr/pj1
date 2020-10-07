<?php
require_once "connect_dtb_bkacad.php";

$sql = "select * from can_bo";

$result = mysqli_query($connect, $sql);

mysqli_close($connect);
?>