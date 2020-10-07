<?php require_once "../database/get_danh_sach_toa.php"?>
<p>Chỉnh sửa thông tin lab</p>
<div class="input-group mb-3" id="chon_toa">
    <div class="input-group-prepend">
        <label class="input-group-text" for="inputGroupSelect01">Chọn tòa</label>
    </div>
    <select class="custom-select" id="inputGroupSelect01">
        <option selected value="default">Tòa</option>
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
        <option selected value="default">Tầng</option>
    </select>
</div>
<div class="input-group mb-3" id="chon_lab">
    <div class="input-group-prepend">
        <label class="input-group-text" for="inputGroupSelect01">Chọn lab</label>
    </div>
    <select class="custom-select" id="inputGroupSelect01">
        <option selected value="default">Lab</option>
    </select>
</div>
<form>
    <div class="form-group">
        <label for="ten_phong">Tên phòng</label>
        <input type="text" class="form-control" id="ten_phong">
    </div>
    <div class="form-group">
        <label for="so_cho_ngoi">Số chỗ ngồi</label>
        <input type="number" class="form-control" id="so_cho_ngoi">
    </div>
    <div class="form-group" id="ma_cau_hinh_old">
        <label for="ma_cau_hinh">Mã cấu hình hiện tại</label>
        <input type="hidden" class="form-control" id="ma_cau_hinh" >
    </div>
    <div class="form-group">
        <label for="ghi_chu">Ghi chú</label>
        <input type="number" class="form-control" id="ghi_chu" placeholder="Ghi chú">
    </div>
    <div class="input-group mb-3" id="chon_cau_hinh">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">Chọn mã cấu hình</label>
        </div>
        <select class="custom-select" id="inputGroupSelect01">
        </select>
    </div>
    <button type="button" class="btn btn-primary" id="btn_modify_thong_tin_lab">Xác nhận</button>
</form>
<div id="show_danh_sach_lab">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Tên lab</th>
                <th scope="col">Số chỗ ngồi</th>
                <th scope="col">Cấu hình</th>
                <th scope="col">Môn có thể học</th>
                <th scope="col">Tình trạng</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>