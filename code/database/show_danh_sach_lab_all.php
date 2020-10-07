<?php
require_once "connect_dtb.php";

if (isset($_GET['ma_tang'])) {
	$ma_tang = $_GET['ma_tang'];
}

$sql = "
SELECT
  phong.*,
  GROUP_CONCAT(ma_bo_mon) as mon_co_the_hoc,
  if(tinh_trang = 1, 'Hoạt Động', 'Bảo Trì') as check_tinh_trang,
  chip,
  ram,
  o_cung,
  card_do_hoa,
  man_hinh
FROM
  `test_pj1`.`cau_hinh`
  INNER JOIN `test_pj1`.`cau_hinh_bo_mon`
    ON (
      `cau_hinh`.`ma_cau_hinh` = `cau_hinh_bo_mon`.`ma_cau_hinh`
    )
  INNER JOIN `test_pj1`.`phong`
    ON (
      `cau_hinh_bo_mon`.`ma_cau_hinh` = `phong`.`ma_cau_hinh`
    )
where ma_tang = '$ma_tang'
group by ma_phong;
";

$result = mysqli_query($connect, $sql);

while ($row = mysqli_fetch_assoc($result)) {
	$danh_sach_lab[] = $row;
}

echo json_encode($danh_sach_lab);

mysqli_close($connect);
?>