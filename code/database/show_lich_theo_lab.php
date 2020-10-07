<?php  
	require_once "connect_dtb.php";

	$sql = "
	SELECT
	  `phan_cong_chi_tiet`.`thu`,
	  `phan_cong_day_hoc`.`ma_lop`,
	  `phan_cong_day_hoc`.`ma_mon_hoc`,
	  `phan_cong_day_hoc`.`ma_can_bo`,
	  `phan_cong_chi_tiet`.`gio_bat_dau`,
	  `phan_cong_chi_tiet`.`gio_ket_thuc`,
	  `phan_cong_chi_tiet`.`ma_phong`
	FROM
	  `test_pj1`.`phan_cong_chi_tiet`
	  INNER JOIN `test_pj1`.`phan_cong_day_hoc`
	    ON (
	      `phan_cong_chi_tiet`.`ma_phan_cong` = `phan_cong_day_hoc`.`ma_phan_cong`
	    );
	WhERE `phan_cong_chi_tiet`.`ma_phong` = '$ma_phong'
	";

	
?>