function quyen_lich() {
    var calendarEl = document.getElementById('calendar');
    var ma_mon_hoc = $('#ma_mon_hoc').val();
    var ma_lop = $('#ma_lop').val();
    $("#calendar").empty();
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: ['interaction', 'dayGrid', 'timeGrid', 'list'],
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        locale: 'vi',
        navLinks: true,

        // weekNumbers: true,
        // weekNumbersWithinDays: true,
        weekNumberCalculation: 'ISO',

        editable: true,
        eventLimit: true,
        displayEventTime: false,
        events: {
            url: '../database/lich_hoc.php',
            method: 'GET',
            extraParams: {
                ma_lop: ma_lop,
                ma_mon_hoc: ma_mon_hoc
            },
            failure: function() {
                notification("error", "<b>Lưu Ý !</b>", "Có Lỗi Hãy Liên Hệ Lại Với Kĩ Thuật");
            }
        }

    });

    calendar.render();
}
