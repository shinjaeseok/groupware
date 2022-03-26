<script>
    // Ajax URL
    var url = "/setting/department";

    // view
    function doSearch() {
        // 초기화
        var oTable = $("#dataTables_1").DataTable({
            createdRow: function (row, data, index) {
                $(row).addClass("cursor-pointer")
            },
            searching: false,
            paging: false,
            info: false,
            ajax: {
                type: "GET",
                url: url + "/list",
            },
            columns: [
                { data: "name" , class: "text-left", orderable: false},
                { data: "id", orderable: false , render : function ( data, type, row, meta ) {
                        return `<button class="btn btn-xs btn-default btn_update" onclick="btn_edit('${data}')">수정</button>
                                <button class="btn btn-xs btn-outline-danger btn_delete" onclick="btn_delete('${data}')">삭제</button>
                                <button class="btn btn-xs btn-warning btn_sub" onclick="btn_sub('${data}')">하위부서추가</button>`;
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
                if(result.data) window.location.href = result.data;
            }
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
            if(result.status) {
                $("#modal_input").modal("show");
                $("#modal_title").text("부서 정보 수정");
                $("#btn_save").text("수정");

                $("#modal_name").val(result.data.name);
                $("#modal_sort").val(result.data.sort);
                $("#modal_status").val(result.data.status);

                $("#modal_id").val(result.data.id);
                $("#modal_parent_id").val(result.data.parent_id);
            } else {
                toastr["error"](result.message);
                if(result.data) window.location.href = result.data;
            }
        });
    }

    // 하위부서추가
    function btn_sub(id) {
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
            if (result.status) {
                $("#modal_input").modal("show");
                $("#modal_title").text("하위부서 추가");
                $("#btn_save").text("저장");
                emptyData();
                $("#modal_parent_id").val(result.data.id);
            } else {
                toastr["error"](result.message);
                if(result.data) window.location.href = result.data;
            }
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
            "modal_name" : "modal_name",
            "modal_status" : "modal_status",
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
                if(result.data) window.location.href = result.data;
            }
        });
    });

    // modal 초기화
    function emptyData(){
        $("#modal_id").val("");
        $("#modal_parent_id").val("");
        $("#modal_name").val("");
        $("#modal_sort").val("");
        $("#modal_status option:eq(0)").attr("selected", "selected");
    }

    $(document).ready(function(){
        doSearch();
    })
</script>
