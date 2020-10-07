<?php
require_once "connect_dtb.php";

if (isset($_GET['ma_phong'])) {
	$ma_phong = $_GET['ma_phong'];
}

if (isset($_GET['tinh_trang'])) {
	$tinh_trang = $_GET['tinh_trang'];
}

if ($tinh_trang == 1) {
	$tinh_trang = 2;
} else {
	$tinh_trang = 1;
}

$sql = "update phong set tinh_trang = '$tinh_trang' where ma_phong = '$ma_phong'";

mysqli_query($connect, $sql);

mysqli_close($connect);

?>