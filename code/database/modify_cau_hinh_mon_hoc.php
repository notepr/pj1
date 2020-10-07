<?php  
	require_once "connect_dtb.php";

	if (isset($_GET['ma_cau_hinh'])) {
		$ma_cau_hinh = $_GET['ma_cau_hinh'];
	}

	if (isset($_GET['cac_mon'])) {
		$cac_mon = $_GET['cac_mon'];
	}

	$sql = "
	delete from cau_hinh_bo_mon where ma_cau_hinh = '$ma_cau_hinh'
	";

	mysqli_query($connect, $sql);

	foreach ($cac_mon as $item) {
		$sql = "insert into cau_hinh_bo_mon values ('$ma_cau_hinh', '$item')";

		mysqli_query($connect, $sql);
	}

	mysqli_close($connect);
?>