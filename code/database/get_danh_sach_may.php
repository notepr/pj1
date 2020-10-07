<?php
require_once "connect_dtb.php";

if (isset($_GET['ma_phong'])) {
	$ma_phong = $_GET['ma_phong'];
}

$sql = "SELECT
  `may`.`ma_may`,
  `may`.`ten_may`,
  `cau_hinh`.`chip`,
  `cau_hinh`.`ram`,
  `cau_hinh`.`o_cung`,
  `cau_hinh`.`card_do_hoa`,
  `cau_hinh`.`man_hinh`,
  `may`.`tinh_trang`,
  IF (
    tinh_trang = 2,
    'Bảo trì',
    'Hoạt động'
  ) AS check_tinh_trang
FROM
  `test_pj1`.`may`
  INNER JOIN `test_pj1`.`cau_hinh`
    ON (
      `may`.`ma_cau_hinh` = `cau_hinh`.`ma_cau_hinh`
    )
WHERE ma_phong = '$ma_phong'";

$result = mysqli_query($connect, $sql);

while ($row = mysqli_fetch_assoc($result)) {
	$danh_sach_may[] = $row;
}

echo json_encode($danh_sach_may);

mysqli_close($connect);
?>