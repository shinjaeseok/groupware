<script>
    // Ajax URL
    var url = "/calendar/calendar";
    // 캘린더 글로벌 변수
    var calendar = "";

    $("#btn_save").on("click", function() {
        create_modal();
    });

    $("#btn_delete").on("click", function() {
        delete_modal();
    });

    $("#btn_calendar").on("click", function() {
        $("#modal_input").modal("show");
        $("#start_date").val(hrDate());
        $("#end_date").val(hrDate());
        $("#all_day_check").prop('checked', true);
        $("#start_time").prop('disabled', true);
        $("#end_time").prop('disabled', true);
        $(".btn_delete").hide();
    });

    function create_modal() {

        var id = $("#id").val();

        // 데이터 가져오기
        var arg = JSON.parse($("#arg").val());

        // 생성일 때
        var process_mode = "/insert";
        var start = $("#start_date").val();
        var end = $("#end_date").val();
        var allDay = $("#all_day_check").is(':checked');

        if (allDay == false) {
            start = start+'T'+$('#start_time').val();
            end = end+'T'+$('#end_time').val();
        }

        // 수정일 때
        if (id) {
            process_mode = "/update";
        }

        $.ajax({
            type: "POST",
            url: url + process_mode,
            data: {
                process_mode: process_mode,
                id: id,
                type : $("#type").val(),
                kind : $("#kind").val(),
                kind_child: $("#kind_child").val(),
                title: $("#title").val(),
                contents: $("#contents").val(),
                start: start,
                end: end,
                allDay: allDay,
            },
            dataType: "json",
            cache: false,
            async: false,
        }).done(function(data) {

            if (data.status) {
                toastr["success"](data.message,'성공');
                // toastr["success"](data.message);
                $("#modal_input").modal("hide");

                calendar.refetchEvents();

            } else {
                toastr["error"](data.message,'오류');
            }
        });
    }

    function delete_modal() {

        var arg = JSON.parse($("#arg").val());

        $.ajax({
            type: "POST",
            data: {
                id: arg.event.id
            },
            url: url + "/delete",
            dataType: "json",
            cache: false,
            async: false,
        }).done(function(data) {
            if (data.status) {
                toastr["success"](data.message,'성공');
                $("#modal_input").modal("hide");
            } else {
                toastr["error"](data.message,'오류');
            }
            calendar.refetchEvents(); // 새로 불러오기
        });

    }

    //JSON stringify 문제 해결
    const getCircularReplacer = () => {
        const seen = new WeakSet();
        return (key, value) => {
            if (typeof value === "object" && value !== null) {
                if (seen.has(value)) {
                    return;
                }
                seen.add(value);
            }
            return value;
        };
    };

    $(function() {
        var calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {

            /* 옵션 */
            height: '1200px', // calendar 높이 설정/
            // expandRows: true, // 화면에 맞게 높이 재설정
            slotMinTime: '08:00', // Day 캘린더에서 시작 시간
            slotMaxTime: '20:00', // Day 캘린더에서 종료 시간
            headerToolbar: { // 해더에 표시할 툴바
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },

            buttonText:
                {
                    today: '오늘',
                    month: '월',
                    week: '주',
                    day: '일',
                    list: '목록'
                },

            initialView: 'dayGridMonth', // 초기 로드 될때 보이는 캘린더 화면(기본 설정: 달)
            // initialDate: '2021-10-15', // 초기 날짜 설정 (설정하지 않으면 오늘 날짜가 보인다.)
            // weekNumbers: true, // 주 표시
            navLinks: true, // 날짜를 선택하면 Day 캘린더나 Week 캘린더로 링크
            editable: true, // 수정 가능
            selectable: true, // 달력 일자 드래그 설정가능
            nowIndicator: true, // 현재 시간 마크
            dayMaxEvents: true, // 이벤트가 오버되면 높이 제한 (+ 몇 개식으로 표현)
            moreLinkClick: 'popover',

            locale: 'ko', // 한국어 설정
            timeZone: 'local', // 타임존 설정
            // eventTimeFormat: { hour: 'numeric', minute: '2-digit', timeZoneName: 'short' }, // 시간 표시 포맷
            themeSystem: 'bootstrap', // 테마
            selectMirror: true,
            // googleCalendarApiKey : "AIzaSyDcnW6WejpTOCffshGDDb4neIrXVUA1EAE",
            businessHours: {
                daysOfWeek: [1, 2, 3, 4, 5],
                startTime: '09:00',
                endTime: '18:00',
            },
            // eventLimit: true, // allow "more" link when too many events
            // eventOrder: ['order_position','strike','order_start','title'], // 이벤트 정렬 순서

            /* 이벤트 처리 */
            loading: function(bool) { // 로딩 표시
            //
            },
            dateClick: function(arg) { // 날짜 클릭
            //
            },
            select: function(arg) { // 드래그 선택 + 날짜 클릭

                calendarClick(arg);
            },
            eventClick: function(arg) { // 이벤트 클릭

                calendarEventClick(arg);
            },
            eventAdd: function(arg) { // 이벤트가 추가되면 발생하는 이벤트
            //
            },
            eventChange: function(arg) { // 이벤트가 수정되면 발생하는 이벤트
                calendarUpdate(arg); // 수정
            },
            eventRemove: function(arg) { // 이벤트가 삭제되면 발생하는 이벤트
            //
            },
            eventDidMount: function (arg) {
                $(".cs").each(function(index, item){
                    if ($('#'+item.id).is(':checked')) {
                        if (arg.event.extendedProps.fk_kind_child_id === $('#'+item.id).val()) {
                            arg.el.style.display = "block";
                        }
                    } else {
                        if (arg.event.extendedProps.fk_kind_child_id === $('#'+item.id).val()) {
                            arg.el.style.display = "none";
                        }
                    }
                });
            },

            /* 이벤트 가져오기 */
            eventSources:
            [
                {
                    url: url + "/list",
                    type: 'get',
                    dataType: 'json',
                    failure: function() {
                        // console.log('불러오기 오류');
                    },
                    color: '#3788D8',
                    textColor: '#ffffff'
                }
                // {
                //     googleCalendarId : "ko.south_korea#holiday@group.v.calendar.google.com",
                //     color : '#ff4040',
                //     textColor : '#FFFFFF'
                // }
            ],
        });

        calendar.render(); // 캘린더 랜더링

        var csx = document.querySelectorAll(".cs");
        csx.forEach(function (el) {
            el.addEventListener("change", function () {
                calendar.refetchEvents();
            });
        });
    });


    $(".check_all").on("click", function(){
        checkControl('check_all', 'check_all_com');
        checkControl('check_all', 'check_all_my');
        checkControl('check_all', 'my_calender');
        checkControl('check_all', 'com_calendar');
    });

    $(".check_all_com").on("click", function(){
        checkControl('check_all_com', 'com_calendar');
        allCheckControl('check_all', 'all');
    });

    $(".check_all_my").on("click", function(){
        checkControl('check_all_my', 'my_calender');
        allCheckControl('check_all', 'all');
    });

    function checkControl(parent, child) {
        $("."+child).each(function(){
            $(this).prop("checked", $("."+parent).prop("checked"));
            calendar.refetchEvents();
        });
    }

    $(".com_calendar").on("click", function(){
        allCheckControl('check_all_com', 'com_calendar');
        allCheckControl('check_all', 'all');
    });

    $(".my_calender").on("click", function(){
        allCheckControl('check_all_my', 'my_calender');
        allCheckControl('check_all', 'all');
    });

    function allCheckControl(parent, child) {
        let total = $("."+child).length;
        let checked = $("."+child+":checked").length;
        if (total != checked) $("."+parent).prop("checked", false);
        else $("."+parent).prop("checked", true);
    }

    function calendarClick(arg) {
        /*
        $(".fc-daygrid-event").attr("href" , "#"); // 구글 이동 금지
        $(".fc-list-event-title a").attr("href" , "#"); // 구글 이동 금지 // TODO :: 일정목록 클릭 처리 못하고 있음

        // 구글 모달 안 띄우기
        if (arg.event._def.url) {
            return false;
        }
        */
        //초기화

        $("#title").val("");
        $("#contents").val("");
        $("#kind").val("");
        $("#id").val('');
        $("#allDay").val('');
        $("#arg").val('');
        $("#type").val('');
        $("#kind_child").val('');
        $("#start_date").val(arg.startStr.substr(0,10));
        $("#end_date").val(arg.endStr.substr(0,10));

        // 모달 띄우기
        $("#modal_input").modal("show");
        $(".btn_delete").hide();

        // 데이터 전달
        $("#arg").val(JSON.stringify(arg, getCircularReplacer()));

        $("#all_day_check").prop('checked', true);
        $("#start_time").prop('disabled', true);
        $("#end_time").prop('disabled', true);

        //id 있으면 제목표시
        if (arg.event) {
            $("#id").val(arg.event.id);

            let start_date = arg.event.startStr.substr(0, 10);
            let end_date = arg.event.endStr.substr(0, 10);

            $("#start_date").val(start_date);
            $("#end_date").val(end_date);

            if(arg.event.startStr.length > 10){
                $('#start_time').val(arg.event.startStr.substr(11, 5));
                $('#end_time').val(arg.event.endStr.substr(11, 5));
            }

            $("#allDay").val(arg.event._def.allDay);

            if (arg.event._def.allDay == false) {
                $("#all_day_check").prop('checked', false);
                $("#start_time").prop('disabled', false);
                $("#end_time").prop('disabled', false);
            }

            $("#type").val(arg.event.extendedProps.type);
            $("#title").val(arg.event.title);
            $("#kind").val(arg.event.extendedProps.kind);
            $("#contents").val(arg.event.extendedProps.contents);
            kindChildList(arg.event.extendedProps.kind);
            $("#kind_child").val(arg.event.extendedProps.fk_kind_child_id);

            $(".btn_delete").show();
            $(".btn_save").show();

            if (arg.event.extendedProps.manager != true) {
                $(".btn_delete").hide();
                $(".btn_save").hide();

                if (arg.event.extendedProps.kind_type == 'system' && arg.event.extendedProps.kind == '사내캘린더') {
                    $(".btn_delete").hide();
                    $(".btn_save").hide();
                }

                if (arg.event.extendedProps.writer == '{{ Auth::user()->employee_code }}') {
                    $(".btn_delete").show();
                    $(".btn_save").show();
                }
            }
        }
    }

    function calendarEventClick(arg) {

        //초기화
        $("#title").val("");
        $("#contents").val("");
        $("#kind").val("");
        $("#id").val('');
        $("#allDay").val('');
        $("#arg").val('');
        $("#type").val('');
        $("#kind_child").val('');
        $("#start_date").val(arg.startStr);
        $("#end_date").val(arg.endStr);

        // 모달 띄우기
        $("#modal_input").modal("show");
        $(".btn_delete").hide();

        // 데이터 전달
        $("#arg").val(JSON.stringify(arg, getCircularReplacer()));

        $("#all_day_check").prop('checked', true);
        $("#start_time").prop('disabled', true);
        $("#end_time").prop('disabled', true);

        //id 있으면 제목표시
        if (arg.event) {
            $("#id").val(arg.event.id);

            let start_date = arg.event.startStr.substr(0, 10);
            let end_date = arg.event.endStr.substr(0, 10);

            $("#start_date").val(start_date);
            $("#end_date").val(end_date);

            if(arg.event.startStr.length > 10){
                $('#start_time').val(arg.event.startStr.substr(11, 5));
                $('#end_time').val(arg.event.endStr.substr(11, 5));
            }

            $("#allDay").val(arg.event._def.allDay);

            if (arg.event._def.allDay == false) {
                $("#all_day_check").prop('checked', false);
                $("#start_time").prop('disabled', false);
                $("#end_time").prop('disabled', false);
            }

            $("#type").val(arg.event.extendedProps.type);
            $("#title").val(arg.event.title);
            $("#kind").val(arg.event.extendedProps.kind);
            $("#contents").val(arg.event.extendedProps.contents);
            kindChildList(arg.event.extendedProps.kind);
            $("#kind_child").val(arg.event.extendedProps.fk_kind_child_id);

            $(".btn_delete").show();
            $(".btn_save").show();

            if (arg.event.extendedProps.manager != true) {
                $(".btn_delete").hide();
                $(".btn_save").hide();

                if (arg.event.extendedProps.kind_type == 'system' && arg.event.extendedProps.kind == '사내캘린더') {
                    $(".btn_delete").hide();
                    $(".btn_save").hide();
                }

                if (arg.event.extendedProps.writer == '{{ Auth::user()->employee_code }}') {
                    $(".btn_delete").show();
                    $(".btn_save").show();
                }
            }
        }

    }

    function calendarUpdate(arg) {

        $.ajax({
            type: "POST",
            data: {
                id: arg.event.id,
                type : arg.event.extendedProps.type,
                kind : arg.event.extendedProps.kind,
                kind_child: arg.event.extendedProps.fk_kind_child_id,
                title: arg.event.title,
                contents: arg.event.extendedProps.contents,
                start: arg.event.startStr,
                end: arg.event.endStr,
                allDay: arg.event.allDay,
            },
            url: url + "/update",
            dataType: "json",
            cache: false,
            async: false,
        }).done(function(data) {
            if (data.status) {
                toastr["success"](data.message,'성공');
                calendar.refetchEvents(); // 새로 불러오기
            } else {
                toastr["error"](data.message,'오류');
            }
        });
    }

    function allDayCheck() {
        if ($("#all_day_check").is(':checked')) {
            $("#start_time").prop('disabled', true);
            $("#end_time").prop('disabled', true);
        } else {
            $("#start_time").prop('disabled', false);
            $("#end_time").prop('disabled', false);
        }
    }

    $("#kind").on("change", function () {
        let type = $("#kind").val();
        kindChildList(type);
    });

    function kindChildList(type){
        if (!type) {
            var select = `<option value="">선택</option>`;
            $("#kind_child").html(select);
            return false;
        }

        let process_mode = '/childList';

        $.ajax({
            type: "GET",
            url: url + process_mode,
            data: {
                type:type,
            },
            dataType: "json",
            cache: false,
            async: false,
        }).done(function(result) {
            if (result.status) {
                var select = `<option value="">선택</option>`;

                $.each(result.data , function(index, item){
                    select += `<option value="${item.id}">${item.title}</option>`;
                });
                $("#kind_child").html(select);
                // toastr["success"](data.message);

            } else {
                toastr["error"](result.message);
            }
        });
    }

    function addCalender(type) {
        $("#modal_input_2").modal('show');
        $("#modal_cal_type").val(type);
        $("#modal_id_2").val('');
        $("#kind_title").val('');
        $("#kind_contents").val('');
        $("#pick_color").val('');
        $('.colorPickSelector').css('backgroundColor','#3498db');
    }

    function detailCalender(id) {
        $.ajax({
            type: "GET",
            data: {
                "id": id
            },
            url: url + "/calendarKindChildSelect",
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function(result) {
            $("#modal_input_2").modal("show");

            $("#modal_id_2").val(result.data.id);
            $("#kind_title").val(result.data.title);
            $("#kind_contents").val(result.data.content);
            $("#pick_color").val(result.data.color);
            $("#modal_cal_type").val(result.data.modal_cal_type);
            $('.colorPickSelector').css('backgroundColor',result.data.color);
        });
    }

    $("#btn_kind_add").on("click", function () {

        let process_mode = '/calendarKindChildInsert';
        let id = $("#modal_id_2").val();
        let kind_title = $("#kind_title").val();
        let kind_contents = $("#kind_contents").val();
        let pick_color = $("#pick_color").val();
        let modal_cal_type = $("#modal_cal_type").val();

        if (id) {
            process_mode = '/calendarKindChildUpdate';
        }

        $.ajax({
            type: "POST",
            data: {
                id:id,
                kind_title:kind_title,
                kind_contents:kind_contents,
                pick_color:pick_color,
                modal_cal_type:modal_cal_type,
            },
            url: url + process_mode,
            dataType: "json",
            cache: false,
            async: false,
        }).done(function(data) {
            if (data.status) {
                toastr["success"](data.message,'성공');
                location.reload();
            } else {
                toastr["error"](data.message,'오류');
            }
        });
    });

    $("#btn_kind_delete").on("click", function () {
        if (!confirm("캘린더를 삭제하면 등록되어 있는 일정도 같이 삭제됩니다. 삭제하시겠습니까?")) {
            return false;
        }

        let id = $("#modal_id_2").val();
        let process_mode = '/calendarKindChildDelete';

        $.ajax({
            type: "POST",
            data: {
                id:id,
            },
            url: url + process_mode,
            dataType: "json",
            cache: false,
            async: false,
        }).done(function(data) {
            if (data.status) {
                toastr["success"](data.message,'성공');
                location.reload();
            } else {
                toastr["error"](data.message,'오류');
            }
        });
    });

    $(".colorPickSelector").colorPick({
        'initialColor': '#3498db',
        'allowRecent': true,
        'recentMax': 5,
        'allowCustomColor': false,
        'palette': ["#1abc9c", "#16a085", "#2ecc71", "#27ae60", "#3498db", "#2980b9", "#9b59b6", "#8e44ad", "#34495e", "#2c3e50", "#f1c40f", "#f39c12", "#e67e22", "#d35400", "#e74c3c", "#c0392b", "#ecf0f1", "#bdc3c7", "#95a5a6", "#7f8c8d"],
        'onColorSelected': function() {
            this.element.css({'backgroundColor': this.color, 'color': this.color});
            $("#pick_color").val(this.color);
        }
    });

</script>

<script type="text/javascript">
    $(document).ready(function(){

        $(window).resize(function() {
            var windowWidth = $( window ).width();
            if(windowWidth <= 767) {
                $('.fc-dayGridMonth-button').trigger('click');
            }
        });

    })
</script>
