<?php 
	require_once "connect_dtb.php";

	if (isset($_GET['ngay'])) {
		$ngay = $_GET['ngay'];
	}

	if (isset($_GET['arr_giao_vien'])) {
		$arr_giao_vien = $_GET['arr_giao_vien'];
	}

	if (isset($_GET['ghi_chu'])) {
		$ghi_chu = $_GET['ghi_chu'];
	}

	foreach ($arr_giao_vien as $item) {
		mysqli_query($connect,"insert into ngay_nghi values ('$ngay', '$item', '$ghi_chu')");
	}

	mysqli_close($connect);
?>