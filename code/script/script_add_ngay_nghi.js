$(document).ready(function() {
	$("#pre-selected-options").multiSelect();

	// Khi người dùng chọn một giáo viên => remove cái chọn all

	$("#pre-selected-options").change(function() {
		if ($(this).val().includes('0') && $(this).val().length > 1) {
			$("#pre-selected-options").multiSelect("deselect", ['0']);
		} 
	});

	$(".default_value").on("click", function() {
		$("#pre-selected-options").multiSelect("deselect_all");
		$("#pre-selected-options").multiSelect("select", ['0']);
	});
})

