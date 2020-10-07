$(document).ready(function () {
    $("#xem_de_xuat").hide();
    $("#table_de_xuat").hide();
    $("#so_ngay_xem").on("change", function () {
        var so_ngay_xem = $("#so_ngay_xem").val();
        $("#table_de_xuat").hide();
        if (so_ngay_xem > 30) {
            $("#so_ngay_xem").val('30');
        }
        if (so_ngay_xem <= 0) {
            $("#so_ngay_xem").val('1');
        }
    });
    $("#ma_can_bo").on("change", function () {
        $("#ma_lop").empty();
        $("#ma_mon_hoc").empty();
        $("#table_de_xuat").hide();
    });
    $("#gio_day").on("change", function () {
        $("#table_de_xuat").hide();
        $("#table_de_xuat").hide();
    });
    $("#xep_tu_ngay").on("change", function () {
        $("#table_de_xuat").hide();
        $("#table_de_xuat").hide();
    });
    $("#ma_lop").on("change", function () {
        $("#ma_mon_hoc").empty();
        $("#table_de_xuat").hide();
    });
    $("#ma_mon_hoc").on("change", function () {
        $("#xem_de_xuat").show();
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
    $('#ma_lop').select2({
        language: "vi",
        placeholder: "Nhập Mã Lớp Để Tìm Kiếm",
        ajax: {
            url: "../database/get_danh_sach_lop_v2.php",
            dataType: 'json',
            data: function (params) {
                return {
                    search: params.term, // search term
                    ma_can_bo: $("#ma_can_bo").val()
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
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
            data: function (params) {
                return {
                    search: params.term, // search term
                    ma_can_bo: $("#ma_can_bo").val(),
                    ma_lop: $("#ma_lop").val()
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
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

    $("#xem_de_xuat").on("click", function () {
        var ma_can_bo = $('#ma_can_bo').val();
        var ma_lop = $('#ma_lop').val();
        var ma_mon_hoc = $('#ma_mon_hoc').val();
        var gio_day = $('#gio_day').val();
        var xep_tu_ngay = $('#xep_tu_ngay').val();
        var so_ngay_xem = $('#so_ngay_xem').val();
        $('#table_data').empty();
        $.ajax({
            url: "../database/de_xuat.php",
            type: "GET",
            dataType: "json",
            data: {
                ma_can_bo: ma_can_bo,
                ma_lop: ma_lop,
                ma_mon_hoc: ma_mon_hoc,
                gio_day: gio_day,
                xep_tu_ngay: xep_tu_ngay,
                so_ngay_xem: so_ngay_xem
            },
            success: function (data) {
                var col_ngay = '';
                var ngay_thu;
                var string;
                $.each(data, function (index, item) {
                    string = '';
                    ngay_thu = `Thứ ${item.thu} (${item.ngay})`;
                    if(col_ngay=='' || col_ngay!=ngay_thu){
                        col_ngay = ngay_thu;
                        string = `
                        <tr>
                            <td colspan='5' style='background:gray'>${col_ngay}</td>
                        </tr>
                        `;
                    }
                    string += `<tr id="demo">
                                <td class="gio_bat_dau">${item.gio_bat_dau}</td>
                                <td class="gio_ket_thuc">${item.gio_ket_thuc}</td>
                                <td><select class="form-control" class="ma_phong">
                                `;
                    $.each(item.phong_phu_hop, function (key, value) {
                        string += `<option value=${key}>${value}</option>`;
                    })
                    string += `</select>
                                </td>
                                <td class="a">
                                <textarea placeholder="Nhập Ghi Chú(Nếu có)"></textarea>
                                </td>
                                <td>
                                <button data-ngay='${item.ngay}' class="btn btn-success" type="button" class="them_day_bu">Thêm Dạy Bù</button>
                                </td>
                            </tr>`;
                    $("#table_data").append(string);
                })
                notification("success", "<b>Thành Công</b>", "Đã Lấy Đề Xuất Ngày Dạy Thành Công");
                $("#table_de_xuat").show();
            },
            error: function (data) {
                notification("error", "<b>Lưu Ý !</b>", data.responseJSON.text);
            }
        });

        });
    $("#table_data").on("click", "button", function (e) {
        e.stopPropagation();
        var row = $(this).closest("tr");
        var ngay = $(this).data("ngay");
        var gio_bat_dau = row.find(".gio_bat_dau").html();
        var gio_ket_thuc = row.find(".gio_ket_thuc").html();
        var ghi_chu = row.find('textarea').val();
        var ma_phong = row.find('select').val();
        var ma_mon_hoc = $('#ma_mon_hoc').val();
        var ma_lop = $('#ma_lop').val();
        var ma_can_bo = $('#ma_can_bo').val();
        $.ajax({
            url: '../database/them_lich_dot_xuat.php',
            type: 'GET',
            dataType: 'json',
            data: {
                ngay: ngay,
                gio_bat_dau: gio_bat_dau,
                gio_ket_thuc: gio_ket_thuc,
                ghi_chu: ghi_chu,
                ma_mon_hoc: ma_mon_hoc,
                ma_lop: ma_lop,
                ma_can_bo: ma_can_bo,
                ma_phong: ma_phong
            },
            cache: false,
            success: function (data) {
                $.each(data, function (key, value) {
                    notification("success", "<b>Thành Công</b>", value);
                    row.empty();
                })
            },
            error: function (data) {
                notification("error", "<b>Lưu Ý !</b>", data.responseJSON.text);
            }
        })
    });
});
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