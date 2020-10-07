<p>Cập nhập cấu hình môn học</p>

<?php require_once "../database/get_ds_cau_hinh_no_json.php" ?>

<select class="custom-select" id="chon_cau_hinh">
    <option selectd>Cấu hình</option>
    <?php foreach ($result as $item): ?>
    <option value="<?php echo $item['ma_cau_hinh'] ?>">
        <?php echo "Mã: ". $item['ma_cau_hinh'] . " - " . $item["chip"]. ", " .$item['ram']. ", " .$item['o_cung']. ", " .$item['card_do_hoa']. ", " .$item['man_hinh']; ?>
    </option>
    <?php endforeach?>
</select>
<div id="title_chon_cac_mon">
	<p style="display: inline-block;">Môn chưa chọn</p>
	<p style="display: inline-block; margin-left: 440px;">Môn đã chọn</p>
</div>
<div class="form-group" id="chon_cac_mon">
	<select id="pre-selected-options" multiple="multiple" class="cac_mon">
	</select>
</div>
<div id="show_cau_hinh_mon_hoc">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Cấu hình</th>
                <th scope="col">Các môn có thể học</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
<input type="hidden" id="arr_cac_mon">
<button type="button" class="btn btn-primary" id="btn_chinh_sua_cau_hinh">Xác nhận</button>

<script src="../multi_select/js/jquery.multi-select.js"></script>