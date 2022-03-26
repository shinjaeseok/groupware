<script>
    // Ajax URL
    var url = "/attendance";

    // 날짜 조회
    $("#btn_search").on("click", function () {
        doSearch();
    });

    function doSearch() {

        let work_date = $("#work_date").val();

        // 초기화
        $("#dataTables_1").DataTable().destroy();
        $("#dataTables_1").off("click");

        var oTable = $("#dataTables_1").DataTable({
            createdRow: function (row, data, index) {
                $(row).find("td").addClass("text-center");
                $(row).addClass("cursor-pointer")
            },
            ajax: {
                type: "GET",
                url: url + "/day_list",
                data: {
                    work_date: work_date
                }
            },
            order: [[ 3, "desc" ]],
            columns: [
                { data: "name" , render : function ( data, type, row, meta ) {
                    return `<div class="row ml-1">
                                    <img class="rounded-circle img-md" src="${row.attachment_path}">
                                    <div class="ml-3">
                                        <h5>
                                            <span class="font-bold">${row.name}</span>
                                        </h5>
                                        <h5>
                                            <span class="font-normal">${row.position_name}</span>
                                        </h5>
                                    </div>
                                </div>`;
                    }},
                { data: "department_name" , class: "",},
                { data: "work_state" , render : function ( data, type, row, meta ) {
                        let state_style = 'btn-primary'
                        if (data == '퇴근') {
                            state_style = 'btn-warning';
                        } else if (data == '출근전' || data == '미출근'){
                            state_style = 'btn-light';
                        } else if (data == '미퇴근'){
                            state_style = 'btn-danger';
                        }
                        return `<span class="btn ${state_style} btn-rounded">${data}</span>`;
                    }},
                { data: "work_progress_bar" , render : function ( data, type, row, meta ) {
                        let progress_work_time = row.progress_work_time;
                        let hour = progress_work_time.substr(0,2);
                        let min = progress_work_time.substr(3,2);
                        let progress_style = hour < 9 ? 'progress-bar-success' : hour < 14 ? 'progress-bar-success-2' : 'progress-bar-warning';

                        return `
                                <div class="progress">
                                    <div class="progress-bar ${progress_style}" style="width: ${data}%" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span>${hour}시간 ${min}분</span><span style="color:grey"> /9시간</span>
                        `;
                    }},
                { data: "work_progress_pie" , render : function ( data, type, row, meta ) {
                        let pie_data = data >= 100 ? 100 : data <= 0 ? 0 : data;
                        let html = `<span class="pie">${pie_data}/100</span> ${data}%`;
                            $(".pie").peity("pie");
                        return html;
                    }},
                { data: "progress_work_start_time" , render : function ( data, type, row, meta ) {
                        if (data != '-') {
                            data = data.substr(0,5);
                        }
                        return data;
                    }},
                { data: "progress_work_end_time" , render : function ( data, type, row, meta ) {
                        if (data != '-') {
                            data = data.substr(0,5);
                        }
                        return data;
                    }},
                { data: "default_rest_time", render : function ( data, type, row, meta ) {
                        if (data != '-') {
                            data = data.substr(0,5);
                        }
                        return `<span class="text-info">${data}</span>`;
                    }},
                { data: "diff_over_time" , render : function ( data, type, row, meta ) {
                        if (data != '-') {
                            data = data.substr(0,5);
                        }
                        return `<span class="text-warning">${data}</span>`;
                    }},
            ],
            buttons: [
            ],
        });
    }

    $.fn.peity.defaults.pie = {
        delimiter: null,
        fill: ["#0051cb", "#e9ecef", "#ffd592"],
        radius: 8,
        height: 30,
        width: 30
    }

    $(document).ready(function(){
        doSearch();

    })
</script>
