<?php
//fun

//quan_ly_mau
$quan_ly_mau_nen = array(
    'da_day'    => 'red',
    'tuong_lai' => 'blue',
    'them'      => 'gray',
);
$quan_ly_mau_chu = array(
    'da_day'    => '#FFFFFF',
    'tuong_lai' => '#FFFFFF',
    'them'      => '#FFFFFF',
);
///.end quản lý màu
date_default_timezone_set('Asia/Ho_Chi_Minh');
$key_api = "nguvl";
function soSanhNgayHienTai($ngay_so_sanh, $array_ngay_nghi) {
    foreach ($array_ngay_nghi as $each) {
        if ($each['ngay_nghi'] == $ngay_so_sanh) {
            return 'true';
            break;
        }
    }
    return 'false';
}
function soSanhThu($thu_ss, $mang_data) {
    foreach ($mang_data as $each) {
        switch ($each['thu']) {
        case '2':
            $each['thu'] = 'Monday';
            break;
        case '3':
            $each['thu'] = 'Tuesday';
            break;
        case '4':
            $each['thu'] = 'Wednesday';
            break;
        case '5':
            $each['thu'] = 'Thursday';
            break;
        case '6':
            $each['thu'] = 'Friday';
            break;
        case '7':
            $each['thu'] = 'Saturday';
            break;
        case '8':
            $each['thu'] = 'Sunday';
            break;
        }
        ///nếu đúng thứ trả về mảng
        if ($each['thu'] == $thu_ss) {
            $tra_ve['gio_hoc']      = $each['gio_hoc'];
            $tra_ve['gio_bat_dau']  = $each['gio_bat_dau'];
            $tra_ve['gio_ket_thuc'] = $each['gio_ket_thuc'];
            return $tra_ve;
            break;
        }
    }
    return 'false';
}
/////////////////////end fun
require_once 'connect_dtb.php';
$d_xep_tu_ngay = date('Y-m-d');
// $d_xep_tu_ngay = '2019-11-05';
if (isset($_GET['ma_lop']) && isset($_GET['ma_mon_hoc']) && !empty($_GET['ma_lop']) && !empty($_GET['ma_mon_hoc'])) {
    $d_ma_lop     = mysqli_real_escape_string($connect, $_GET['ma_lop']);
    $d_ma_mon_hoc = mysqli_real_escape_string($connect, $_GET['ma_mon_hoc']);
} else {
    header('HTTP/1.1 500 Sever Exception');
    header('Content-Type: application/json; charset=UTF-8');
    $error = array(
        'text' => "Không Được Để Trống",
    );
    die(json_encode($error));
}
//Goi API Truyền vào mã lớp và mã môn
$api      = "https://old.notepr.xyz/code/database/api.php?key=" . $key_api . "&ma_lop=" . $d_ma_lop . "&ma_mon_hoc=" . $d_ma_mon_hoc . "&thao_tac=giao-vien";
$response = file_get_contents($api);
//trả về js dạng {"ma_can_bo":"29","ten_can_bo":"Nguy\u1ec5n Nam Long","gio_dinh_muc":"72","ma_mon_hoc":"BKA_WEB","ma_lop":"BKD01K10"}
//decode json
$d_get_api = json_decode($response, true);
if (is_null($d_get_api)) {
    header('HTTP/1.1 500 Sever Exception');
    header('Content-Type: application/json; charset=UTF-8');
    $error = array(
        'text' => "Không Tìm Thấy Giờ Định Mức Hoặc Phân Công Của Giáo Viên Và Lớp Này",
    );
    die(json_encode($error));
}
//GỌI API thu về giờ đã dạy
$api      = "https://old.notepr.xyz/code/database/api.php?key=" . $key_api . "&ma_lop=" . $d_ma_lop . "&ma_mon_hoc=" . $d_ma_mon_hoc . "&thao_tac=gio-da-day";
$response = file_get_contents($api);
// thu về dữ liệu {"gio_da_day":"18"}
///decode json
$d_get_api_gio_da_day = json_decode($response, true);
if (is_null($d_get_api_gio_da_day)) {
    //không thể xảy ra
    die();
}
//tính giờ dạy còn sót lại
$d_so_gio_hoc_con_lai = (float) $d_get_api['gio_dinh_muc'] - (float) $d_get_api_gio_da_day['gio_da_day'];
//die();
///.end
//sql thu về thứ dạy và mã phân công chi tiet gan voi ma lop va ma mon truyen vao thời gian dạy của từng thứ
$d_sql_get_phan_cong_chi_tiet = "SELECT phan_cong_chi_tiet.*,((MINUTE(phan_cong_chi_tiet.gio_ket_thuc)+hour(phan_cong_chi_tiet.gio_ket_thuc)*60)-(MINUTE(phan_cong_chi_tiet.gio_bat_dau)+hour(phan_cong_chi_tiet.gio_bat_dau)*60))/60 as gio_hoc FROM phan_cong_chi_tiet LEFT JOIN phan_cong_day_hoc on phan_cong_chi_tiet.ma_phan_cong=phan_cong_day_hoc.ma_phan_cong WHERE phan_cong_day_hoc.ma_lop='$d_ma_lop' and phan_cong_day_hoc.ma_mon_hoc='$d_ma_mon_hoc'";
$d_array_phan_cong_chi_tiet   = mysqli_query($connect, $d_sql_get_phan_cong_chi_tiet);
if (mysqli_num_rows($d_array_phan_cong_chi_tiet) == 0) {
    header('HTTP/1.1 500 Sever Exception');
    header('Content-Type: application/json; charset=UTF-8');
    $error = array(
        'text' => "Không Có Phân Công Chi Tiết Cho Lựa Chọn Của Bạn",
    );
    die(json_encode($error));
}
if (isset($_GET['check']) && !empty($_GET['check'])) {
    header('HTTP/1.1 200 DONE');
    header('Content-Type: application/json; charset=UTF-8');
    $error = array(
        'text' => "Đầy Đủ",
    );
    die(json_encode($error));
}
///sql thu ra ngayf nghi dựa vào ma cán bộ và ghi chú ==0
$d_ma_can_bo         = $d_get_api['ma_can_bo'];
$d_sql_get_ngay_nghi = "SELECT ngay as 'ngay_nghi' FROM ngay_nghi WHERE ma_giao_vien='0' or ma_giao_vien='$d_ma_can_bo'";
$d_array_ngay_nghi   = mysqli_query($connect, $d_sql_get_ngay_nghi);
//.end
$dem           = 0;
$i             = 0;
$d_xep_tu_ngay = date('Y-m-d', strtotime($d_xep_tu_ngay . '- 1 days'));
while ($d_so_gio_hoc_con_lai > 0) {
    $d_xep_tu_ngay = date('Y-m-d', strtotime($d_xep_tu_ngay . '+ 1 days'));
    if (soSanhNgayHienTai($d_xep_tu_ngay, $d_array_ngay_nghi) == 'false') {
        $dem++;
    }
    $day_of_the_week = date('l', strtotime($d_xep_tu_ngay));
    if ($dem == 1) {
        if (soSanhThu($day_of_the_week, $d_array_phan_cong_chi_tiet) != 'false') {
            $tra_ve               = soSanhThu($day_of_the_week, $d_array_phan_cong_chi_tiet);
            $d_so_gio_hoc_con_lai = $d_so_gio_hoc_con_lai - (float) $tra_ve['gio_hoc'];
            $lich_hoc[$i]         = array(
                'so_gio_hoc_con_lai' => $d_so_gio_hoc_con_lai,
                'ngay_day'           => $d_xep_tu_ngay,
                'thu_day'            => $day_of_the_week,
                'gio_bat_dau'        => $tra_ve['gio_bat_dau'],
                'gio_ket_thuc'       => $tra_ve['gio_ket_thuc'],
                'ma_can_bo'          => $d_get_api['ma_can_bo'],
                'ten_can_bo'         => $d_get_api['ten_can_bo'],
            );
            $dem = 0;
            $i++;
        } else {
            $dem = 0;
        }
    }
}
$lap = 1;
while ($lap <= 3) {
    $d_xep_tu_ngay = date('Y-m-d', strtotime($d_xep_tu_ngay . '+ 1 days'));
    if (soSanhNgayHienTai($d_xep_tu_ngay, $d_array_ngay_nghi) == 'false') {
        $dem++;
    }
    $day_of_the_week = date('l', strtotime($d_xep_tu_ngay));
    if ($dem == 1) {
        if (soSanhThu($day_of_the_week, $d_array_phan_cong_chi_tiet) != 'false') {
            $tra_ve               = soSanhThu($day_of_the_week, $d_array_phan_cong_chi_tiet);
            $d_so_gio_hoc_con_lai = $d_so_gio_hoc_con_lai - (float) $tra_ve['gio_hoc'];
            $lich_hoc[$i]         = array(
                'so_gio_hoc_con_lai' => $d_so_gio_hoc_con_lai,
                'ngay_day'           => $d_xep_tu_ngay,
                'thu_day'            => $day_of_the_week,
                'gio_bat_dau'        => $tra_ve['gio_bat_dau'],
                'gio_ket_thuc'       => $tra_ve['gio_ket_thuc'],
                'ma_can_bo'          => $d_get_api['ma_can_bo'],
                'ten_can_bo'         => $d_get_api['ten_can_bo'],
            );
            $dem = 0;
            $i++;
            $lap++;
        } else {
            $dem = 0;
        }
    }
}
///thu về lịch sử day cua giao vien
// $api = "http://localhost:8080/pj1/api_v2.php?key=" . $key_api . "&ma_lop=" . $d_ma_lop . "&ma_mon_hoc=" . $d_ma_mon_hoc . "&thao_tac=da_day";

