function quyen_lich() {
    var calendarEl = document.getElementById('calendar');
    var ma_can_bo = $('#ma_can_bo').val();
    var xep_tu_ngay = $('#xep_tu_ngay').val();
    var so_ngay_xem = $('#so_ngay_xem').val();
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
        navLinks: true, // can click day/week names to navigate views
        // weekNumbers: true,
        // weekNumbersWithinDays: true,
        weekNumberCalculation: 'ISO',
        editable: true,
        eventLimit: false, // allow "more" link when too many events
        displayEventTime: false,
        events: {
            url: '../database/lich_day.php',
            method: 'GET',
            extraParams: {
                ma_can_bo: ma_can_bo,
                xep_tu_ngay: xep_tu_ngay,
                so_ngay_xem: so_ngay_xem
            },
            failure: function () {
                alert('Có Lỗi Hãy Liên Hệ Lại Với Kĩ Thuật');
            }
        }
    });
    calendar.render();
}