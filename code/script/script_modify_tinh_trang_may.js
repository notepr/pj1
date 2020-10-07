$(document).ready(function() {
    // Ẩn chọn tầng
    $("#chon_tang").hide();
    // Ẩn chọn lab
    $("#chon_lab").hide();
    // Ẩn show danh sách máy
    $("#show_danh_sach_may").hide();
    // Ẩn button all
    $("#select_all").hide();


    // Hiện chọn tầng khi đã chọn tòa
    $("#chon_toa select").on("change", function() {
        // Xóa những option chọn tầng cũ (nếu có)
        $("#chon_tang select").empty();
        // Ẩn chọn lab
        $("#chon_lab").hide();
        // Xóa show máy cũ (nếu có)
        $("#show_danh_sach_may table tbody").empty();
        // Ẩn show danh sách máy
        $("#show_danh_sach_may").hide();
        // Ẩn button all
        $("#select_all").hide();
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

    // Hiện chọn lab khi đã chọn tầng
    $("#chon_tang select").on("change", function() {
        // Ẩn show danh sách máy
        $("#show_danh_sach_may").hide();
        // Ẩn button all
        $("#select_all").hide();
        // Xóa những option chọn lab cũ (nếu có)
        $("#chon_lab select").empty();
        // Xóa show máy cũ (nếu có)
        $("#show_danh_sach_may table tbody").empty();
        // Lấy mã tầng
        var ma_tang = $("#chon_tang select").val();
        $.ajax({
            url: "../database/get_danh_sach_lab_all.php",
            type: "GET",
            dataType: "json",
            data: {
                ma_tang: ma_tang
            },
            success: function(data) {
                $("#chon_lab select").append(`<option>Lab</option>`);
                $.each(data, function(index, item) {
                    $("#chon_lab select").append(`<option value="${item.ma_phong}">${item.ten_phong}</option>`);
                })
            }
        });
        // Hiển thị chọn lab
        $("#chon_lab").show();
    });

    // Hiển thị danh sách máy khi đã chọn lab
    $("#chon_lab select").on("change", function() {
        // Xóa bảng máy cũ (nếu có)
        $("#show_danh_sach_may table tbody").empty();
        // Lấy mã lab
        var ma_phong = $("#chon_lab select").val();
        $.ajax({
            url: "../database/get_danh_sach_may.php",
            type: "GET",
            dataType: "json",
            data: {
                ma_phong: ma_phong
            },
            success: function(data) {
                $.each(data, function(index, item) {
                    if (item.tinh_trang == 1) {
                        $("#show_danh_sach_may table tbody").append(`
                            <tr>
                                <td>${item.ten_may}</td>
                                <td>${item.chip} - ${item.ram} - ${item.o_cung} - ${item.card_do_hoa} - ${item.man_hinh}</td>
                                <td>${item.check_tinh_trang}</td>
                                <td>
                                    <button value="${item.ma_may}" class="btn btn-danger" data-tinh_trang="${item.tinh_trang}">
                                        Bảo trì
                                    </button>
                                </td>
                            </tr>
                        `);
                    } else {
                            $("#show_danh_sach_may table tbody").append(`
                            <tr>
                                <td>${item.ten_may}</td>
                                <td>${item.chip} - ${item.ram} - ${item.o_cung} - ${item.card_do_hoa} - ${item.man_hinh}</td>
                                <td>${item.check_tinh_trang}</td>
                                <td>
                                    <button value="${item.ma_may}" class="btn btn-success" data-tinh_trang="${item.tinh_trang}">
                                        Hoạt động
                                    </button>
                                </td>
                            </tr>
                        `);
                    }
                });
            }
        });
        // Hiển thị danh sách máy
        $("#show_danh_sach_may").show();
        // Hiển thị các button all
        $("#select_all").show();
        // Hiển thị button selected
        $("#selected").show();
    });

    // Khi người dùng nhấn từng nút
    $("#show_danh_sach_may table tbody").on("click", "button", function() {
        // Lấy mã máy
        var ma_may = $(this).val();
        // Lấy tình trạng
        var tinh_trang = $(this).attr("data-tinh_trang");
        // Gửi lên server để thao tác
        $.ajax({
            url: "../database/modify_tinh_trang_may.php",
            type: "GET",
            dataType: "json",
            data: {
                ma_may: ma_may,
                tinh_trang: tinh_trang
            },
            complete: function() {
                $("#chon_lab select").trigger("change");
            }
        });
        $.toast({
            heading: "Thành công",
            position: {
                right: 100,
                top: 80
            },
            hideAfter: 1500,
            text: "Chỉnh sửa tình trạng máy thành công",
            showHideTransition: 'slide',
            icon: "success"
        });
    });

    // Khi người dùng nhấn nút hoạt động all
    $("#all_hoat_dong").on("click", function() {
        // Lấy mã phòng
        var ma_phong = $("#chon_lab select").val();
        // biến hoạt động
        var hoat_dong = 1;
        $.ajax({
            url: "../database/modify_tinh_trang_may_all.php",
            type: "GET",
            dataType: "json",
            data: {
                ma_phong: ma_phong,
                hoat_dong: hoat_dong
            },
            complete: function() {
                $("#chon_lab select").trigger("change");
                $.toast({
                    heading: "Thành công",
                    position: {
                        right: 100,
                        top: 80
                    },
                    hideAfter: 1500,
                    text: "Chỉnh sửa tình trạng máy thành công",
                    showHideTransition: 'slide',
                    icon: "success"
                });
            }
        });
    });

    // Khi người dùng nhấn nút bảo trì all
    $("#all_bao_tri").on("click", function() {
        // Lấy mã phòng
        var ma_phong = $("#chon_lab select").val();
        // biến bảo trì
        var bao_tri = 1;
        $.ajax({
            url: "../database/modify_tinh_trang_may_all.php",
            type: "GET",
            dataType: "json",
            data: {
                ma_phong: ma_phong,
                bao_tri: bao_tri
            },
            complete: function() {
                $("#chon_lab select").trigger("change");
                $.toast({
                    heading: "Thành công",
                    position: {
                        right: 100,
                        top: 80
                    },
                    hideAfter: 1500,
                    text: "Chỉnh sửa tình trạng máy thành công",
                    showHideTransition: 'slide',
                    icon: "success"
                });
            }
        });
    });

});