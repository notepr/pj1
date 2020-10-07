<?php require_once "../database/get_danh_sach_toa.php"?>
<p>Chỉnh sửa tình trạng máy</p>
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
<div id="select_all" style="display: inline-block;">
    <p>Tùy chỉnh tất cả:</p>
    <button id="all_hoat_dong" class="btn btn-success">Hoạt động</button>
    <button id="all_bao_tri" class="btn btn-danger">Bảo trì</button>
</div>
<div id="show_danh_sach_may">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Tên máy</th>
                <th scope="col">Cấu hình</th>
                <th scope="col">Tình trạng</th>
                <th scope="col">Tùy chỉnh</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>