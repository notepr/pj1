<?php
	require_once "code/database/connect_dtb.php";

	function Random_key($length = 256) {
		return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	}

	$key = Random_key();

	$sql = "update admin set random_key = '$key'";

	mysqli_query($connect, $sql);

	header("location:code/view/home.php");
	// header("location:index.php");
?>