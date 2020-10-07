<?php require_once "../database/get_ds_giao_vien.php"?>

<p>Thêm ngày nghỉ</p>

<form>
    <div class="form-group">
        <label for="ngay">Chọn ngày</label>
        <input type="date" class="form-control" id="ngay" value="<?php echo date('Y-m-d',strtotime("+1 day")); ?>">
    </div>
    <div class="form-group">
        <label for="pre-selected-options">Chọn giáo viên</label>
        <select id="pre-selected-options" multiple="multiple" class="giao_vien">
            <option value="0" selected="selected" class="default_value">Tất cả giáo viên</option>

            <?php foreach ($result as $item): ?>
                <option value="<?php echo $item['ma_can_bo'] ?>"><?php echo $item['ho_ten'] ?></option>
            <?php endforeach?>
        </select>
    </div>
    <div class="form-group">
        <label for="ghi_chu">Ghi chú(có thể để trống)</label>
        <input type="text" class="form-control" id="ghi_chu" placeholder="Nhập ghi chú">
    </div>
    <button type="button" id="btn_them_lab">Thêm</button>
</form>

<script src="../multi_select/js/jquery.multi-select.js"></script>