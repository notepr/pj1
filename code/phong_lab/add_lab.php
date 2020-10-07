<?php require_once "../database/get_danh_sach_toa.php"?>
<p>Thêm lab</p>
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

<form>
    <div class="form-group">
        <label for="ten_phong">Tên phòng</label>
        <input type="text" class="form-control" id="ten_phong" placeholder="Nhập tên phòng">
    </div>
    <div class="form-group">
        <label for="so_cho_ngoi">Số chỗ ngồi</label>
        <input type="number" class="form-control" id="so_cho_ngoi" placeholder="Nhập tình trạng" value=20>
    </div>
    <div class="form-group">
        <label for="ghi_chu">Ghi chú(có thể để trống)</label>
        <input type="text" class="form-control" id="ghi_chu" placeholder="Nhập ghi chú">
    </div>
    <div class="input-group mb-3" id="chon_tinh_trang">
        <div class="input-group-prepend">
            <label class="input-group-text" for="tinh_trang">Tình trạng</label>
        </div>
        <select class="custom-select" id="tinh_trang">
            <option value="1" selected>Hoạt động</option>
            <option value="2">Bảo trì</option>
        </select>
    </div>
    <div class="input-group mb-3" id="chon_cau_hinh">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">Chọn cấu hình</label>
        </div>
        <select class="custom-select" id="inputGroupSelect01">
        </select>
    </div>

    <button type="button" id="btn_them_lab" class="btn btn-success">Thêm</button>
</form>

<div id="show_danh_sach_lab">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Tên lab</th>
                <th scope="col">Mã máy</th>
                <th scope="col">Số chỗ ngồi</th>
                <th scope="col">Các môn có thể học</th>
                <th scope="col">Tình trạng</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
