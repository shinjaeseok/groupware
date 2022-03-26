<script>
    // Ajax URL
    var url = "/sub";

    // view
    function doSearch() {
        // 초기화

        var oTable = $("#dataTables_1").DataTable({
            createdRow: function (row, data, index) {
                $(row).find("td").addClass("text-center");
                $(row).addClass("cursor-pointer")
                $(row).find("td").eq(3).removeClass("text-center").addClass("text-left");
            },
            ajax: {
                type: "GET",
                url: url + "/list",
            },
            columns: [
                { data: "id" },
                { data: "division" },
                { data: "title" },
                { data: "contents" },
                { data: "created_user_code" },
                { data: "created_at" , render : function ( data, type, row, meta ) {
                        return data.substr(0, 10);
                    }},
                { data: "id" , render : function ( data, type, row, meta ) {
                        return `<button class="btn btn-xs btn-default" onclick="btn_edit('${data}')">수정</button>
                                <button class="btn btn-xs btn-outline-danger" onclick="btn_delete('${data}')">삭제</button>`;
                    }},
            ],
            buttons: [
            ],
        });
    }

    // 삭제
    function btn_delete(id) {
        if (!confirm("해당 내용을 삭제하시겠습니까?")) {
            return false;
        }

        $.ajax({
            type: "POST",
            data: {
                "id": id
            },
            url: url + "/delete",
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function (result) {
            if (result.status) {
                toastr["success"](result.message,'성공');
                $("#modal_input").modal("hide");
                $("#dataTables_1").DataTable().ajax.reload();
            } else {
                toastr["error"](result.message,'오류');
            }
        });
    }

    // 수정
    function btn_edit(id) {
        $("#division").val("").trigger('change'); // select2 초기화

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
            $("#modal_title").text("모달 수정");
            $("#btn_save").text("수정");

            $("#division").val(result.data.division).trigger("change");
            $("#date").val(result.data.date);
            $("#title").val(result.data.title);
            $("#contents").val(result.data.contents);

            $("#modal_id").val(result.data.id);
        });
    }

    // 신규 등록 모달
    $("#btn_create").on("click", function() {
        // 내용 초기화
        emptyData();
        $("#btn_save").text("저장");
        $("#modal_title").text("모달 등록");
        $("#modal_input").modal("show");
    });

    // 저장
    $("#btn_save").click(function () {
        var id = $("#modal_id").val();
        var process_mode

        if (id) { // 수정
            process_mode = "/update";
        } else { // 등록
            process_mode = "/insert";
        }

        // 입력 사항 체크
        var validation_array = {
            "date" : "date",
            "title" : "title",
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
                toastr["error"](result.message,'오류');
            }
        });
    });

    // modal 초기화
    function emptyData(){
        $("#modal_id").val("");
        $("#division").val("").trigger('change'); // select2 초기화
        $("#date").val(hrDate());
        $("#title").val("");
        $("#contents").val("");
    }

    function hrDate($val) {
        var date = !$val ? new Date() : new Date($val);
        year = date.getFullYear().toString();
        month = (date.getMonth() + 1).toString();
        day = date.getDate().toString();
        newDate = year + "-" + (month[1] ? month : "0" + month[0]) + "-" + (day[1] ? day : "0" + day[0]);

        return newDate;
    }
</script>

<script type="text/javascript">
    // 초기화
    $(document).ready(function(){
        doSearch();

        $('#division').select2();
    })
</script>
