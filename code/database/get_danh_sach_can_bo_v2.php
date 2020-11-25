<?php
error_reporting(0);
function vnToStr($str) {

    $unicode = array(

        'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',

        'd' => 'đ',

        'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',

        'i' => 'í|ì|ỉ|ĩ|ị',

        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',

        'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',

        'y' => 'ý|ỳ|ỷ|ỹ|ỵ',

        'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',

        'D' => 'Đ',

        'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',

        'I' => 'Í|Ì|Ỉ|Ĩ|Ị',

        'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',

        'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',

        'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',

    );

    foreach ($unicode as $nonUnicode => $uni) {

        $str = preg_replace("/($uni)/i", $nonUnicode, $str);

    }
    $str = str_replace(' ', '_', $str);

    return $str;
}
require_once 'connect_dtb.php';
$key_api = "nguvl";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($connect, $_GET['search']);
    $search = mysqli_real_escape_string($connect, vnToStr($search));
} else {
    $search = "";
}

$api      = "https://old.notepr.xyz/code/database/api.php?key=" . $key_api . "&thao_tac=ds_giao_vien" . "&search=" . $search;
$response = file_get_contents($api);
if (is_null($response)) {
    echo "Lỗi Trong Việc Gọi API Xin Kiểm Tra Lại (ERR_API_02)";
    die();
}
// $response=str_replace( '{', '', $response );
$response = str_replace('},{', '}|{', $response);
$xl_json  = explode('|', $response);
for ($i = 0; $i < count($xl_json); $i++) {
    $ar      = json_decode($xl_json[$i], true);
    $array[] = array(
        'ma_can_bo' => $ar['ma_can_bo'],
        'data'      => $ar['ho_ten'] . "|" . $ar['email'],
    );
}

echo json_encode($array);
//echo "string";

mysqli_close($connect);
?>