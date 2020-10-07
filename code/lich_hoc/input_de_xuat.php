<div class="container shadow">
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <label for="exampleDropdown">Chọn Cán Bộ</label>
                <select class="form-control" id="ma_can_bo" name="ma_can_bo">
                </select>
            </div>
            <div class="form-group">
                <label for="exampleDropdown">Chọn Lớp</label>
                <select class="form-control" id="ma_lop" name="ma_lop">
                </select>
            </div>
            <div class="form-group">
                <label for="exampleDropdown">Chọn Môn Học</label>
                <select class="form-control" id="ma_mon_hoc" name="ma_mon_hoc">
                </select>
            </div>
            <div class="form-group">
                <label for="exampleDropdown">Kiểm Tra Từ Ngày</label>
                <input class="form-control" type="date" id="xep_tu_ngay" name="xep_tu_ngay" value="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="form-group">
                <label for="exampleDropdown">Số Ngày Kiểm Tra</label>
                <input class="form-control" type="number" name="so_ngay_xem" id="so_ngay_xem" value="7">
            </div>
            <div class="form-group">
                <label for="exampleDropdown">Số Giờ Dạy</label>
                <select title="Hãy Chọn Số Giờ" class="form-control" id="gio_day" name="gio_day">
                    <option value="2">2 Giờ</option>
                    <option value="4">4 Giờ</option>
                </select>
            </div>
            <center>
                <button class="btn btn-success" type="button" id="xem_de_xuat">Xem Lịch Dạy</button>
            </center>
        </div>
        <div id="table_de_xuat" style="width: 100%">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Giờ Bắt Đầu</th>
                        <th scope="col">Giờ Kết Thúc</th>
                        <th scope="col">Chọn Phòng</th>
                        <th scope="col">Ghi Chú</th>
                        <th scope="col">Hành Động</th>
                    </tr>
                </thead>
                <tbody id="table_data">
                </tbody>
            </table>
        </div>
    </div>
</div>

