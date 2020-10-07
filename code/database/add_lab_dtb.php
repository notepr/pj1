<?php
require_once "connect_dtb.php";

if (isset($_GET['ten_phong'])) {
	$ten_phong = $_GET['ten_phong'];
}
if (isset($_GET['so_cho_ngoi'])) {
	$so_cho_ngoi = $_GET['so_cho_ngoi'];
}
if (isset($_GET['tinh_trang'])) {
	$tinh_trang = $_GET['tinh_trang'];
}
if (isset($_GET['ghi_chu'])) {
	$ghi_chu = $_GET['ghi_chu'];
}
if (isset($_GET['ma_cau_hinh'])) {
	$ma_cau_hinh = $_GET['ma_cau_hinh'];
}
if (isset($_GET['ma_tang'])) {
	$ma_tang = $_GET['ma_tang'];
}

$sql =
	"
	insert into phong (ten_phong, so_cho_ngoi, tinh_trang, ghi_chu, ma_cau_hinh, ma_tang)
	values ('$ten_phong', '$so_cho_ngoi', '$tinh_trang', '$ghi_chu', '$ma_cau_hinh', '$ma_tang')
	";
mysqli_query($connect, $sql);

$ma_phong = mysqli_insert_id($connect);

$ten_may = $ma_phong . 'M';

for($i = 1; $i <= $so_cho_ngoi; $i++) {
	$ma_ten_may = $ten_may . $i; 
	$sql = "insert into may (ten_may, ma_cau_hinh, tinh_trang, ma_phong) values ('$ma_ten_may', '$ma_cau_hinh', 1, '$ma_phong')";
	mysqli_query($connect, $sql);
}

mysqli_close($connect);
?>