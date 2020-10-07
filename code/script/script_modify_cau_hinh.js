$(document).ready(function() {
	// Ẩn sửa môn
	$("#chon_cac_mon").hide();
	$("#title_chon_cac_mon").hide();
	// Ẩn bảng show cấu hình - môn học
	$("#show_cau_hinh_mon_hoc").hide();

	// Sau khi chọn cấu hình
	$("#chon_cau_hinh").on("change", function() {
		// Ẩn bảng show cấu hình - môn học
		$("#show_cau_hinh_mon_hoc").hide();
		// làm mới select cấu hình
		$("#chon_cac_mon").empty();
		$("#title_chon_cac_mon").show();
		// insert lại select 
		$("#chon_cac_mon").append(`
			<select id="pre-selected-options" multiple="multiple" class="cac_mon"></select>
		`);
		// lấy mã cấu hình
		var ma_cau_hinh = $(this).val();
		// Gửi lên server lọc về các môn có thể học
		$.ajax({
			url:"../database/filter_mon_hoc_da_chon.php",
			type: "GET",
			dataType: "json",
			data: {ma_cau_hinh: ma_cau_hinh},
			success: function(data_1) {
				var arr_cac_mon = data_1.cac_mon.split(',');
				$("#arr_cac_mon").attr("value", arr_cac_mon);
				$.ajax({
					url: "../database/get_ds_mon_hoc_json.php",
					dataType: "json",
					success: function(data_2) {
						// get arr cac mon
						var arr_cac_mon = $("#arr_cac_mon").val().split(',');
						$.each(data_2, function(index, item) {
							if (arr_cac_mon.includes(item.ma_mon_hoc)) {
								$(".cac_mon").append(`<option value="${item.ma_mon_hoc}" selected>${item.ma_mon_hoc} - ${item.ten_mon_tv}</option>`);
							} else {
							$(".cac_mon").append(`<option value="${item.ma_mon_hoc}">${item.ma_mon_hoc} - ${item.ten_mon_tv}</option>`);
							}		
						});
					}
				}).done(function() {
					$("#pre-selected-options").multiSelect();
				});
			}
		})
		// Hiển thị chọn môn
		$("#chon_cac_mon").show();
		$("#title_chon_cac_mon").show();
	});

	// Khi người dùng nhấn xác nhận
	$("#btn_chinh_sua_cau_hinh").on("click", function() {
		// Get cac mon
		var cac_mon = $(".cac_mon").val();
		// Get mã cấu hình
		var ma_cau_hinh = $("#chon_cau_hinh").val();
		console.log(ma_cau_hinh);
		// Xóa bảng cũ nếu có
		$("#show_cau_hinh_mon_hoc table tbody").empty();

		// Gửi lên server để thao tác
		$.ajax({
			url: "../database/modify_cau_hinh_mon_hoc.php",
			type: "GET",
			dataType: "json",
			data: {
				cac_mon: cac_mon,
				ma_cau_hinh: ma_cau_hinh
			},
			complete: function() {
				$.ajax({
					url: "../database/get_ds_cau_hinh_mon_hoc.php",
					type: "GET",
					dataType: "json",
					data: {ma_cau_hinh: ma_cau_hinh},
					success: function(data) {
						$("#show_cau_hinh_mon_hoc table tbody").append(`
							<td>${data.chip} - ${data.ram} - ${data.o_cung} - ${data.card_do_hoa} - ${data.man_hinh}</td>
							<td>${data.cac_mon_hoc}</td>
						`);
					}
				});
					$.toast({
		            heading: "Thành công",
		            position: {
		                right: 100,
		                top: 80
		            },
		            hideAfter: 5000,
		            text: "Cập nhập thành công",
		            showHideTransition: 'slide',
		            icon: "success"
	        	});
			}
		});
		// Hiển thị bảng cấu hình
		$("#show_cau_hinh_mon_hoc").show();	
	});
});