<?php require_once "../database/get_danh_sach_toa.php"?>
<p>Xem danh sách phòng lab</p>
<div class="input-group mb-3" id="chon_toa">
    <div class="input-group-prepend">
        <label class="input-group-text" for="inputGroupSelect01">Chọn tòa</label>
    </div>
    <select class="custom-select" id="inputGroupSelect01">
        <option selectd>Tòa</option>
        <?php foreach ($danh_sach_toa as $item): ?>
        <option value="<?php echo $item['ma_toa'] ?>">
            <?php echo $item['ten_toa'] ?>
        </option>
        <?php endforeach?>
    </select>
</div>
<div class="input-group mb-3" id="chon_tang">
    <div class="input-group-prepend">
        <label class="input-group-text" for="inputGroupSelect01">Chọn tầng</label>
    </div>
    <select class="custom-select" id="inputGroupSelect01">
        <option selected>Tầng</option>
    </select>
</div>
<div id="show_danh_sach_lab">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Tên lab</th>
                <th scope="col">Số chỗ ngồi</th>
                <th scope="col">Các môn có thể học</th>
                <th scope="col">Tình trạng</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
<!-- <script src="../script/script_no_pjax/script_ds_lab_no_pjax.js"></script> -->