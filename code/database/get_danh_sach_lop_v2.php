<?php
error_reporting(0);
require_once 'connect_dtb.php';

if (isset($_GET['ma_can_bo']) && !empty($_GET['ma_can_bo'])) {
	$ma_can_bo = mysqli_real_escape_string($connect,$_GET['ma_can_bo']);
}
if (isset($_GET['search']) && !empty($_GET['search'])) {
	$search = mysqli_real_escape_string($connect,$_GET['search']);
} else {
	$search = "";
}
if (isset($_GET['check']) && !empty($_GET['check'])) {
	$check = mysqli_real_escape_string($connect,$_GET['check']);
} else {
	$check = "";
}
$sql = "SELECT DISTINCT ma_lop FROM `phan_cong_day_hoc` WHERE ma_can_bo='$ma_can_bo' AND ma_lop LIKE '%$search%'";

$result = mysqli_query($connect, $sql);
//print_r($result);
if ($check == "check") {
	if (mysqli_num_rows($result) == 0) {
		header('HTTP/1.1 500 Sever Exception');
		header('Content-Type: application/json; charset=UTF-8');
		$error = array(
			'text' => "Giáo Viên Bạn Đang Chọn Không Dạy Lớp Nào",
		);
		die(json_encode($error));
	} else {
		header('HTTP/1.1 200 DONE');
		header('Content-Type: application/json; charset=UTF-8');
		$error = array(
			'text' => "",
		);
		die(json_encode($error));
	}
}
while ($row = mysqli_fetch_assoc($result)) {
	$danh_sach[] = $row;
}

echo json_encode($danh_sach);
//echo "string";

mysqli_close($connect);
?>