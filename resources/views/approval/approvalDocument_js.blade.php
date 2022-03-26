<script>
    // Ajax URL
    var url = "/approval/document";

    function doSearch() {

        var oTable = $("#dataTables_1").DataTable({
            createdRow: function (row, data, index) {
                $(row).find("td").addClass("text-center");
                $(row).addClass("cursor-pointer")
            },
            ajax: {
                type: "GET",
                url: url + "/list",
            },
            columns: [
                { data: "id" , orderable: false},
                { data: "division" , orderable: false},
                { data: "title" , orderable: false},
                { data: "created_user_code" , orderable: false},
                { data: "created_at", orderable: false , render : function ( data, type, row, meta ) {
                        return data.substr(0, 10);
                    }},
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
                $("#modal_1").modal("hide");

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
            $("#modal_1").modal("show");
            $("#modal_title").text("문서 수정");
            $("#btn_save").text("수정");

            $("#modal_document_title").val(result.data.title);
            $("#modal_document_division").val(result.data.division).trigger("change");
            $(".summernote").summernote("code", result.data.contents); // 에디터 처리
            $("#modal_id").val(result.data.id);
        });
    }

    // 신규 등록 모달
    $("#btn_create").on("click", function() {
        // 내용 초기화
        emptyData();
        $("#btn_save").text("저장");
        $("#modal_title").text("문서 등록");
        $("#modal_1").modal("show");
    });

    // 저장
    $("#btn_save").click(function () {


        if (!$('#modal_document_title').val()) {
            toastr["error"]("제목을 입력해주세요.",'오류');
            return false;
        }

        if (!$('#modal_document_division').val()) {
            toastr["error"]("구분을 선택해주세요.",'오류');
            return false;
        }

        if (!$(".summernote").summernote("code")) {
            toastr["error"]("내용 입력란을 작성하세요.",'오류');
            return false;
        }

        $("#modal_document_contents").val( $(".summernote").summernote("code") ); // 에디터 처리

        var id = $("#modal_id").val();
        var process_mode

        if (id) { // 수정
            process_mode = "/update";
        } else { // 등록
            process_mode = "/insert";
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
                $("#modal_1").modal("hide");
                $("#dataTables_1").DataTable().ajax.reload();
            } else {
                toastr["error"](result.message,'오류');
            }
        });
    });

    // modal 초기화
    function emptyData(){
        $("#modal_id").val("");
        $("#modal_document_division").val("").trigger('change'); // select2 초기화
        $("#modal_document_title").val("");
        $(".summernote").summernote("code", ""); // 에디터 처리
    }

    $( document ).ready(function() {
        doSearch();

        $('#modal_document_division').select2();

        $('.summernote').summernote({
            lang: 'ko-KR', // default: 'en-US'
            tabsize: 2,
            height: 400,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['codeview', 'help']]
            ],
        });
    });
</script>
