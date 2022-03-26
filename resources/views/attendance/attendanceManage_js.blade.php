<script>
    // Ajax URL
    var url = "/attendance";

    // view
    function doSearch() {
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
                url: url + "/list",
                data: {
                    process_mode : "page_manage"
                }
            },
            columns: [
                { data: "user_name" , class: ""},
                { data: "work_date" , class: ""},
                { data: "work_start_time" , class: ""},
                { data: "work_end_time" , class: ""},
                { data: "work_start_time_after" , class: ""},
                { data: "work_end_time_after" , class: ""},
                { data: "work_time" , class: ""},
                { data: "status" , class: ""},
                { data: "id" , render : function ( data, type, row, meta ) {
                        return `<button class="btn btn-xs btn-default btn_update" onclick="btn_edit('${data}')">상세보기</button>`;
                    }},
            ],
            buttons: [
            ],
        });
    }

    // 수정
    function btn_edit(id) {
        $.ajax({
            type: "GET",
            data: {
                "id": id
            },
            url: url + "/select",
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function(result) {
            $("#modal_input").modal("show");
            $("#modal_title").text("근태 수정요청");
            $("#btn_save").text("수정요청");

            $("#modal_work_date").val(result.data.work_date);
            $("#modal_user_name").val(result.data.user_name);

            $("#modal_work_start_time").val(result.data.work_start_time);
            $("#modal_work_end_time").val(result.data.work_end_time);
            $("#modal_work_start_time_after").val(result.data.work_start_time_after);
            $("#modal_work_end_time_after").val(result.data.work_end_time_after);
            $("#modal_reason").val(result.data.reason);
            $("#modal_answer").val(result.data.answer);

            $("#modal_id").val(result.data.id);
        });
    }

    // 저장
    $("#btn_save").click(function () {
        var id = $("#modal_id").val();
        var process_mode

        process_mode = "/update";

        // 입력 사항 체크
        var validation_array = {
            "modal_work_start_time_after" : "modal_work_start_time_after",
            "modal_work_end_time_after" : "modal_work_end_time_after",
        };

        for (var item in validation_array) {
            if (!$("#" + item).val()) {
                toastr["error"]($("#" + item).attr("placeholder") + "(을/를) 입력해 주세요.");
                return false;
                break;
            }
        }

        $.ajax({
            type: "POST",
            data: $("#form_modal").serialize(),
            url: url  + process_mode,
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function (result) {
            if (result.status) {
                toastr["success"](result.message,'성공');
                $("#modal_input").modal("hide");
                $("#dataTables_1").DataTable().ajax.reload();
            } else {
                toastr["error"](result.message);
            }
        });
    });

    $(document).ready(function(){
        doSearch();
    })
</script>
