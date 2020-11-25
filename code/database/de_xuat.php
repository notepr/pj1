<?php
//fun
function error($value) {
    header('HTTP/1.1 500 Sever Exception');
    header('Content-Type: application/json; charset=UTF-8');
    $error = array(
        'text' => $value,
    );
    die(json_encode($error));
}
function done($value) {
    header('HTTP/1.1 200 DONE');
    header('Content-Type: application/json; charset=UTF-8');
    $done = array(
        'text' => $value,
    );
    die(json_encode($done));
}
function chuyenGio($gio) {
    $time = date('H:i', strtotime($gio));
    return ((float) (date('H', strtotime($gio))) + (float) (date('i', strtotime($gio))) / 60);
}
function chuoiThanhGio($chuoi) {
    $hours   = floor($chuoi);
    $minutes = 60 * $chuoi - $hours * 60;
    $time    = date('H:i:s', strtotime($hours . ":" . $minutes));
    return $time;
}
function dieuKien1($gio_phat_sinh, $gio_day) {
    if (($gio_phat_sinh >= 8 && $gio_phat_sinh <= 12) || ($gio_phat_sinh >= 13.5 && $gio_phat_sinh <= 17.5)) {
        return 'true';
    } else {
        return 'false';
    }
}
function dieuKien2($gio_phat_sinh, $gio_day) {
    if ((($gio_phat_sinh <= 12 && ($gio_phat_sinh - $gio_day) <= 12) || ($gio_phat_sinh >= 13.5 && ($gio_phat_sinh - $gio_day) >= 13.5))) {
        return 'true';
    } else {
        return 'false';
    }
}
function soSanhNgayHienTai($ngay_so_sanh) {
    if ($GLOBALS['array_ngay_nghi'][count($GLOBALS['array_ngay_nghi']) - 1] == $ngay_so_sanh) {
        unset($GLOBALS['array_ngay_nghi'][count($GLOBALS['array_ngay_nghi']) - 1]);
        return 'true';
    } else {
        return 'false';
    }
}
function chuyenThanhThuDung($thu_php) {
    switch ($thu_php) {
    case '0':
        return 8;
        break;

    default:
        return ($thu_php + 1);
        break;
    }
}
//moc1=8-10h,moc2=10-12h,moc3=13h30-15:30 moc 4=15:30 den=17:30,moc5=8-12, moc 6
function checkGio($moc_1, $moc_2) {
    if (($moc_1 == 5 && ($moc_2 == 1 || $moc_2 == 2)) || ($moc_1 == 6 && ($moc_2 == 3 || $moc_2 == 4)) || ($moc_2 == 5 && ($moc_1 == 1 || $moc_1 == 2)) || ($moc_2 == 6 && ($moc_1 == 3 || $moc_1 == 4))) {
        return false;
    } else {
        return true;
    }
}
function mocGio($gio_bat_dau, $gio_ket_thuc) {
    if (chuyenGio($gio_bat_dau) == 8 && chuyenGio($gio_ket_thuc) == 10) {
        return 1;
    }
    if (chuyenGio($gio_bat_dau) == 10 && chuyenGio($gio_ket_thuc) == 12) {
        return 2;
    }
    if (chuyenGio($gio_bat_dau) == 13.5 && chuyenGio($gio_ket_thuc) == 15.5) {
        return 3;
    }
    if (chuyenGio($gio_bat_dau) == 15.5 && chuyenGio($gio_ket_thuc) == 17.5) {
        return 4;
    }
    if (chuyenGio($gio_bat_dau) == 8 && chuyenGio($gio_ket_thuc) == 12) {
        return 5;
    }
    if (chuyenGio($gio_bat_dau) == 13.5 && chuyenGio($gio_ket_thuc) == 17.5) {
        return 6;
    }
}
//.end
///////
require_once 'connect_dtb.php';
date_default_timezone_set('Asia/Ho_Chi_Minh');
$key_api = "nguvl";
if (isset($_GET['xep_tu_ngay']) && !empty($_GET['xep_tu_ngay'])) {
    $xep_tu_ngay = $d_xep_tu_ngay = mysqli_real_escape_string($connect, $_GET['xep_tu_ngay']);
} else {
    $xep_tu_ngay = $d_xep_tu_ngay = date('Y-m-d');
}
if (isset($_GET['so_ngay_xem']) && !empty($_GET['so_ngay_xem'])) {
    $so_ngay_xem = $d_tinh_truoc_ngay = mysqli_real_escape_string($connect, $_GET['so_ngay_xem']);
} else {
    //ko truyen vào sẽ tự tính 7 ngày
    $so_ngay_xem = $d_tinh_truoc_ngay = 7;
}
if (isset($_GET['ma_lop']) && !empty($_GET['ma_lop'])) {
    $ma_lop = mysqli_real_escape_string($connect, $_GET['ma_lop']);
} else {
    error("Cần mã lớp để có thể xử lý và không được để trống");
}
if (isset($_GET['ma_can_bo']) && !empty($_GET['ma_can_bo'])) {
    $ma_can_bo = mysqli_real_escape_string($connect, $_GET['ma_can_bo']);
} else {
    error("Cần mã cán bộ để có thể xử lý và không được để trống");
}
if (isset($_GET['gio_day']) && !empty($_GET['gio_day'])) {
    $gio_day = mysqli_real_escape_string($connect, $_GET['gio_day']);
} else {
    error("Cần Số Giờ Dạy Để Có Thể Xử Lý");
}
if (isset($_GET['ma_mon_hoc']) && !empty($_GET['ma_mon_hoc'])) {
    $ma_mon_hoc = mysqli_real_escape_string($connect, $_GET['ma_mon_hoc']);
} else {
    error("Hãy Chọn Cả Mã Môn");
}
//ghép chuỗi ngày tăng
$ngay_tang      = "+ " . $d_tinh_truoc_ngay . " days";
$d_xep_den_ngay = date('Y-m-d', strtotime($d_xep_tu_ngay . $ngay_tang));
//SQL lấy ngày nghỉ có mã gv=0 và ma gv=magv
$sql = "SELECT ngay FROM ngay_nghi WHERE (ma_giao_vien='0' OR ma_giao_vien='$ma_can_bo') AND ngay>='$d_xep_tu_ngay' and ngay<='$d_xep_den_ngay' ORDER BY `ngay_nghi`.`ngay`  DESC";
// die($sql);
$result = mysqli_query($connect, $sql);
//lưu mảng ngày nghỉ
global $array_ngay_nghi;
$GLOBALS['array_ngay_nghi'][] = "null";
foreach ($result as $key) {
    $GLOBALS['array_ngay_nghi'][] = $key['ngay'];
}
//.end
$dem           = 0;
$i             = 0;
$d_xep_tu_ngay = date('Y-m-d', strtotime($d_xep_tu_ngay . '- 1 days'));
while ($d_xep_tu_ngay <= $d_xep_den_ngay) {
    $d_xep_tu_ngay   = date('Y-m-d', strtotime($d_xep_tu_ngay . '+ 1 days'));
    $day_of_the_week = date('w', strtotime($d_xep_tu_ngay));
    if (soSanhNgayHienTai($d_xep_tu_ngay) == 'false' && chuyenThanhThuDung($day_of_the_week) != 8) {
        $dem++;
    }
    if ($dem == 1) {
        //php trả về thứ tính từ 0 đến 6 đại điện cho cn,2,3,4,5,6,7
        //$d_xep_tu_ngay='2019-11-10';
        $day_of_the_week = date('w', strtotime($d_xep_tu_ngay));
        // echo $day_of_the_week;
        $thu_phan_cong = chuyenThanhThuDung($day_of_the_week);
        $thu_sql       = $thu_phan_cong - 2;
        ///sql thứ tính từ 0 đến 6 đại diện chu t2 đến cn
        //sql yêu cầu trả về lịch học của lớp và lịch dạy của giáo viên đã bao gồm lich dạy bất thường
        $sql = "SELECT (WEEKDAY(ngay)+2) as 'thu',gio_bat_dau,gio_ket_thuc FROM `lich_day_dot_xuat` WHERE (ma_lop='$ma_lop' OR ma_can_bo='$ma_can_bo') and WEEKDAY(ngay)='$thu_sql' AND ngay='$d_xep_tu_ngay'
            UNION
            SELECT DISTINCT phan_cong_chi_tiet.thu,phan_cong_chi_tiet.gio_bat_dau,phan_cong_chi_tiet.gio_ket_thuc
                FROM phan_cong_chi_tiet LEFT JOIN phan_cong_day_hoc
                ON phan_cong_day_hoc.ma_phan_cong=phan_cong_chi_tiet.ma_phan_cong
                WHERE (ma_lop='$ma_lop' OR ma_can_bo='$ma_can_bo') AND phan_cong_chi_tiet.thu='$thu_phan_cong'
            ORDER BY `gio_bat_dau`  ASC";
        $array         = mysqli_query($connect, $sql);
        $gio_khoi_tao  = 8;
        $gio_phat_sinh = $gio_khoi_tao;
        foreach ($array as $each) {
            $gio_phat_sinh = $gio_phat_sinh + $gio_day;
            while ($gio_phat_sinh < chuyenGio($each['gio_bat_dau']) && dieuKien1($gio_phat_sinh, $gio_day) == "true" && dieuKien2($gio_phat_sinh, $gio_day) == "true") {
                //Lưu đề xuất giờ lại thành 1 mảng
                $de_xuat[] = array(
                    'ngay'         => $d_xep_tu_ngay,
                    'thu'          => $thu_phan_cong,
                    'gio_bat_dau'  => chuoiThanhGio($gio_phat_sinh - $gio_day),
                    'gio_ket_thuc' => chuoiThanhGio($gio_phat_sinh),
                );
                $gio_phat_sinh = $gio_phat_sinh + $gio_day;
            }

            $gio_phat_sinh = chuyenGio($each['gio_ket_thuc']);
            //cần loại trừ trường hợp giờ kt bằng 11 và giờ dạy = 4 cũng như giờ ps nằm trong khoảng ko được phép
            if (($gio_phat_sinh > 12 && $gio_phat_sinh < 13.5) || ((12 - $gio_phat_sinh) < $gio_day && (12 - $gio_phat_sinh) >= 0)) {
                $gio_phat_sinh = 13.5;
            }
        }
        // die();
        $gio_phat_sinh = $gio_phat_sinh + $gio_day;
        while (dieuKien1($gio_phat_sinh, $gio_day) == "true" && dieuKien2($gio_phat_sinh, $gio_day) == "true") {
            if ($gio_phat_sinh > 12 && $gio_phat_sinh < 13.5) {
                $gio_phat_sinh = 13.5;
            }
            //Lưu đề xuất giờ lại thành 1 mảng
            $de_xuat[] = array(
                'ngay'         => $d_xep_tu_ngay,
                'thu'          => $thu_phan_cong,
                'gio_bat_dau'  => chuoiThanhGio($gio_phat_sinh - $gio_day),
                'gio_ket_thuc' => chuoiThanhGio($gio_phat_sinh),
            );
            //cần loại trừ trường hợp giờ kt bằng 11 và giờ dạy = 4 cũng như giờ ps nằm trong khoảng ko được phép
            if (($gio_phat_sinh > 12 && $gio_phat_sinh < 13.5) || ((12 - $gio_phat_sinh) < $gio_day && (12 - $gio_phat_sinh) >= 0)) {
                $gio_phat_sinh = 13.5;
            }
            ///
            $gio_phat_sinh = $gio_phat_sinh + $gio_day;
        }
        $dem = 0;
    }
}
//láy số sv của lớp
$api      = "https://old.notepr.xyz/code/database/api.php?key=" . $key_api . "&ma_lop=" . $ma_lop . "&thao_tac=ds_sinh_vien";
$response = file_get_contents($api);
// print_r($response);
//decode json
$d_get_api = json_decode($response, true);
if (is_null($d_get_api)) {
    error("Có Lỗi Khi Kết Nối Dữ Liệu Hay Thử Lại Hoặc Báo Kĩ Thuật");
}
//Tìm kiếm phòng lab
//Sql lấy phòng ko có trong phan cong chi tiet va con hoat dong và lịch dạy đột xuất
$tong_sinh_vien = $d_get_api['tong_sinh_vien'];
$sql            = "SELECT ma_phong FROM phong WHERE so_cho_ngoi>= '$tong_sinh_vien' and tinh_trang=1 and ma_phong NOT IN
            (
            SELECT ma_phong FROM phan_cong_chi_tiet
            UNION
            SELECT ma_phong FROM lich_day_dot_xuat
            )";
