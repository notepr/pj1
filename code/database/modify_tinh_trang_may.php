<?php

require_once "connect_dtb.php";

if (isset($_GET['ma_may'])) {
	$ma_may = $_GET['ma_may'];
}

if (isset($_GET['tinh_trang'])) {
	$tinh_trang = $_GET['tinh_trang'];
}

if ($tinh_trang == 1) {
	$tinh_trang = 2;
} else {
	$tinh_trang = 1;
}

echo $tinh_trang;

$sql = "update may set tinh_trang = '$tinh_trang' where ma_may = '$ma_may'";

mysqli_query($connect, $sql);

mysqli_close($connect);
?>