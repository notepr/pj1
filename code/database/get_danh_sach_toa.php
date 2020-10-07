<?php

require_once "connect_dtb.php";

$sql = "select * from toa";

$result = mysqli_query($connect, $sql);

while ($row = mysqli_fetch_assoc($result)) {
	$danh_sach_toa[] = $row;
}

mysqli_close($connect);

?>