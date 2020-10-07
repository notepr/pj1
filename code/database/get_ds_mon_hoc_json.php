<?php 
	require_once "connect_dtb_bkacad.php";

	$sql = "select * from mon_hoc";

	$result = mysqli_query($connect, $sql);

	while ($row = mysqli_fetch_assoc($result)) {
		$danh_sach_mon_hoc[] = $row;
	}

	echo json_encode($danh_sach_mon_hoc);

	mysqli_close($connect);
?>