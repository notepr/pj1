<?php
error_reporting(0);
require_once 'connect_dtb.php';

if (isset($_GET['ma_can_bo']) && !empty($_GET['ma_can_bo'])) {
	$ma_can_bo = mysqli_real_escape_string($connect,$_GET['ma_can_bo']);
} else {
	$ma_can_bo = "";
}
if (isset($_GET['ma_lop']) && !empty($_GET['ma_lop'])) {
	$ma_lop = mysqli_real_escape_string($connect,$_GET['ma_lop']);
} else {
	$ma_can_bo = "";
}
if (isset($_GET['search']) && !empty($_GET['search'])) {
	$search = mysqli_real_escape_string($connect,$_GET['search']);
} else {
	$search = "";
}
$sql = "SELECT DISTINCT ma_mon_hoc FROM phan_cong_day_hoc WHERE ma_can_bo='$ma_can_bo' and ma_lop='$ma_lop' AND ma_mon_hoc LIKE '%$search%'";

$result = mysqli_query($connect, $sql);
//print_r($result);

while ($row = mysqli_fetch_assoc($result)) {
	$danh_sach[] = $row;
}

echo json_encode($danh_sach);
//echo "string";

mysqli_close($connect);
?>