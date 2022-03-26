<script>
    // Ajax URL
    var url = "/setting/notice";

    // view
    function doSearch() {
        // 초기화
        var oTable = $("#dataTables_1").DataTable({
            createdRow: function (row, data, index) {
                $(row).find("td").addClass("text-center");
                $(row).addClass("cursor-pointer")
                $(row).find("td").eq(1).removeClass("text-center").addClass("text-left");
            },
            ajax: {
                type: "GET",
                url: url + "/list",
            },
            columns: [
                { data: "id" },
                { data: "title" , render : function ( data, type, row, meta ) {
                        return data + ` <i class="fa fa-external-link" style="cursor: pointer;" onclick="btn_detail('${row.id}')"></i>`;
                    }},
                { data: "user_name" },
                { data: "created_at" , render : function ( data, type, row, meta ) {
                        return data.substr(0, 10);
                    }},
                // 관리자 권한 체크
                @if (Auth::user()->manager == 'Y')
                { data: "id" , render : function ( data, type, row, meta ) {
                        return `<button class="btn btn-xs btn-default waves-effect waves-themed btn_update" onclick="btn_edit('${data}')">수정</button>
                                <button class="btn btn-xs btn-outline-danger btn-3d employee_status btn_delete" onclick="btn_delete('${data}')">삭제</button>`;
                    }},
                @endif
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
                $("#dataTables_1").DataTable().ajax.reload();
            } else {
                toastr["error"](result.message);
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
            $("#modal_input").modal("show");
            $("#modal_title").text("공지사항 보기");
            $("#btn_save").text("수정");

            $("#modal_id").val(result.data.id);
            $("#title").val(result.data.title);
            $("#contents").summernote('code', result.data.contents);
        });
    }

    // 수정
    function btn_detail(id) {

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
            $("#modal_input_2").modal("show");
            $("#modal_title").text("공지사항 보기");
            $("#btn_save").text("수정");

            $("#modal_id_2").val(result.data.id);
            $("#view_user_name").val(result.data.user_name);
            $("#view_created_at").val(result.data.created_at);
            $("#view_title").val(result.data.title);
            $("#view_contents").html(result.data.contents);
        });
    }

    // 신규 등록 모달
    $("#btn_create").on("click", function() {
        // 내용 초기화
        emptyData();
        $("#btn_save").text("저장");
        $("#modal_title").text("공지사항 등록");
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

    // modal 초기화
    function emptyData(){
        $("#modal_id").val("");
        $("#title").val("");
        $("#contents").summernote('code', '');
    }

</script>

<script type="text/javascript">
    // 초기화
    $(document).ready(function(){
        doSearch();

        $('.summernote').summernote({
            lang: 'ko-KR', // default: 'en-US'
            tabsize: 2,
            height: 600,
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
    })
</script>
