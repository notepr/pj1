$(document).ready(function() {
    // Ẩn chọn tầng
    $("#chon_tang").hide();
    // Ẩn show danh sách lab
    $("#show_danh_sach_lab").hide();

    // Hiện chọn tầng khi đã chọn tòa
    $("#chon_toa select").on("change", function() {
        // Xóa những option chọn tầng cũ (nếu có)
        $("#chon_tang select").empty();
        // Xóa những bảng lab cũ nếu có
        $("#show_danh_sach_lab table tbody").empty();
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

    // Hiện danh sách lab khi đã chọn tầng
    $("#chon_tang").on("change", function() {
        // Xóa những bảng lab cũ nếu có
        $("#show_danh_sach_lab table tbody").empty();
        // Lấy mã tầng
        var ma_tang = $("#chon_tang select").val();
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
                    text: "Đã lấy được danh phòng",
                    showHideTransition: 'slide',
                    icon: "success"
                });
            }
        });
        // Hiển thị ra bảng
        $("#show_danh_sach_lab").show();
    });
});