$array_phong_con_trong = mysqli_query($connect, $sql);
$dem_row               = mysqli_num_rows($array_phong_con_trong);
$dem_row               = mysqli_num_rows($array_phong_con_trong);
if ($dem_row != 0) {
    foreach ($array_phong_con_trong as $each) {
        for ($i = 0; $i < count($de_xuat); $i++) {
            //$lab=$de_xuat[$i]['ma_tang_phu_hop'];
            $de_xuat[$i]['ma_phong_phu_hop'][] = $each['ma_phong'];
        }
    }
}
/////////////////////////lấy ra danh sách phong trong phân công chi tiết
$sql = "SELECT ma_phong FROM phong WHERE so_cho_ngoi>= '$tong_sinh_vien' and tinh_trang=1 and ma_phong IN
            (
            SELECT ma_phong FROM phan_cong_chi_tiet
            UNION
            SELECT ma_phong FROM lich_day_dot_xuat
            )";
$array_phong_chi_tiet = mysqli_query($connect, $sql);
$dem_row              = mysqli_num_rows($array_phong_chi_tiet);
if ($dem_row != 0) {
    foreach ($array_phong_chi_tiet as $each) {
        for ($i = 0; $i < count($de_xuat); $i++) {
            //sql check
            $thu          = $de_xuat[$i]['thu'];
            $ngay         = $de_xuat[$i]['ngay'];
            $gio_bat_dau  = $de_xuat[$i]['gio_bat_dau'];
            $gio_ket_thuc = $de_xuat[$i]['gio_ket_thuc'];
            $ma_phong     = $each['ma_phong'];
            //Lấy ra gio batdau_gioktt cua thu va ma phong va gio bat dau gio ket thuc cua phan cong dot xuat
            $sql = "SELECT DISTINCT gio_bat_dau,gio_ket_thuc FROM phan_cong_chi_tiet
                    WHERE thu='$thu' AND ma_phong='$ma_phong'
                    UNION
                    SELECT DISTINCT gio_bat_dau,gio_ket_thuc FROM lich_day_dot_xuat
                    WHERE ngay='$ngay' and ma_phong='$ma_phong'";
            //xem khung giờ có bị dạy rồi hay không
            $ban_ghi = mysqli_query($connect, $sql);
            ///nếu không có bản ghi nào phòng tự động trống
            if (mysqli_num_rows($ban_ghi) != 0) {
                $moc_gio_so_sanh = mocGio($gio_bat_dau, $gio_ket_thuc);
                $ton_tai         = "";
                //so_sanh xem mốc giờ so_sanh có tồn tại trong dtb hay không
                foreach ($ban_ghi as $each_gio) {
                    $gio_sql = mocGio($each_gio['gio_bat_dau'], $each_gio['gio_ket_thuc']);
                    if (checkGio($gio_sql, $moc_gio_so_sanh) == false) {
                        break;
                    }
                    if ($moc_gio_so_sanh != $gio_sql) {
                        $ton_tai++;
                    }
                }
                //nếu ko tồn tại-->thêm thành phòng trống
                if ($ton_tai == mysqli_num_rows($ban_ghi)) {
                    $de_xuat[$i]['ma_phong_phu_hop'][] = $each['ma_phong'];
                }
            } else {
                $de_xuat[$i]['ma_phong_phu_hop'][] = $each['ma_phong'];
            }
        }
    }
}
$array_phong[] = "";
$dem           = 0;
foreach ($de_xuat as $key => $value) {
    $ngay         = $value['ngay'];
    $thu          = $value['thu'];
    $gio_bat_dau  = $value['gio_bat_dau'];
    $gio_ket_thuc = $value['gio_ket_thuc'];
    if (isset($value['ma_phong_phu_hop'])) {
        $mang_json[] = array(
            'ngay'         => $ngay,
            'thu'          => $thu,
            'gio_bat_dau'  => $gio_bat_dau,
            'gio_ket_thuc' => $gio_ket_thuc,
        );
        for ($i = 0; $i < count($value['ma_phong_phu_hop']); $i++) {
            $ma_phong = $value['ma_phong_phu_hop'][$i];
            if (empty($array_phong[$ma_phong])) {
                $sql_phong              = "SELECT ten_phong from phong where ma_phong='$ma_phong'";
                $data                   = mysqli_query($connect, $sql_phong);
                $a                      = mysqli_fetch_array($data);
                $array_phong[$ma_phong] = $a['ten_phong'];
            }
            $mang_json[$dem]['phong_phu_hop'][$ma_phong] = $array_phong[$ma_phong];
        }
        $dem++;
    }
}
// echo ("<pre>");
// print_r($mang_json);
// echo ("\<pre>");
if (count($mang_json) == 0) {
    error("Không Có Dữ Liệu Đề Xuất Cho Lựa Chọn Của Bạn");
}
echo json_encode($mang_json);
mysqli_close($connect);