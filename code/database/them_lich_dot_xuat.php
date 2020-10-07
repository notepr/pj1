<?php
require_once 'connect_dtb.php';
date_default_timezone_set('Asia/Ho_Chi_Minh');
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
$dem = 0;
if (isset($_GET['ngay']) && !empty($_GET['ngay'])) {
    $ngay = mysqli_real_escape_string($connect, $_GET['ngay']);
    $dem++;
}
if (isset($_GET['gio_bat_dau']) && !empty($_GET['gio_bat_dau'])) {
    $gio_bat_dau = mysqli_real_escape_string($connect, $_GET['gio_bat_dau']);
    $dem++;
}
if (isset($_GET['gio_ket_thuc']) && !empty($_GET['gio_ket_thuc'])) {
    $gio_ket_thuc = mysqli_real_escape_string($connect, $_GET['gio_ket_thuc']);
    $dem++;
}
if (isset($_GET['ma_mon_hoc']) && !empty($_GET['ma_mon_hoc'])) {
    $ma_mon_hoc = mysqli_real_escape_string($connect, $_GET['ma_mon_hoc']);
    $dem++;
}
if (isset($_GET['ma_can_bo']) && !empty($_GET['ma_can_bo'])) {
    $ma_can_bo = mysqli_real_escape_string($connect, $_GET['ma_can_bo']);
    $dem++;
}
if (isset($_GET['ma_phong']) && !empty($_GET['ma_phong'])) {
    $ma_phong = mysqli_real_escape_string($connect, $_GET['ma_phong']);
    $dem++;
    if ($ma_phong == 'default') {
        error("Hãy Chọn Phòng Trước Khi Thêm Lịch");
    }
} else {
    error("Mã Phòng Không Được Để Trống");
}
if (isset($_GET['ghi_chu']) && !empty($_GET['ghi_chu'])) {
    $ghi_chu = mysqli_real_escape_string($connect, $_GET['ghi_chu']);
    $dem++;
} else {
    $ghi_chu = "";
    $dem++;
}
if (isset($_GET['ma_lop']) && !empty($_GET['ma_lop'])) {
    $ma_lop = mysqli_real_escape_string($connect, $_GET['ma_lop']);
    $dem++;
}
if ($dem == 8) {
    $sql = "SELECT *
                FROM   `lich_day_dot_xuat`
                WHERE  ngay = '$ngay'
                       AND ma_lop = '$ma_lop'
                       AND ma_can_bo = '$ma_can_bo'
                       AND ma_mon_hoc = '$ma_mon_hoc'
                       AND gio_bat_dau = '$gio_bat_dau'
                       AND gio_ket_thuc = '$gio_ket_thuc' ";
    $array = mysqli_query($connect, $sql);
    if (mysqli_num_rows($array) == 0) {
        $sql = "INSERT INTO `lich_day_dot_xuat`
                                (`ma_dot_xuat`,
                                 `ngay`,
                                 `ma_lop`,
                                 `ma_mon_hoc`,
                                 `ma_can_bo`,
                                 `gio_bat_dau`,
                                 `gio_ket_thuc`,
                                 `ma_phong`,
                                 `ghi_chu`)
                    VALUES      (NULL,
                                 '$ngay',
                                 '$ma_lop',
                                 '$ma_mon_hoc',
                                 '$ma_can_bo',
                                 '$gio_bat_dau',
                                 '$gio_ket_thuc',
                                 '$ma_phong',
                                 '$ghi_chu')";
        $array = mysqli_query($connect, $sql);
        if ($array == 1) {
            done("Đã Thêm Lịch Học Đột Xuất Thành Công");
        } else {
            error("Có Lỗi Phát Sinh Hãy Báo Kĩ Thuật");
        }
    } else {
        error("Đã Tồn Tại Lịch Học Này");
    }
} else {
    error("Có Lỗi Phát Sinh Hãy Báo Kĩ Thuật");
}
mysqli_close($connect);
?>