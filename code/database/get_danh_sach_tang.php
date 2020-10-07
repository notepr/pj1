<?php
require_once "connect_dtb.php";

if (isset($_GET['ma_toa'])) {
	$ma_toa = $_GET['ma_toa'];
}

$sql = "select * from tang where ma_toa = '$ma_toa'";

$result = mysqli_query($connect, $sql);

while ($row = mysqli_fetch_assoc($result)) {
	$danh_sach_tang[] = $row;
}

echo json_encode($danh_sach_tang);

mysqli_close($connect);
?>