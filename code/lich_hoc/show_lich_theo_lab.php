<p>Xem lịch theo lab</p>

<?php require_once "../database/get_danh_sach_toa.php"?>
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
<div class="input-group mb-3" id="chon_lab">
    <div class="input-group-prepend">
        <label class="input-group-text" for="inputGroupSelect01">Chọn lab</label>
    </div>
    <select class="custom-select" id="inputGroupSelect01">
        <option selected>Lab</option>
    </select>
</div>
<div id="show_lich">
    <table class="table table-striped">
        <thead>
            <tr>
            	<th>Thứ</th>
            	<th>Lớp</th>
            	<th>Môn</th>
            	<th>Giáo viên</th>
            	<th>Giờ bắt đầu</th>
            	<th>Giờ kết thúc</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>