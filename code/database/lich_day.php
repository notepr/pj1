<?php
error_reporting(0);
//quan_ly_mau
$quan_ly_mau_nen = array(
    'da_day' => 'red',
    'tuong_lai' => 'blue',
    'them' => 'gray'
);
$quan_ly_mau_chu = array(
    'da_day' => '#FFFFFF',
    'tuong_lai' => '#FFFFFF',
    'them' => '#FFFFFF'
);
///.end quản lý màu
require_once 'connect_dtb.php';
date_default_timezone_set('Asia/Ho_Chi_Minh');
///fun
function So_sanh_ngay_hien_tai($ngay_so_sanh, $array_ngay_nghi)
{
    foreach ($array_ngay_nghi as $each) {
        if ($each['ngay'] == $ngay_so_sanh) {
            return 'true';
            break;
        }
    }
    return 'false';
}
function Chuyen_thanh_thu_dung($thu_php)
{
    switch ($thu_php) {
        case '0':
            return 8;
            break;
        
        default:
            return ($thu_php + 1);
            break;
    }
}
//.end
// $ma_can_bo="29";
// $so_ngay_xem="100";
$xep_tu_ngay = date('Y-m-d');
if (isset($_GET['ma_can_bo']) && !empty($_GET['ma_can_bo'])) {
    $ma_can_bo = mysqli_real_escape_string($connect,$_GET['ma_can_bo']);
} else {
    header('HTTP/1.1 500 Sever Exception');
    header('Content-Type: application/json; charset=UTF-8');
    $error = array(
        'text' => "Bạn Chưa Chọn Cán Bộ Để Có Thể Xử Lý"
    );
    die(json_encode($error));
}
if (isset($_GET['so_ngay_xem']) && !empty($_GET['so_ngay_xem'])) {
    $so_ngay_xem = mysqli_real_escape_string($connect,$_GET['so_ngay_xem']);
    if ($so_ngay_xem > 30) {
        $so_ngay_xem = "30";
    }
    if ($so_ngay_xem < 1) {
        $so_ngay_xem = "1";
    }
} else {
    $so_ngay_xem = "30";
}
if (isset($_GET['xep_tu_ngay']) && !empty($_GET['xep_tu_ngay'])) {
    $xep_tu_ngay = mysqli_real_escape_string($connect,date('Y-m-d', strtotime($_GET['xep_tu_ngay'])));
    if ($xep_tu_ngay < date('Y-m-d')) {
        $xep_tu_ngay = date('Y-m-d');
    }
} else {
    $xep_tu_ngay = date('Y-m-d');
}
// $xep_tu_ngay = '2019-11-05';
///SQL trả về |ma_lop|ma_mon_hoc|tinh_trang|ma_can_bo|ma_phan_cong|ma_phan_cong|thu|gio_bat_dau|gio_ket_thuc|ma_phong
$sql                      = "SELECT phan_cong_day_hoc.ma_phan_cong,phan_cong_day_hoc.ma_can_bo,phan_cong_day_hoc.ma_mon_hoc,phan_cong_day_hoc.ma_lop,phan_cong_chi_tiet.thu,phan_cong_chi_tiet.gio_bat_dau,phan_cong_chi_tiet.gio_ket_thuc,phan_cong_chi_tiet.ma_phong
        FROM `phan_cong_day_hoc` INNER JOIN phan_cong_chi_tiet 
        ON phan_cong_chi_tiet.ma_phan_cong=phan_cong_day_hoc.ma_phan_cong WHERE ma_can_bo='$ma_can_bo'";
$array_phan_cong_chi_tiet = mysqli_query($connect, $sql);
// print_r($array_phan_cong_chi_tiet);
// die();
//Lấy ngày nghỉ của giáo viên và của toàn trường
$sql                      = "SELECT ngay FROM ngay_nghi WHERE (ma_giao_vien=0 or ma_giao_vien='$ma_can_bo') and ngay>='$xep_tu_ngay' ";
$array_ngay_nghi          = mysqli_query($connect, $sql);
// print_r($array_ngay_nghi);
// die();
//lấy ra lịch dạy bù đột xuất của giáo viên
$sql                      = "SELECT * FROM lich_day_dot_xuat WHERE ma_can_bo='$ma_can_bo' and ngay>='$xep_tu_ngay'";
$array_lich_day_dot_xuat  = mysqli_query($connect, $sql);


