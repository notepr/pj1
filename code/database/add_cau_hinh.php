<?php  
	require_once "connect_dtb.php";

	if (isset($_GET['chip'])) {
		$chip = $_GET['chip'];
	}
	if (isset($_GET['ram'])) {
		$ram = $_GET['ram'];
	}
	if (isset($_GET['o_cung'])) {
		$o_cung = $_GET['o_cung'];
	}
	if (isset($_GET['card_do_hoa'])) {
		$card_do_hoa = $_GET['card_do_hoa'];
	}
	if (isset($_GET['man_hinh'])) {
		$man_hinh = $_GET['man_hinh'];
	}
	if (isset($_GET['cac_mon'])) {
		$cac_mon = $_GET['cac_mon'];
	}

	$sql = "insert into cau_hinh (chip, ram, o_cung, card_do_hoa, man_hinh) values (
		'$chip',
		'$ram',
		'$o_cung',
		'$card_do_hoa',
		'$man_hinh'
	)";

	mysqli_query($connect, $sql);

	$ma_cau_hinh = mysqli_insert_id($connect);

	foreach ($cac_mon as $item) {
		$sql = "insert into cau_hinh_bo_mon values ('$ma_cau_hinh', '$item')";

		mysqli_query($connect, $sql);
	}

	mysqli_close($connect);
?>