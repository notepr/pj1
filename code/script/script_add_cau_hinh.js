$(document).ready(function() {
	$("#pre-selected-options").multiSelect();
	// Ẩn bảng khi chưa thêm
	$("#show_danh_sach_cau_hinh").hide();

	// Khi người dùng nhấn thêm
	$("#btn_them_cau_hinh").on("click", function() {
		// Lấy chip
		var chip = $("#chip").val();
		if (chip == "") {
			$.toast({
	            heading: "Thất bại",
	            position: {
	                right: 100,
	                top: 80
	            },
	            hideAfter: 5000,
	            text: "Bạn cần nhập chip",
	            showHideTransition: 'slide',
	            icon: "error"
	        });
	        return false;
		}
		// Lấy ram
		var ram = $("#ram").val();
		if (ram == "") {
			$.toast({
	            heading: "Thất bại",
	            position: {
	                right: 100,
	                top: 80
	            },
	            hideAfter: 5000,
	            text: "Bạn cần nhập ram",
	            showHideTransition: 'slide',
	            icon: "error"
	        });
	        return false;
		}
		// Lấy ổ cứng
		var o_cung = $("#o_cung").val();
		if (o_cung == "") {
			$.toast({
	            heading: "Thất bại",
	            position: {
	                right: 100,
	                top: 80
	            },
	            hideAfter: 5000,
	            text: "Bạn cần nhập ổ cứng",
	            showHideTransition: 'slide',
	            icon: "error"
	        });
	        return false;
		}
		// Lấy card đồ họa
		var card_do_hoa = $("#card_do_hoa").val();
		if (card_do_hoa == "") {
			$.toast({
	            heading: "Thất bại",
	            position: {
	                right: 100,
	                top: 80
	            },
	            hideAfter: 5000,
	            text: "Bạn cần nhập card đồ họa",
	            showHideTransition: 'slide',
	            icon: "error"
	        });
	        return false;
		}
		// Lấy màn hình
		var man_hinh = $("#man_hinh").val();
		if (man_hinh == "") {
			$.toast({
	            heading: "Thất bại",
	            position: {
	                right: 100,
	                top: 80
	            },
	            hideAfter: 5000,
	            text: "Bạn cần nhập màn hình",
	            showHideTransition: 'slide',
	            icon: "error"
	        });
	        return false;
		}
		// Lấy ds các môn
		var cac_mon = $(".cac_mon").val();
		if (cac_mon.length == 0) {
			$.toast({
	            heading: "Thất bại",
	            position: {
	                right: 100,
	                top: 80
	            },
	            hideAfter: 5000,
	            text: "Bạn cần chọn các môn có thể học",
	            showHideTransition: 'slide',
	            icon: "error"
	        });
	        return false;
		}
		
		// Gửi lên server 
		$.ajax({
			url: "../database/add_cau_hinh.php",
			type: "GET",
			dataType: "json",
			data: {
				chip: chip,
				ram: ram,
				o_cung: o_cung,
				card_do_hoa: card_do_hoa,
				man_hinh: man_hinh,
				cac_mon: cac_mon
			},
			complete: function() {
				$.ajax({
		            url: "../database/get_ds_cau_hinh.php",
		            dataType: "json",
		            success: function(data) {
		                $.each(data, function(index, item) {
		                    $("#show_danh_sach_cau_hinh table tbody").append(`
			                    <tr>
			                        <td>${item.chip}</td>
			                        <td>${item.ram}</td>
			                        <td>${item.o_cung}</td>
			                        <td>${item.card_do_hoa}</td>
			                        <td>${item.man_hinh}</td>
			                    </tr>
		                	`);
		                });
		            }
		        });
		        // Ẩn đi form
		        $("form").hide();
		        // Hiển thị ra bảng
		        $("#show_danh_sach_cau_hinh").show();

			    $.toast({
		            heading: "Thành công",
		            position: {
		                right: 100,
		                top: 80
		            },
		            hideAfter: 5000,
		            text: "Thêm cấu hình mới thành công",
		            showHideTransition: 'slide',
		            icon: "success"
		        });

			}
		});
	});
});