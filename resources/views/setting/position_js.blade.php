<script>

    // Ajax URL
    var url = "/setting/position";

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
                { data: "position" , orderable: false},
                { data: "position_grade" , orderable: false},
                { data: "id", orderable: false , render : function ( data, type, row, meta ) {
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
                toastr["error"](result.message);
                if(result.data) window.location.location.href = result.data;
            }
        });
    }

    // 수정
    function btn_edit(id) {
        $.ajax({
            type: "get",
            data: {
                "id": id
            },
            url: url + "/select",
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function(result) {
            if (result.status) {
                $("#modal_input").modal("show");
                $("#modal_title").text("직책 수정");
                $("#btn_save").text("수정");

                $("#position").val(result.data.position);
                $("#position_grade").val(result.data.position_grade);

                $("#modal_id").val(result.data.id);
            } else {
                toastr["error"](result.message);
                if(result.data) window.location.location.href = result.data;
            }
        });
    }

    // 신규 등록 모달
    $("#btn_create").on("click", function() {
        // 내용 초기화
        emptyData();
        $("#btn_save").text("저장");
        $("#modal_title").text("직책 등록");
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

        var position = $("#position").val();
        var position_grade = $("#position_grade").val();

        // 입력 사항 체크
        var validation_array = {
            "position" : "position",
            "position_grade" : "position_grade",
        };

        for (var item in validation_array) {
            if (!$("#" + item).val()) {
                toastr["error"]( $("#" + item).attr("placeholder") + "(을/를) 입력해 주세요.");
                return false;
                break;
            }
        }

        $.ajax({
            type: "POST",
            data: $("#form_modal").serialize(),
            url: url + process_mode,
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
                if(result.data) window.location.location.href = result.data;
            }
        });
    });

    // modal 초기화
    function emptyData(){

        $("#modal_id").val("");
        $("#position").val("");
        $("#position_grade").val("");
    }

    $( document ).ready(function() {
        doSearch();
});

</script>

