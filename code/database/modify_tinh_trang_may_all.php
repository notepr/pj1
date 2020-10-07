<?php  
	require_once "connect_dtb.php";

	if (isset($_GET['hoat_dong'])) {
		
		if (isset($_GET['ma_phong'])) {
			$ma_phong = $_GET['ma_phong'];
		}

		$sql = "update may set tinh_trang = 1 where ma_phong = '$ma_phong'";

		mysqli_query($connect, $sql);

		mysqli_close($connect);
	}

	if (isset($_GET['bao_tri'])) {

		if (isset($_GET['ma_phong'])) {
			$ma_phong = $_GET['ma_phong'];
		}

		$sql = "update may set tinh_trang = 2 where ma_phong = '$ma_phong'";

		mysqli_query($connect, $sql);

		mysqli_close($connect);
	}

	if (isset($_GET['sl_hoat_dong'])) {

		if (isset($_GET['arr_ma_may'])) {
			$arr_ma_may = $_GET['arr_ma_may'];
		}

		foreach ($arr_ma_may as $value) {
			$sql = "update may set tinh_trang = 1 where ma_may = '$value'";
			mysqli_query($connect, $sql);
		}
		
		mysqli_close($connect);
	}

	if (isset($_GET['sl_bao_tri'])) {

		if (isset($_GET['arr_ma_may'])) {
			$arr_ma_may = $_GET['arr_ma_may'];
		}

		foreach ($arr_ma_may as $value) {
			$sql = "update may set tinh_trang = 2 where ma_may = '$value'";
			mysqli_query($connect, $sql);
		}

		mysqli_close($connect);
	}

?>