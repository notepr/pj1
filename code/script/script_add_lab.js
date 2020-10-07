$(document).ready(function() {
    // Ẩn chọn tầng
    $("#chon_tang").hide();
    // Ẩn form
    $("form").hide();
    // Ẩn bảng hiển thị các lab
    $("#show_danh_sach_lab").hide();
    // Hiện chọn tầng khi đã chọn tòa
    $("#chon_toa select").on("change", function() {
        $('form').trigger("reset");
        // Xóa những option chọn tầng cũ (nếu có)
        $("#chon_tang select").empty();
        // Ẩn form
        $("form").hide();
        // Xóa show cũ
        $("#show_danh_sach_lab table tbody").empty();
        // Ẩn bảng hiển thị các lab
        $("#show_danh_sach_lab").hide();
        // Lấy mã tòa
        var ma_toa = $("#chon_toa select").val();
        // Lấy danh sách tầng theo tòa
        $.ajax({
            url: "../database/get_danh_sach_tang.php",
            type: "GET",
            dataType: "json",
            data: {
                ma_toa: ma_toa
            },
            success: function(data) {
                $("#chon_tang select").append(`<option>Tầng</option>`);
                $.each(data, function(index, item) {
                    $("#chon_tang select").append(`<option value="${item.ma_tang}">${item.ten_tang}</option>`);
                })
            }
        });
        // Hiển thị chọn tầng
        $("#chon_tang").show();
    });

    // Khi nhấn chọn tầng
    $("#chon_tang select").on("change", function() {
        // Xóa option chọn cấu hình cũ
        $("#chon_cau_hinh select").empty();
        // Lấy dữ liệu mã cấu hình - đưa vào select cấu hình
        $.ajax({
            url: "../database/get_ds_cau_hinh.php",
            type: "GET",
            dataType: "json",
            success: function(data) {
                $.each(data, function(index, item) {
                    $("#chon_cau_hinh select").append(`<option value="${item.ma_cau_hinh}">(Mã ${item.ma_cau_hinh}) ${item.chip} - ${item.ram} - ${item.o_cung} - ${item.card_do_hoa} - ${item.man_hinh}</option>`);
                });
            }
        })
        // Hiển thị form
        $("form").show();
    });

    // Khi nhấn nút thêm
    $("#btn_them_lab").on("click", function(){
        // Lấy mã tầng
        var ma_tang = $("#chon_tang select").val();
        // Lấy tên phòng
        var ten_phong = $("#ten_phong").val();
        if (ten_phong == "") {
            $.toast({
                heading: "Thất bại",
                position: {
                    right: 100,
                    top: 80
                },
                hideAfter: 5000,
                text: "Ban cần nhập tên phòng",
                showHideTransition: 'slide',
                icon: "error"
            });
            return false;
        }
        // Lấy số chỗ ngồi
        var so_cho_ngoi = $("#so_cho_ngoi").val();
        if (so_cho_ngoi == "") {
            $.toast({
                heading: "Thất bại",
                position: {
                    right: 100,
                    top: 80
                },
                hideAfter: 5000,
                text: "Ban cần nhập số chỗ ngồi",
                showHideTransition: 'slide',
                icon: "error"
            });
            return false;
        }
        // Lấy ghi chú
        var ghi_chu = $("#ghi_chu").val();
        // Lấy tình trạng
        var tinh_trang = $("#chon_tinh_trang select").val();
        // Lấy mã cấu hình
        var ma_cau_hinh = $("#chon_cau_hinh select").val();

        // Hiển thị lại bảng danh sách lab
        $.ajax({
            url: "../database/add_lab_dtb.php",
            type: "GET",
            dataType: "json",
            data: {
                ten_phong: ten_phong,
                so_cho_ngoi: so_cho_ngoi,
                tinh_trang: tinh_trang,
                ghi_chu: ghi_chu,
                ma_cau_hinh: ma_cau_hinh,
                ma_tang: ma_tang
            },
            complete: function() {
                    $.ajax({
                    url: "../database/show_danh_sach_lab_all.php",
                    type: "GET",
                    dataType: "json",
                    data: {
                        ma_tang: ma_tang
                    },
                    success: function(data) {
                        $.each(data, function(index, item) {
                            $("#show_danh_sach_lab table tbody").append(`
                                <tr>
                                    <td>${item.ma_phong}</td>
                                    <td>${item.ten_phong}</td>
                                    <td>${item.so_cho_ngoi}</td>
                                    <td>${item.mon_co_the_hoc}</td>
                                    <td>${item.check_tinh_trang}</td>
                                </tr>
                            `);
                        });
                        $.toast({
                            heading: "Thành công",
                            position: {
                                right: 100,
                                top: 80
                            },
                            hideAfter: 5000,
                            text: "Đã thêm phòng",
                            showHideTransition: 'slide',
                            icon: "success"
                        });
                    }

                });
            }
        });
        // Ẩn đi form chọn
        $("form").hide();
        // Hiển thị bảng danh sách lab
        $("#show_danh_sach_lab").show();
    });
});