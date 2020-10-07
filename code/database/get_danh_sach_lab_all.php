<?php
require_once "connect_dtb.php";

if (isset($_GET['ma_tang'])) {
	$ma_tang = $_GET['ma_tang'];
}

$sql = "select *
	, if(tinh_trang = 1, 'Hoạt Động', 'Bảo trì') as check_tinh_trang
	from phong
	where ma_tang = '$ma_tang'";

$result = mysqli_query($connect, $sql);

while ($row = mysqli_fetch_assoc($result)) {
	$danh_sach_lab[] = $row;
}

echo json_encode($danh_sach_lab);

mysqli_close($connect);
?>