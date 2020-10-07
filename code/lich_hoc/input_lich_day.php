<div class="container shadow">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="exampleDropdown">Chọn Cán Bộ</label>
                    <select class="form-control" id="ma_can_bo">
                    </select>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="exampleDropdown">Ngày Kiểm Tra</label>
                    <input class="form-control" type="date" id="xep_tu_ngay" name="xep_tu_ngay" value="<?php echo date('Y-m-d');?>">
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="exampleDropdown">Số Ngày Kiểm Tra</label>
                    <input class="form-control" type="number" name="so_ngay_xem" id="so_ngay_xem" value="30">
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <center>
                    <button type="button" class="btn btn-success" id="xem_lich_day">Xem Lịch Dạy</button>
                </center>
            </div>
        </div>
        <div id='calendar'></div>
    </div>
    </div>
</div>

