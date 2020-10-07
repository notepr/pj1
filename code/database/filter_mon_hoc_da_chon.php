<?php  
	require_once "connect_dtb.php";

	if (isset($_GET['ma_cau_hinh'])) {
		$ma_cau_hinh = $_GET['ma_cau_hinh'];
	}

	$sql = "
	SELECT
	  `cau_hinh`.`ma_cau_hinh`,
	  GROUP_CONCAT(ma_bo_mon) AS cac_mon
	FROM
	  `test_pj1`.`cau_hinh`
	  INNER JOIN `test_pj1`.`cau_hinh_bo_mon`
	    ON (
	      `cau_hinh`.`ma_cau_hinh` = `cau_hinh_bo_mon`.`ma_cau_hinh`
	    )
	WHERE `cau_hinh`.`ma_cau_hinh` = '$ma_cau_hinh'
	GROUP BY ma_cau_hinh
	";

	$result = mysqli_query($connect, $sql);

	$result = mysqli_fetch_assoc($result);

	echo json_encode($result);

	mysqli_close($connect);
?>