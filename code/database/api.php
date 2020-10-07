<?php
$key_api = "nguvl";

$method = $_SERVER['REQUEST_METHOD'];

$input = json_decode(file_get_contents('php://input'), true);
// connect to the mysql database
// $severname = "localhost";
// $username  = "admin";
// $password  = "8a2bef85c8cc8c69e";
// $database  = "bkacad";
$connect = mysqli_connect('localhost', 'root', '', 'bkacad');
mysqli_set_charset($connect, 'utf8');

//XỬ LÝ IF
switch ($method) {
case 'GET':
    $key = "";
    if (isset($_GET['ma_mon_hoc'])) {
        $ma_mon_hoc = mysqli_real_escape_string($connect, $_GET['ma_mon_hoc']);
    }
    if (isset($_GET['key'])) {
        $key = mysqli_real_escape_string($connect, $_GET['key']);
    }
    if (isset($_GET['ma_lop'])) {
        $ma_lop = mysqli_real_escape_string($connect, $_GET['ma_lop']);
    }
    if (isset($_GET['thao_tac'])) {
        $thao_tac = mysqli_real_escape_string($connect, $_GET['thao_tac']);
    } else {
        $thao_tac = '';
    }
    if (isset($_GET['search'])) {
        $search = mysqli_real_escape_string($connect, $_GET['search']);
    } else {
        $search = '';
    }
    switch ($thao_tac) {
    case 'gio-da-day':
        if ($key == $key_api && $ma_mon_hoc != '' && $ma_lop != '') {
            $sql = "SELECT COUNT(((MINUTE(gio_ket_thuc)+hour(gio_ket_thuc)*60)-(MINUTE(gio_bat_dau)+hour(gio_bat_dau)*60))/60) as gio_da_day FROM checkon WHERE cac_lop='$ma_lop' AND ma_mon_hoc='$ma_mon_hoc'";
        }
        break;
    case 'gio-dinh-muc':
        if ($key == $key_api && $ma_mon_hoc != '') {
            $sql = "SELECT so_gio as 'gio_dinh_muc' FROM mon_hoc WHERE ma_mon_hoc='$ma_mon_hoc'";
        }
        break;
    case 'cac-mon-hoc':
        if ($key == $key_api) {
            $sql = "SELECT ma_mon_hoc,ten_mon_tv,ten_mon_ta FROM mon_hoc";
        }
        break;
    case 'giao-vien':
        if ($key == $key_api) {
            $sql = "SELECT can_bo.ma_can_bo,can_bo.ho_ten AS 'ten_can_bo',dinh_muc.so_gio AS 'gio_dinh_muc',dinh_muc.ma_mon_hoc,dinh_muc.ma_lop FROM phan_cong_day_hoc LEFT JOIN can_bo ON can_bo.ma_can_bo=phan_cong_day_hoc.ma_can_bo LEFT JOIN dinh_muc ON dinh_muc.ma_mon_hoc=phan_cong_day_hoc.ma_mon_hoc AND dinh_muc.ma_lop=phan_cong_day_hoc.ma_lop WHERE phan_cong_day_hoc.ma_mon_hoc='$ma_mon_hoc' AND phan_cong_day_hoc.ma_lop='$ma_lop'";
        }
        break;
    case 'ds_sinh_vien':
        if ($key == $key_api) {
            $sql = "SELECT COUNT(ma_sinh_vien_bkacad) as 'tong_sinh_vien' FROM `sinh_vien` WHERE ma_lop='$ma_lop'";
        }
        break;
    case 'ds_giao_vien':
        if ($key == $key_api) {
            $sql = "SELECT DISTINCT ma_can_bo,ho_ten,email FROM can_bo WHERE ho_ten like '%$search%' or email like '%$search%' GROUP BY ma_can_bo";
        }
        break;
    case 'da_day':
        if ($key == $key_api) {
            $sql = "SELECT ngay,gio_bat_dau,gio_ket_thuc FROM checkon WHERE cac_lop='$ma_lop' and ma_mon_hoc='$ma_mon_hoc'";
        }
        break;
    case 'mon_hoc':
        if ($key == $key_api) {
            $sql = "SELECT * from mon_hoc";
        }
        break;
    default:
        break;
    }
default:
    break;
}
$sql = "SELECT * from mon_hoc";
print_r($sql);
if (empty($sql)) {
    $sql = "null";
}
$result = mysqli_query($connect, $sql);
// die if SQL statement failed
if (!$result) {
    //http_response_code(404);
    //die(mysqli_error());
    echo "null";
} else {
    // print results, insert id or affected row count
    if ($method == 'GET') {
        if (!$key) {
            echo '[';
        }

        for ($i = 0; $i < mysqli_num_rows($result); $i++) {
            echo ($i > 0 ? ',' : '') . json_encode(mysqli_fetch_object($result));
        }

        if (!$key) {
            echo ']';
        }

    } elseif ($method == 'POST') {
        echo mysqli_insert_id($connect);
    } else {
        echo mysqli_affected_rows($connect);
    }
}
// close mysql connection
mysqli_close($connect);
