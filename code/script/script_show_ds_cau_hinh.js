$(document).ready(function() {
	var pathFolder = "database";
	var pathFile = "get_ds_all_cau_hinh_mon_hoc.php";
	// Hiển thị ra bảng
	$.ajax({
		url: `../${pathFolder}/${pathFile}`,		
		dataType: "json",
		success: function(data) {
			$.each(data, function(index, item) {
				$("#show_ds_cau_hinh table tbody").append(`
					<tr>
						<td>${item.chip}</td>
						<td>${item.ram}</td>
						<td>${item.o_cung}</td>
						<td>${item.card_do_hoa}</td>
						<td>${item.man_hinh}</td>
						<td>${item.cac_mon_hoc}</td>
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
	            text: "Lấy danh sách cấu hình thành công",
	            showHideTransition: 'slide',
	            icon: "success"
	        });
		}
	});
});