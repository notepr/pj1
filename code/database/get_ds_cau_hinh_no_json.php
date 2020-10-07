<?php  
	require_once "connect_dtb.php";

	$sql = "select * from cau_hinh";

	$result = mysqli_query($connect, $sql);

	mysqli_close($connect);
?>