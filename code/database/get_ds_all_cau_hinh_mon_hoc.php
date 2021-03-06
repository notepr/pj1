<?php  
	require_once "connect_dtb.php";

	$sql = "
	SELECT
	  `cau_hinh`.*,
	  GROUP_CONCAT(ma_bo_mon) AS cac_mon_hoc
	FROM
	  `test_pj1`.`cau_hinh`
	  INNER JOIN `test_pj1`.`cau_hinh_bo_mon`
	    ON (
	      `cau_hinh`.`ma_cau_hinh` = `cau_hinh_bo_mon`.`ma_cau_hinh`
	    )
	GROUP BY ma_cau_hinh
	";

	$result = mysqli_query($connect, $sql);

	while($row = mysqli_fetch_assoc($result)) {
		$ds_cau_hinh_mon_hoc[] = $row;
	}

	echo json_encode($ds_cau_hinh_mon_hoc);

	mysqli_close($connect);
?>