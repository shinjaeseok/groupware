<script>
    // Ajax URL
    var url = "/main";
    var attendance_url = "/attendance";

    //기본정보 호출 및 근무시간 계산함수 실행
    function attendanceDoSearch() {
        $.ajax({
            type: "GET",
            url: attendance_url + "/work_time",
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function(result) {
            let work_start_time = result.data.work_start_time != '출근전' ? result.data.work_start_time : result.data.work_start_time.substr(0,5);
            let work_end_time = result.data.work_end_time != '퇴근전' ? result.data.work_end_time : result.data.work_end_time.substr(0,5);

            $("#work_start_time").text(work_start_time);
            $("#work_end_time").text(work_end_time);
            $("#work_time").text(result.data.work_time);
            $("#work_check_data").val('start');
            $(".work_check_text").text('출근하기');

            // 미퇴근시만 실행
            if(result.data.work_end_time == '퇴근전') {
                $("#work_check_data").val('end');
                $(".work_check_text").text('퇴근하기');
                exe();
            }
        });
    }

    // 출근시
    $("#btn_work_check").on("click", function() {
        let process_mode = '';

        if ($("#work_check_data").val() == 'start') {
            process_mode = 'start';
        } else {
            process_mode = 'end';
        }

        if (process_mode == 'end') {
            if (!confirm('퇴근처리 하시겠습니까?')){
                return false;
            }
        }

        $.ajax({
            type: "POST",
            url: attendance_url + "/work",
            data : {
                "process_mode" : process_mode
            },
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function(result) {
            if (result.status) {
                let message = '';
                if ($("#work_check_data").val() == 'start') {
                    message = '오늘도 힘찬하루 되세요!';
                } else {
                    message = '오늘도 고생하셨습니다.';
                }
                toastr["success"](message);
                attendanceDoSearch();
                doSearch();
            } else {
                toastr["error"](result.message,'오류');
            }
        });
    });

    // 출근시
    $("#work_start").on("click", function() {
        $.ajax({
            type: "POST",
            url: attendance_url + "/work",
            data : {
                "process_mode" : "start"
            },
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function(result) {
            if (result.status) {
                toastr["success"]('오늘도 힘찬하루 되세요!');
                attendanceDoSearch();
            } else {
                toastr["error"](result.message,'오류');
            }
        });
    });

    // 퇴근시
    $("#work_end").on("click", function() {
        $.ajax({
            type: "POST",
            url: attendance_url + "/work",
            data : {
                "process_mode" : "end"
            },
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function(result) {
            if (result.status) {
                toastr["success"]('오늘도 고생하셨습니다.');
                attendanceDoSearch();
                doSearch();
            } else {
                toastr["error"](result.message,'오류');
            }
        });
    });

    function exe(){
        setInterval(timeCalculate, 1000);
    }

    // 1초마다 1초 추가 시간 계산 함수
    function timeCalculate() {
        const work_time = $("#work_time").text();
        const work_end_time = $("#work_end_time").text();

        // 미퇴근시만 계산 실행
        if(work_end_time == '퇴근전') {
            var time = work_time.split(':');

            var second = (Number(time[2]) + 1) % 60;
            const second_upper = ((Number(time[2]) + 1)/60) >= 1 ? 1 : 0;
            var minute = (Number(time[1]) + second_upper) % 60;
            const minute_upper = ((Number(time[1]) + second_upper)/60) >= 1 ? 1 : 0;
            var hour = (Number(time[0]) + minute_upper) % 24;

            second = second.toString();
            minute = minute.toString();
            hour = hour.toString();

            const result = (hour[1] ? hour : "0" + hour[0]) + ":" + (minute[1] ? minute : "0" + minute[0]) + ":" + (second[1] ? second : "0" + second[0]);
            const result2 = (hour[1] ? hour : "" + hour[0]) + "시간 " + (minute[1] ? minute : "" + minute[0]) + "분";

            $("#work_time").text(result);
            $("#time_check").text('출근한지 ' + result2 + ' 지났습니다.');
        }
    }


    function doSearch() {
        $.ajax({
            type: "GET",
            url: attendance_url + "/chart",
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function(result) {

            let axis = {
                x: {
                    type: "category",
                    tick: {
                        // rotate: 75,
                        multiline: false
                    },

                },
                y : {
                    show: false,
                    tick: {
                        format: function (d) {
                            return chartValueChange(d);
                        }
                    }
                },
            };

            let types = {
            };

            dataChart.id("chart").setAxis(axis).setTypes(types).init(result.data);
        });
    }

    const dataChart = (function () {
        'use strict';

        let elementId = undefined;
        let typeData = undefined;
        let axisData = undefined;

        let module = {};

        function createData(data) {

            let columns = [];

            data.forEach((row) => {
                let tempRowRate = [];
                for (let k in row) {
                    if (k !== 'tab') {
                        tempRowRate.push(row[k]);
                    }
                }
                tempRowRate.unshift(row.tab);
                columns.push(tempRowRate);
            });

            return {
                json: data,
                type: "bar",
                types: typeData,
                empty: {
                    label: {
                        text: ""
                    }
                },
                keys: {
                    x: 'tab',
                    value: ['근무시간', '초과근무시간'],
                },
                labels: {
                    format: {
                    }
                },
                colors: {
                    '근무시간': '#94beff',
                    '초과근무시간': '#ff8e8e',
                },
                groups: [
                    ['근무시간', '초과근무시간']
                ],
                order: 'asc'
            }
        }

        module.init = function (d) {
            c3.generate({
                bindto: `#${elementId}`,
                data: createData(d),
                axis: axisData,
                type: 'bar',
                legend: {
                    show: true,
                    position: 'inset',
                    inset: {
                        anchor: 'top-right',
                        step: 1
                    }
                }
            });
            return this;
        };

        module.setAxis = function (axis){
            axisData = axis;
            return this;
        };

        module.setTypes = function (types){
            typeData = types
            return this;
        };

        module.id = function (id) {
            elementId = id;
            return this;
        };

        return module;
    }());

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        let target = $(e.target).attr("id") // activated tab

        let table_id = 1;
        let type = '';

        if (target == 'approval-tab-01') {
            table_id = 1;
            type = 'all';
        } else {
            table_id = 2;
            type = 'waiting';
        }

        doSearch2(table_id, type)
    });

    function doSearch2(table_id = 1, type = 'all') {
        let approvalListUrl = '';
        let hrefUrl = '';

        if (type == 'all') {
            approvalListUrl = "/approval/writeList";
        } else {
            approvalListUrl = "/approval/approvalList";
        }

        $("#approval_plus").attr("href", approvalListUrl);

        // 초기화
        $('#dataTables_' + table_id ).DataTable().destroy();

        let oTable = $('#dataTables_' + table_id).DataTable({
            createdRow: function (row, data, index) {
                $(row).find("td").addClass("text-center");
                $(row).addClass("cursor-pointer");
                $(row).find("td").eq(2).removeClass("text-center").addClass("text-left");
            },
            info: false,
            searching: false,
            pageLength: 5,
            ajax: {
                type: "GET",
                url: approvalListUrl + "/list/" + type,
                dataType: "json",
                cache: false,
                async: false,
                dataSrc: '',
            },
            columns: [
                // { data: "id" },
                { data: "approval_date" },
                // { data: "document_division" ,
                //     render: function(data, type, row, meta) {
                //         return data ? data : '기본';
                //     }},
                { data: "emergency_type" ,
                    render: function(data, type, row, meta) {
                        return data == 'Y' ? '<span class="badge badge-danger">긴급</span>' : '';
                    }
                },
                { data: "title", className: "text-left" ,
                    render: function(data, type, row, meta) {
                        return shortening(data);
                    }
                },
                // { data: "attach_file_status" ,
                //     render: function(data, type, row, meta) {
                //         return data == 'Y' ? '<i class="fa fa-file-o"></i>' : '';
                //     }
                // },
                { data: "document_no" },
                { data: "status",
                    render: function(data, type, row, meta) {
                        let style = '';
                        if (data == '진행') {
                            style = 'badge-overlay-warning';
                        } else if (data == '완료') {
                            style = 'badge-overlay-success';
                        } else {
                            style = 'badge-overlay-danger';
                        }

                        let html = `<span class="badge ${style}">${data}</span>`
                        return html;
                    }
                },
            ],

            buttons: [
            ]
        });
    }

    var chartValueChange = function(value) {
        var diff_hour   = Math.floor(value / (60 * 60));
        var diff_minute = Math.floor((value %3600) / 60);
        var diff_second = Math.floor(value % 60);
        return  ((diff_hour < 10) ? "0" + diff_hour+"시간" : diff_hour+"시간")+ ((diff_minute < 10) ? "0" + diff_minute+"분" : diff_minute+"분");

    }

    function todoList() {

        $.ajax({
            type: "GET",
            url: "/todoList/list",
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function(result) {

            $("#todo_list").empty();
            $("#todo_list_input").val('');

            if (result.status) {
                $.each(result.data, function(key, val) {
                    commentAdd(val.id, val.done_type, val.todo);
                });
            } else {
                // toastr["error"](result.message,'오류');
            }
        });
    }

    function commentAdd(id, doneType, inputText){

        let task = '';

        task = `<li>
                    <input type="checkbox" class="todo_check" value="${id}">
                    <span class="m-l-xs">${inputText}</span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false"></a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs" x-placement="bottom-start" style="position: absolute; top: 92px; left: 0px; will-change: top, left;">
                        <li><a class="dropdown-item" onclick="todoDelete(${id}, this)">삭제</a></li>
                    </ul>
                </li>
                `;
        // todo:: todo list 불러올때 checked, class add
        $("#todo_list").append(task);

        let todoIndex = $(".todo_check").length - 1;
        let todoEq = $(".todo_check").eq(todoIndex);

        if (doneType == 'on') {
            todoEq.prop("checked", true);
            todoEq.next().addClass('todo-completed');
        } else {
            todoEq.prop("checked", false);
            todoEq.next().remove('todo-completed');
        }
    }

    $("#todo_list_input").on("keyup",function(e){
        if(e.keyCode == 13){
            todoListSave();
        }
    })

    $("#btn_todo_list_save").on('click', function (e){
        todoListSave();
    })

    function todoListSave(){
        let inputText = $("#todo_list_input").val();

        if(!inputText) {
            toastr["error"]('내용을 입력해주세요.','오류');
            return false;
        }

        if ($(".todo_check").length > 9) {
            toastr["error"]('할일은 최대 10개까지 등록가능합니다.','오류');
            return false;
        }

        $.ajax({
            type: "POST",
            url: "/todoList/insert",
            data: {
                'todo' : inputText,
            },
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function(result) {
            if (result.status) {
                commentAdd(result.data.id, 'off', inputText);
                $("#todo_list_input").val("");
            } else {
                // toastr["error"](result.message,'오류');
            }
        });
    }

    $('#todo_list').on('click', '.todo_check', function(e) {
        let id = $(this).val();
        let checkType = '';

        if ($(this).is(":checked") == false) {
            checkType = 'off';
            $(this).next().removeClass('todo-completed');
        } else {
            checkType = 'on';
            $(this).next().addClass('todo-completed');
        }

        $.ajax({
            type: "POST",
            url: "/todoList/update",
            data: {
                'id' : id,
                'done_type' : checkType
            },
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function(result) {
            if (result.status) {
            } else {
                // toastr["error"](result.message,'오류');
            }
        });
    });

    function todoDelete(id, e) {

        $.ajax({
            type: "POST",
            url: "/todoList/delete",
            data: {
                'id' : id,
            },
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function(result) {
            if (result.status) {
                $(e).parent().parent().parent().remove();
            } else {
                // toastr["error"](result.message,'오류');
            }
        });

    }


    function doSearch3() {
        // 초기화
        var oTable = $("#dataTables_3").DataTable({
            createdRow: function (row, data, index) {
                $(row).find("td").addClass("text-center");
                $(row).addClass("cursor-pointer")
                $(row).find("td").eq(0).removeClass("text-center").addClass("text-left");
            },
            info: false,
            searching: false,
            paging: false,
            pageLength: 5,
            ajax: {
                type: "GET",
                url: "/setting/notice/list",
            },
            columns: [
                { data: "title" , render : function ( data, type, row, meta ) {
                        return shortening(data);
                    }},
                { data: "created_at" , render : function ( data, type, row, meta ) {
                        return data.substr(0, 10);
                    }},
            ],
            buttons: [
            ],
        });
    }

    // 초기화
    $(document).ready(function(){
        attendanceDoSearch();
        doSearch();
        doSearch2();
        doSearch3();
        todoList();
        //TODO::일차적으로 백단 처리 완료 disable 처리 필요?
    })
</script>
