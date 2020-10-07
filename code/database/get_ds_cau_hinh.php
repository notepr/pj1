<?php  
	require_once "connect_dtb.php";

	$sql = "select * from cau_hinh";

	$result = mysqli_query($connect, $sql);

	while ($row = mysqli_fetch_assoc($result)) {
		$danh_sach_cau_hinh[] = $row;
	}

	echo json_encode($danh_sach_cau_hinh);

	mysqli_close($connect);
?>