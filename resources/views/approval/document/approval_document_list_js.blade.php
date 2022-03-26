<script>
    $("#btn_search").on("click", function() {
        list();
    });

    // 모달 수정
    $(document).on("click", ".btn_update", function() {
        let idx = $(this).data("idx");

        $("#modal_id").val( idx ); // 수정을 위한 번호 지정

        view_modal();
    });

    // 모달 저장
    $("#btn_create").on("click", function() {

        $("#modal_id").val("");

        view_modal();
    });

    function view_modal() {
        $('#modal_1').modal('show');

        let modal_id = $("#modal_id").val();

        $("#modal_title").val('');
        $("#modal_document_type").val('').trigger("change");
        $("#modal_contents").html('');
        $('.summernote').summernote('reset');

        if (modal_id) {
            $.ajax({
                type: "get",
                data: {
                    id: modal_id
                },
                url: "/api/approval_document/select",
                dataType: "json",
                cache: false,
                async: false,
            }).done(function(result) {
                $("#modal_id").val(result.data.id);
                $("#modal_title").val(result.data.title);
                $("#modal_document_type").val(result.data.document_type).trigger("change");
                $(".summernote").summernote("code", result.data.contents); // 에디터 처리
            });
        } else {

        }
    }

    function view_detail(id) {
        $('#modal_2').modal('show');

        $("#modal_title_view").val('');
        $("#modal_document_type_view").val('').trigger("change");
        $("#modal_contents_view").html('');

        if (id) {
            $.ajax({
                type: "get",
                data: {
                    id: id
                },
                url: "/api/approval_document/select",
                dataType: "json",
                cache: false,
                async: false,
            }).done(function(result) {
                $("#modal_title_view").val(result.data.title);
                $("#modal_document_type_view").val(result.data.document_type).trigger("change");
                $("#modal_contents_view").html(result.data.contents);
            });
        } else {

        }
    }

    function list() {

        // 초기화
        $('#dataTables_1' ).DataTable().destroy();

        let oTable = $('#dataTables_1').DataTable({
            ajax: {
                type: "get",
                url: "/api/approval_document_list",
                dataType: "json",
                cache: false,
                async: false,
                dataSrc: '',
            },

            language: dataTableOpt.language,
            dom: dataTableOpt.dom,
            lengthChange: false,
            info: false,
            order: [[ 0, "desc" ]],
            pageLength: 10,

            createdRow: function (row, data, index) {
            },
            drawCallback: function(settings, json) { },
            columns: [
                { data: "id", className: "text-center" },
                { data: "id", className: "text-center" },
                { data: "document_type", className: "text-center" },
                { data: "title", className: "text-center" ,
                    render: function(data, type, row, meta) {
                        return data + ` <i class="feather icon-external-link" style="cursor: pointer;" onclick="view_detail(${row.id})"></i>`;
                    }},
                { data: "id", className: "text-center" ,
                    render: function(data, type, row, meta) {
                            let html = `<button type='button' class='btn btn-outline-light btn-sm btn_update' data-idx='${data}'>수정</button>
                                            <button type='button' class='btn btn-outline-light  btn-sm btn_delete' data-idx='${data}'>삭제</button>`;
                            return html;
                    }
                },
            ],

            // dom: 't<"pull-left"i><"pull-center"p>',
            buttons: [
                {extend: 'excel', text: '엑셀 다운로드', title: '기안함 전체 목록',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {extend: 'print', text: '인쇄',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    },
                    customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');
                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                }
            ]
        });
    }


    // 모달 저장
    $("#form_modal").on("submit", function() {
        store_modal();
        return false;
    });

    // 모달 저장
    function store_modal() {

        var modal_id = $("#modal_id").val();
        var process_mode = "";

        if (modal_id) process_mode = "update"; // 수정 모드
        else process_mode = "store"; // 등록 모드

        // 첨부파일 처리
        var formData = new FormData( $("#form_modal")[0] );

        $.ajax({
            type: "post",
            data: formData,
            processData: false,
            contentType: false,
            url: "/api/approval_document/" + process_mode,
            dataType: "json",
            cache: false,
            async: false,
        }).done(function(data) {
            if (data.status) {
                list();
                toastr["success"](data.message);
                $("#modal_1").modal("hide");
            } else {
                toastr["error"](data.message);
            }
        });
    }

</script>

<script type="text/javascript">
    $(document).ready(function(){

        DecoupledEditor
            .create( document.querySelector( '.document-editor__editable' ), {
            } )
            .then( editor => {
                const toolbarContainer = document.querySelector( '.document-editor__toolbar' );

                toolbarContainer.appendChild( editor.ui.view.toolbar.element );

                window.editor = editor;
            } )
            .catch( err => {
                console.error( err );
            } );

        $(".select_box").select2({
            minimumResultsForSearch : -1    // search false
        });

        list();
    })
</script>
