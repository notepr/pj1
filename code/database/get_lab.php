<?php
require_once "connect_dtb.php";

if (isset($_GET['ma_phong'])) {
	$ma_phong = $_GET['ma_phong'];
}

$sql = "select * from phong where ma_phong = '$ma_phong'";

$result = mysqli_query($connect, $sql);

$result = mysqli_fetch_assoc($result);

echo json_encode($result);

mysqli_close($connect);
?>