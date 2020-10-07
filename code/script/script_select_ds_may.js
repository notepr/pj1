$(document).ready(function() {
    // Ẩn chọn tầng
    $("#chon_tang").hide();
    // Ẩn chọn lab
    $("#chon_lab").hide();
    // Ẩn show danh sách máy
    $("#show_danh_sach_may").hide();

    // Hiện chọn tầng khi đã chọn tòa
    $("#chon_toa select").on("change", function() {
        // Xóa những option chọn tầng cũ (nếu có)
        $("#chon_tang select").empty();
        // Xóa show máy cũ (nếu có)
        $("#show_danh_sach_may table tbody").empty();
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
                console.log(data);
                $.each(data, function(index, item) {
                    $("#show_danh_sach_may table tbody").append(`
                        <tr>
                            <td>${item.ten_may}</td>
                            <td>${item.chip} - ${item.ram} - ${item.o_cung} - ${item.card_do_hoa} - ${item.man_hinh}</td>
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
                    text: "Đã lấy được danh sách",
                    showHideTransition: 'slide',
                    icon: "success"
                });
            }
        });
        // Hiển thị danh sách máy
        $("#show_danh_sach_may").show();
    });
});