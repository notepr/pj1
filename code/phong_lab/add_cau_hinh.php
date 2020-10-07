<p>Thêm cấu hình</p>
<form>
    <div class="form-group">
        <label for="chip">Chip</label>
        <input type="text" class="form-control" id="chip" placeholder="Chip">
    </div>
    <div class="form-group">
        <label for="ram">RAM</label>
        <input type="text" class="form-control" id="ram" placeholder="RAM">
    </div>
    <div class="form-group">
        <label for="o_cung">Ổ cứng</label>
        <input type="text" class="form-control" id="o_cung" placeholder="Ổ cứng">
    </div>
    <div class="form-group">
        <label for="card_do_hoa">Card đồ họa</label>
        <input type="text" class="form-control" id="card_do_hoa" placeholder="Card đồ họa">
    </div>
    <div class="form-group">
        <label for="man_hinh">Màn hình</label>
        <input type="text" class="form-control" id="man_hinh" placeholder="Màn hình">
    </div>
    <div class="form-group">
    <?php require_once "../database/get_ds_mon_hoc.php" ?>
    <label>Chọn các môn học phù hợp
      <select id='pre-selected-options' multiple='multiple' class="cac_mon">
        <?php foreach ($result as $item): ?>
          <option value="<?php echo $item['ma_mon_hoc'] ?>"><?php echo $item['ma_mon_hoc'] ?> - <?php echo $item['ten_mon_tv'] ?></option>
        <?php endforeach ?>
      </select>
    </label>
    </div>
	<button type="button" class="btn btn-primary" id="btn_them_cau_hinh">Thêm</button>
</form>
<div id="show_danh_sach_cau_hinh">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Chip</th>
                <th scope="col">Ram</th>
                <th scope="col">Ổ cứng</th>
                <th scope="col">Card đồ họa</th>
                <th scope="col">Màn hình</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
<script src="../multi_select/js/jquery.multi-select.js"></script>
