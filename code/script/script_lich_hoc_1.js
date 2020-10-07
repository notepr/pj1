$(document).ready(function() {
    function notification(icon, data1, data2) {
        $.toast({
            heading: data1,
            position: {
                right: 100,
                top: 80
            },
            hideAfter: 5000,
            text: data2,
            showHideTransition: 'slide',
            icon: icon
        })
    }
    $("#xem_lich_day").hide();
    $('#ma_can_bo').on("change", function(e) {
        $("#calendar").empty();
        $("#ma_lop").empty();
        $("#ma_mon_hoc").empty();
        $("#xem_lich_day").hide();
        var ma_can_bo = $('#ma_can_bo').val();
        $.ajax({
            url: "../database/get_danh_sach_lop_v2.php",
            type: "GET",
            dataType: "json",
            data: {
                ma_can_bo: ma_can_bo,
                check: 'check'
            },
            error: function(data) {
                notification("error", "<b>Lưu Ý !</b>", data.responseJSON.text);
            }
        });
    });
    $('#ma_lop').on("change", function(e) {
        $("#calendar").empty();
        $("#ma_mon_hoc").empty();
        $("#xem_lich_day").hide();
    });
    $('#ma_mon_hoc').on("change", function(e) {
        $("#calendar").empty();
        $("#xem_lich_day").show();
    });
    $('#ma_can_bo').select2({
        language: "vi",
        placeholder: "Nhập Tên Hoặc Email Để Tìm Kiếm",
        ajax: {
            url: "../database/get_danh_sach_can_bo_v2.php",
            dataType: 'json',
            data: function(params) {
                return {
                    search: params.term // search term
                };
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.data,
                            id: item.ma_can_bo
                        };
                    })
                };
            },
            cache: true
        }
    });
    $('#ma_lop').select2({
        language: "vi",
        placeholder: "Nhập Mã Lớp Để Tìm Kiếm",
        ajax: {
            url: "../database/get_danh_sach_lop_v2.php",
            dataType: 'json',
            data: function(params) {
                return {
                    search: params.term, // search term
                    ma_can_bo: $("#ma_can_bo").val()
                };
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.ma_lop,
                            id: item.ma_lop
                        };
                    })
                };
            },
            cache: true
        }
    });
    $('#ma_mon_hoc').select2({
        language: "vi",
        placeholder: "Nhập Mã Môn Để Tìm Kiếm",
        ajax: {
            url: "../database/get_danh_sach_mon_v2.php",
            dataType: 'json',
            data: function(params) {
                return {
                    search: params.term, // search term
                    ma_can_bo: $("#ma_can_bo").val(),
                    ma_lop: $("#ma_lop").val()
                };
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.ma_mon_hoc,
                            id: item.ma_mon_hoc
                        };
                    })
                };
            },
            cache: true
        }
    });
    $("#xem_lich_day").on("click", function() {
        var ma_mon_hoc = $('#ma_mon_hoc').val();
        var ma_lop = $('#ma_lop').val();
        $.ajax({
            url: "../database/lich_hoc.php",
            type: "GET",
            dataType: "json",
            data: {
                ma_mon_hoc: ma_mon_hoc,
                ma_lop: ma_lop,
                check: 'check'
            },
            success: function(data) {
                // notification("warning", "<b>Chú Ý!</b>", "Đang Lấy Dữ Liệu Lịch Học");
                quyen_lich();
                notification("success", "<b>Thành Công</b>", "Hoàn Thành Lấy Dữ Liệu");
            },
            error: function(data) {
                notification("error", "<b>Lưu Ý !</b>", data.responseJSON.text);
            }
        });
    });
});
