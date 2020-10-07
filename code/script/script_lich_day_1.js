 $(document).ready(function () {
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
        $("#so_ngay_xem").on("change", function () {
            var so_ngay_xem = $("#so_ngay_xem").val();
            $("#calendar").empty();
            if (so_ngay_xem > 30) {
                $("#so_ngay_xem").val('30');
                notification("warning", "<b>Chú Ý!</b>", "Số Ngày Xem Phải Nhỏ Hơn Hoặc Bằng 30");
            }
            if (so_ngay_xem <= 0) {
                $("#so_ngay_xem").val('1');
                notification("warning", "<b>Chú Ý!</b>", "Số Ngày Xem Phải Lớn Hơn Hoặc Bằng 1");
            }
        });
        $("#xem_lich_day").hide();
        $('#ma_can_bo').on("change", function (e) {
            $("#calendar").empty();
            $("#xem_lich_day").show();
        });
        $('#xep_tu_ngay').on("change", function (e) {
            $("#calendar").empty();
        });
        $("#xem_lich_day").on("click", function () {
            var ma_can_bo = $('#ma_can_bo').val();
            var xep_tu_ngay = $('#xep_tu_ngay').val();
            var so_ngay_xem = $('#so_ngay_xem').val();
            $.ajax({
                url: "../database/lich_day.php",
                type: "GET",
                dataType: "json",
                data: {
                    ma_can_bo: ma_can_bo,
                    xep_tu_ngay: xep_tu_ngay,
                    so_ngay_xem: so_ngay_xem,
                    check: 'check'
                },
                success: function (data) {
                    // notification("warning", "<b>Chú Ý!</b>", "Đang Lấy Dữ Liệu Lịch Dạy");
                    quyen_lich();
                    notification("success", "<b>Thành Công</b>", "Hoàn Thành Lấy Dữ Liệu");
                },
                error: function (data) {
                    notification("error", "<b>Lưu Ý !</b>", data.responseJSON.text);
                }
            });
        });
        $('#ma_can_bo').select2({
            language: "vi",
            placeholder: "Nhập Tên Hoặc Email Để Tìm Kiếm",
            ajax: {
                url: "../database/get_danh_sach_can_bo_v2.php",
                dataType: 'json',
                data: function (params) {
                    return {
                        search: params.term // search term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
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
    });
