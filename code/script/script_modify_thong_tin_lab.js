$(document).ready(function() {
    // Ẩn chọn tầng
    $("#chon_tang").hide();
    // Ẩn chọn lab
    $("#chon_lab").hide();
    // Ẩn forms
    $("form").hide();
    // Ẩn bảng show các lab
    $("#show_danh_sach_lab").hide();
    // Ẩn mã cấu hình cũ
    $("#ma_cau_hinh_old").hide();

    // Hiện chọn tầng khi đã chọn tòa
    $("#chon_toa select").on("change", function() {
        // Ẩn bảng show các lab
        $("#show_danh_sach_lab").hide();
        // Ẩn forms
        $("form").hide();
        // Ẩn chọn lab
        $("#chon_lab").hide();
        // Xóa những option chọn tầng cũ (nếu có)
        $("#chon_tang select").empty();
        // Xóa những option chọn lab cũ (nếu có)
        $("#chon_lab select").empty();
        // Xóa show cũ
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

    // Hiện chọn lab khi đã chọn tầng
    $("#chon_tang select").on("change", function() {
        // Ẩn forms
        $("form").hide();
        // Xóa những option chọn lab cũ (nếu có)
        $("#chon_lab select").empty();
        // Xóa show máy cũ (nếu có)
        $("#show_danh_sach_lab table tbody").empty();
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

    // Hiển thị form khi đã chọn lab
    $("#chon_lab select").on("change", function() {
    	// Lấy mã lab
    	var ma_phong = $(this).val();
        // Xóa những option cấu hình cũ
        $("#chon_cau_hinh select").empty();
    	// Lấy về thông tin lab
    	$.ajax({
    		url: "../database/get_lab.php",
    		type: "GET",
    		dataType: "json",
    		data: {ma_phong: ma_phong},
    		success: function(data) {
    			$("#ten_phong").attr("value", data.ten_phong);
    			$("#so_cho_ngoi").attr("value", data.so_cho_ngoi);
    			$("#ma_cau_hinh").attr("value", data.ma_cau_hinh);
    		}
    	});


    	// Lấy mã cấu hình hiện tại
    	var ma_cau_hinh = $("#ma_cau_hinh").val();

    	// Lấy về danh sách cấu hình
	    $.ajax({
			url: "../database/get_ds_cau_hinh.php",
	        type: "GET",
	        dataType: "json",
	        success: function(data) {
	            $.each(data, function(index, item) {
	            	if (item.ma_cau_hinh == ma_cau_hinh) {
	            		$("#chon_cau_hinh select").append(`<option value="${item.ma_cau_hinh}" selected>${item.chip} - ${item.ram} - ${item.o_cung} - ${item.card_do_hoa} - ${item.man_hinh}</option>`);
	            	} else {
	                	$("#chon_cau_hinh select").append(`<option value="${item.ma_cau_hinh}">${item.chip} - ${item.ram} - ${item.o_cung} - ${item.card_do_hoa} - ${item.man_hinh}</option>`);
	                }
	            });
	        }
	    });
    	// Hiển thị form
    	$("form").show();
    });

    // Khi nhấn nút sửa
    $("#btn_modify_thong_tin_lab").on("click", function() {
    	// Lấy mã tầng
    	var ma_tang = $("#chon_tang select").val();
 		// Lấy mã phòng
 		var ma_phong = $("#chon_lab select").val();
    	// Lấy tên phòng
    	var ten_phong = $("#ten_phong").val();
    	if (ten_phong == "") {
            $.toast({
	            heading: "Thất bại",
	            position: {
	                right: 100,
	                top: 80
	            },
	            hideAfter: 1000,
	            text: "Bạn chưa nhập tên phòng",
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
	            hideAfter: 1000,
	            text: "Bạn chưa nhập số chỗ ngồi",
	            showHideTransition: 'slide',
	            icon: "error"
        	});
        	return false;
    	}
    	// Lấy mã cấu hình
    	var ma_cau_hinh = $("#chon_cau_hinh select").val();

    	$.ajax({
    		url: "../database/modify_thong_tin_lab.php",
    		type: "GET",
    		dataType: "json",
    		data: {
    			ma_phong: ma_phong,
    			ten_phong: ten_phong,
    			so_cho_ngoi: so_cho_ngoi,
    			ma_cau_hinh: ma_cau_hinh
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
			                        <td>${item.ten_phong}</td>
			                        <td>${item.so_cho_ngoi}</td>
			                        <td>${item.chip}, ${item.ram}, ${item.o_cung}, ${item.card_do_hoa}, ${item.man_hinh}</td>
			                        <td>${item.mon_co_the_hoc}</td>
			                        <td>${item.check_tinh_trang}</td>
			                    </tr>
			                `);
	                    });
                    }
                });
    		}
    	});
    	// Ẩn forms
    	$("form").hide();
    	// Ẩn chọn lab
    	$("#chon_lab").hide();
   	 	// Hiển thị bảng các lab
    	$("#show_danh_sach_lab").show();

        // reset select về default
        $("select").val($("select option:first").val());
        // Ẩn chọn tầng
        $("#chon_tang").hide();
    });
});