$api      = "https://old.notepr.xyz/code/database/api.php?key=" . $key_api . "&ma_lop=" . $d_ma_lop . "&ma_mon_hoc=" . $d_ma_mon_hoc . "&thao_tac=da_day";
$response = file_get_contents($api);
//xử lý json --->array
$response = str_replace('},{', '}|{', $response);
// echo $response;
// die();
$xl_json = explode('|', $response, -1);
for ($i = 0; $i < count($xl_json); $i++) {
    // $ar = new stdClass;
    // $ar=json_decode($xl_json[$i]);
    // print_r($ar);
    $ar = json_decode($xl_json[$i], true);
    // print_r($ar);
    // die();
    $array_da_day[] = array(
        'ngay_day'     => $ar['ngay'],
        'gio_bat_dau'  => $ar['gio_bat_dau'],
        'gio_ket_thuc' => $ar['gio_ket_thuc'],
    );
}
////.end
// echo ("<pre>");
// print_r($array_da_day);
// echo ("\<pre>");
///lặp mảng để trả về đữ liệu
$i = 0;
if (!is_null($array_da_day)) {
    foreach ($array_da_day as $key => $value) {
        //tạo title
        $i++;
        $title = $value['gio_bat_dau'] . "/" . $value['gio_ket_thuc'] . "\nMã Lớp :" . $d_ma_lop . "\nMã Môn:" . $d_ma_mon_hoc;
        //tạo gio bd
        $start = $value['ngay_day'] . " " . $value['gio_bat_dau'];
        // $start=strtotime($temporary);
        //tạo gio kt
        $end = $value['ngay_day'] . " " . $value['gio_ket_thuc'];
        // $end=strtotime($temporary);
        $color       = $quan_ly_mau_nen['da_day'];
        $textColor   = $quan_ly_mau_chu['da_day'];
        $mang_json[] = array(
            'id'        => $i,
            'title'     => $title,
            'start'     => $start,
            'end'       => $end,
            'color'     => $color,
            'textColor' => $textColor,
        );
    }
}
//xử lý mảng tính toán
$count = count($lich_hoc) + count($array_da_day);
foreach ($lich_hoc as $key => $value) {
    //tạo title
    $i++;
    $title = $value['gio_bat_dau'] . "/" . $value['gio_ket_thuc'] . "\nMã Lớp :" . $d_ma_lop . "\nMã Môn:" . $d_ma_mon_hoc;
    //tạo gio bd
    $start = $value['ngay_day'] . " " . $value['gio_bat_dau'];
    // $start=strtotime($temporary);
    //tạo gio kt
    $end = $value['ngay_day'] . " " . $value['gio_ket_thuc'];
    // $end=strtotime($temporary);
    if ($i > ($count - 3)) {
        $color     = $quan_ly_mau_nen['them'];
        $textColor = $quan_ly_mau_chu['them'];
    } else {
        $color     = $quan_ly_mau_nen['tuong_lai'];
        $textColor = $quan_ly_mau_chu['tuong_lai'];
    }
    $mang_json[] = array(
        'id'        => $i,
        'title'     => $title,
        'start'     => $start,
        'end'       => $end,
        'color'     => $color,
        'textColor' => $textColor,
    );
}

// echo ("<pre>");
// print_r($mang_json);
// echo ("\<pre>");

echo json_encode($mang_json);
mysqli_close($connect);