$xep_tu_ngay = date('Y-m-d', strtotime($xep_tu_ngay . '- 1 days'));
$dem         = 0;
// $thu=date('w', strtotime($xep_tu_ngay));
// echo $thu;
// die();
for ($i = 0; $i < $so_ngay_xem; $i++) {
    $xep_tu_ngay = date('Y-m-d', strtotime($xep_tu_ngay . '+ 1 days'));
    //so sanh xem có bị trùng ngày nghỉ hay không
    if (So_sanh_ngay_hien_tai($xep_tu_ngay, $array_ngay_nghi) == 'false') {
        $dem++;
    }
    if ($dem == 1) {
        $thu_tra_ve = date('w', strtotime($xep_tu_ngay));
        $thu        = Chuyen_thanh_thu_dung($thu_tra_ve);
        $dem_row    = mysqli_num_rows($array_phan_cong_chi_tiet);
        //kiểm tra xem có bản ghi hay không
        if ($dem_row != 0) {
            foreach ($array_phan_cong_chi_tiet as $each) {
                if ($each['thu'] == $thu) {
                    $ket_qua[$xep_tu_ngay][] = array(
                        'ma_lop' => $each['ma_lop'],
                        'ma_mon_hoc' => $each['ma_mon_hoc'],
                        'ma_can_bo' => $each['ma_can_bo'],
                        'ma_phong' => $each['ma_phong'],
                        'gio_bat_dau' => $each['gio_bat_dau'],
                        'gio_ket_thuc' => $each['gio_ket_thuc']
                    );
                }
            }
        }
        $dem_row = mysqli_num_rows($array_lich_day_dot_xuat);
        if ($dem_row != 0) {
            foreach ($array_lich_day_dot_xuat as $each) {
                if ($each['ngay'] == $xep_tu_ngay) {
                    $ket_qua[$xep_tu_ngay][] = array(
                        'ma_lop' => $each['ma_lop'],
                        'ma_mon_hoc' => $each['ma_mon_hoc'],
                        'ma_can_bo' => $each['ma_can_bo'],
                        'ma_phong' => $each['ma_phong'],
                        'gio_bat_dau' => $each['gio_bat_dau'],
                        'gio_ket_thuc' => $each['gio_ket_thuc']
                    );
                }
            }
        }
        $dem = 0;
    } else {
        // $ket_qua[$xep_tu_ngay][]="Nghỉ";    
        $dem = 0;
    }
    if (!isset($ket_qua[$xep_tu_ngay])) {
        // $ket_qua[$xep_tu_ngay][]="Nghỉ";    
    }
}
//chuyển thành mảng sử dụng cho lịch
$array_phong[] = "";
$dem           = 0;
foreach ($ket_qua as $key => $value) {
    // $dem++;
    for ($i = 0; $i < count($value); $i++) {
        $dem++;
        $ma_phong = $value[$i]['ma_phong'];
        if (empty($array_phong[$ma_phong])) {
            $sql_phong              = "SELECT ten_phong from phong where ma_phong='$ma_phong'";
            $data                   = mysqli_query($connect, $sql_phong);
            $a                      = mysqli_fetch_array($data);
            $array_phong[$ma_phong] = $a['ten_phong'];
        }
        $title       = $value[$i]['gio_bat_dau'] . "/" . $value[$i]['gio_ket_thuc'] . "\nMã Lớp :" . $value[$i]['ma_lop'] . "\nMã Môn:" . $value[$i]['ma_mon_hoc'] . "\nPhòng Học:" . $array_phong[$ma_phong];
        $start       = $key . " " . $value[$i]['gio_bat_dau'];
        $end         = $key . " " . $value[$i]['gio_ket_thuc'];
        $color       = $quan_ly_mau_nen['tuong_lai'];
        $textColor   = $quan_ly_mau_chu['tuong_lai'];
        $mang_json[] = array(
            'id' => $dem,
            'title' => $title,
            'start' => $start,
            'end' => $end,
            'color' => $color,
            'textColor' => $textColor
        );
    }
}
if (isset($_GET['check'])) {
if (count($mang_json) == 0) {
    header('HTTP/1.1 500 Sever Exception');
    header('Content-Type: application/json; charset=UTF-8');
    $error = array(
        'text' => "Giáo Viên Bạn Vừa Chọn Không Có Lịch Dạy Nào Cả"
    );
    die(json_encode($error));
}else{
	header('HTTP/1.1 200 DONE');
    header('Content-Type: application/json; charset=UTF-8');
    $error = array(
        'text' => "Có"
    );
    die(json_encode($error));
}
}
echo json_encode($mang_json);

mysqli_close($connect);