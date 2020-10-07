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
            url: "../database/show_ds_tinh_trang_lab.php",
            type: "GET",
            dataType: "json",
            data: {
                ma_tang: ma_tang
            },
            success: function(data) {
                $.each(data, function(index, item) {
                	if (item.tinh_trang == 1) {
	                    $("#show_danh_sach_lab table tbody").append(`
		                    <tr>
		                        <td>${item.ten_phong}</td>
		                        <td>${item.so_cho_ngoi}</td>
		                        <td>${item.ma_phong}M</td>
		                        <td>${item.chip} - ${item.ram} - ${item.o_cung} - ${item.card_do_hoa} - ${item.man_hinh}</td>
		                        <td>${item.check_tinh_trang}</td>
		                        <td>
									<button value="${item.ma_phong}" class="btn btn-danger" data-tinh_trang="${item.tinh_trang}">Bảo trì</button>
		                        </td>
		                    </tr>
	                	`);
	                }
	                else {
						$("#show_danh_sach_lab table tbody").append(`
		                    <tr>
		                        <td>${item.ten_phong}</td>
		                        <td>${item.so_cho_ngoi}</td>
		                        <td>${item.ma_phong}M</td>
		                        <td>${item.chip} - ${item.ram} - ${item.o_cung} - ${item.card_do_hoa} - ${item.man_hinh}</td>
		                        <td>${item.check_tinh_trang}</td>
		                        <td>
									<button value="${item.ma_phong}" class="btn btn-success" data-tinh_trang="${item.tinh_trang}">Hoạt động</button>
		                        </td>
		                    </tr>
	                	`);
	                }
                });
            }
        });
        // Hiển thị ra bảng
        $("#show_danh_sach_lab").show();
    });

    // Khi người dúng nhấn bảo trì lab
    $("#show_danh_sach_lab table tbody").on("click", "button", function() {
        // Lấy mã lab
        var ma_phong = $(this).val();
        // Lấy mã tình trạng
        var tinh_trang = $(this).attr("data-tinh_trang");
        // Gửi mã lab lên server và điều chỉnh
        $.ajax({
            url: "../database/modify_tinh_trang_lab.php",
            type: "GET",
            dataType: "json",
            data: {
                ma_phong: ma_phong,
                tinh_trang: tinh_trang
            },
            complete: function() {
                // Xóa những bảng lab cũ nếu có
                $("#show_danh_sach_lab table tbody").empty();
                // Lấy mã tầng
                var ma_tang = $("#chon_tang select").val();
                $.ajax({
                    url: "../database/show_ds_tinh_trang_lab.php",
                    type: "GET",
                    dataType: "json",
                    data: {
                        ma_tang: ma_tang,
                    },
                    success: function(data) {
	                    $.each(data, function(index, item) {
	                    	if (item.tinh_trang == 1) {
	                    		$("#show_danh_sach_lab table tbody").append(`
				                    <tr>
				                        <td>${item.ten_phong}</td>
				                        <td>${item.so_cho_ngoi}</td>
				                        <td>${item.ma_phong}M</td>
				                        <td>${item.chip} - ${item.ram} - ${item.o_cung} - ${item.card_do_hoa} - ${item.man_hinh}</td>
				                        <td>${item.check_tinh_trang}</td>
				                        <td>
										<button value="${item.ma_phong}" class="btn btn-danger" data-tinh_trang="${item.tinh_trang}">Bảo trì</button>
			                       		</td>
				                    </tr>
			                	`);
	                    	}
	                    	else {
	                    		$("#show_danh_sach_lab table tbody").append(`
				                    <tr>
				                        <td>${item.ten_phong}</td>
				                        <td>${item.so_cho_ngoi}</td>
				                        <td>${item.ma_phong}M</td>
				                        <td>${item.chip} - ${item.ram} - ${item.o_cung} - ${item.card_do_hoa} - ${item.man_hinh}</td>
				                        <td>${item.check_tinh_trang}</td>
				                        <td>
										<button value="${item.ma_phong}" class="btn btn-success" data-tinh_trang="${item.tinh_trang}">Hoạt động</button>
			                       		</td>
				                    </tr>
			               		`);
	                    	}
	                    });
                        $.toast({
                            heading: "Thành công",
                            position: {
                                right: 100,
                                top: 80
                            },
                            hideAfter: 1000,
                            text: "Chỉnh sửa tình trạng thành công",
                            showHideTransition: 'slide',
                            icon: "success"
                        });
                    }
                });
            }
        });
    });
});