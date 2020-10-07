<?php
require_once "connect_dtb.php";

if (isset($_GET['ten_may'])) {
	$ten_may = $_GET['ten_may'];
}
if (isset($_GET['ma_cau_hinh'])) {
	$ma_cau_hinh = $_GET['ma_cau_hinh'];
}
if (isset($_GET['ma_phong'])) {
	$ma_phong = $_GET['ma_phong'];
}

echo $ten_may;

echo $ma_cau_hinh;

echo $ma_phong;

$sql = "insert into may (ten_may, ma_cau_hinh, tinh_trang, ma_phong) values ('$ten_may', '$ma_cau_hinh', 1, '$ma_phong') ";

mysqli_query($connect, $sql);

mysqli_close($connect);
?>