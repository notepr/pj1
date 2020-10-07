<?php
require_once "connect_dtb.php";

if (isset($_GET['ma_tang'])) {
	$ma_tang = $_GET['ma_tang'];
}

$sql = "
SELECT
  `phong`.`ma_phong`,
  `phong`.`ten_phong`,
  `phong`.`so_cho_ngoi`,
  `phong`.`tinh_trang`,
  `cau_hinh`.`chip`,
  `cau_hinh`.`ram`,
  `cau_hinh`.`o_cung`,
  `cau_hinh`.`card_do_hoa`,
  `cau_hinh`.`man_hinh`,
  IF (
    tinh_trang = 1,
    'Hoạt động',
    'Bảo trì'
  ) AS check_tinh_trang
FROM
  `test_pj1`.`cau_hinh`
  INNER JOIN `test_pj1`.`phong`
    ON (
      `cau_hinh`.`ma_cau_hinh` = `phong`.`ma_cau_hinh`
    )
where ma_tang = '$ma_tang'
";

$result = mysqli_query($connect, $sql);

while ($row = mysqli_fetch_assoc($result)) {
	$danh_sach_lab[] = $row;
}

echo json_encode($danh_sach_lab);

mysqli_close($connect);
?>