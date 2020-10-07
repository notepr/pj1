<?php
require_once "connect_dtb.php";

if (isset($_GET['ma_phong'])) {
	$ma_phong = $_GET['ma_phong'];
}

if (isset($_GET['ten_phong'])) {
	$ten_phong = $_GET['ten_phong'];
}

if (isset($_GET['so_cho_ngoi'])) {
	$so_cho_ngoi = $_GET['so_cho_ngoi'];
}

if (isset($_GET['ma_cau_hinh'])) {
	$ma_cau_hinh = $_GET['ma_cau_hinh'];
}

$sql = "update phong set ten_phong = '$ten_phong', so_cho_ngoi = '$so_cho_ngoi', ma_cau_hinh='$ma_cau_hinh' where ma_phong = '$ma_phong'";

mysqli_query($connect, $sql);

$sql = "delete from may where ma_phong = '$ma_phong'";

mysqli_query($connect, $sql);

$ten_may = $ma_phong . 'M';

for($i = 1; $i <= $so_cho_ngoi; $i++) {
	$ma_ten_may = $ten_may . $i; 
	$sql = "insert into may (ten_may, ma_cau_hinh, tinh_trang, ma_phong) values ('$ma_ten_may', '$ma_cau_hinh', 1, '$ma_phong')";
	mysqli_query($connect, $sql);
}

mysqli_close($connect);
?>