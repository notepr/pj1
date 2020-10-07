<?php 
	require_once "connect_dtb_bkacad.php";

	$sql = "select * from mon_hoc";

	$result = mysqli_query($connect, $sql);

	mysqli_close($connect);
?>