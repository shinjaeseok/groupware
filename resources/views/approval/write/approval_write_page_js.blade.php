<script>
    function submitCheck() {

        if (!$("#approval_title").val()) {
            toastr["error"]('제목을 입력해주세요.');
            return false;
        }

        if (!$("#approval_writer_user").val()) {
            toastr["error"]('기안자를 입력해주세요.');
            return false;
        }

        if (!$("#approval_writer_user_department").val()) {
            toastr["error"]('기안부서를 입력해주세요.');
            return false;
        }

        if (!$("#approval_date").val()) {
            toastr["error"]('기안일을 입력해주세요.');
            return false;
        }

        if (!$(".approval_user_id").val()) {
            toastr["error"]('결재자를 선택해주세요.');
            return false;
        }

        if ($('#approval_contents').summernote('isEmpty') == true) {
            toastr["error"]('내용을 입력해주세요.');
            return false;
        }

        if ($(".approval_user_id").length < 1) {
            toastr["error"]('결재라인을 추가해주세요.');
            return false;
        }
    }

    function documentSetting(){
        $("#modal_1").modal('show');

    }

    function approvalSetting(){
        $("#modal_2").modal('show');
        tree_datatable();
        empty_text_switch();
    }

    function approvalComment(){
        $("#modal_3").modal('show');
    }

    $('#tree').jstree({
        'core' : {

            "themes" : {
                "dots" : false
            },
            'data' : {
                'url' : function (node) {
                    return node.id === '#' ?
                        '/api/approval_department_tree_root' :
                        '/api/approval_department_tree_children';
                },
                'data' : function (node) {
                    return { 'id' : node.id };
                }
            }
        }});

    $('#tree').on('activate_node.jstree', function (e, data) {
        if (data == undefined || data.node == undefined || data.node.id == undefined)
            return;

        $("#search_key").val("").trigger("change");
        $("#search_value").val("");

        tree_datatable(data.node.id);
    });

    $("#btn_search").on("click", function () {
        tree_datatable();
    });

    function tree_datatable(id) {

        let search_key  = $("#search_key").val();
        let search_value  = $("#search_value").val();

        $('#dataTables_1' ).DataTable().destroy();

        let oTable = $('#dataTables_1').DataTable({
            ajax: {
                type: "get",
                url: "/api/approval_department_user_list",
                data : {
                    'id' : id,
                    'search_key' : search_key,
                    'search_value' : search_value,
                },
                dataType: "json",
                cache: false,
                async: false,
                dataSrc: '',
            },

            language: dataTableOpt.language,
            dom: dataTableOpt.dom,
            lengthChange: false,
            info: false,
            pageLength: 5,
            order: [],
            paging: true,
            // todo:: 사원 목록 페이지네이션 or scrollY
            // scrollY:"150px",
            // scrollCollapse: true,
            // paging:false,

            createdRow: function (row, data, index) {
            },
            drawCallback: function(settings, json) { },
            columns: [
                { data: "attachment_path", className: "text-center", orderable: false,
                    render: function(data, type, row, meta) {
                        let html = `<div><img class="img-fluid" style="max-width: 50px;" src="${data}" alt=""></div>`;
                        return html;
                    }
                },
                { data: "department", className: "text-center" , orderable: false,},
                { data: "user_name", className: "text-center" , orderable: false,},
                { data: "position", className: "text-center" , orderable: false,},
                { data: "id", className: "text-center" , orderable: false,
                    render: function(data, type, row, meta) {
                        let html = `<button type='button' class='btn btn-default btn-sm btn_select' data-id='${row.id}' data-user_name='${row.user_name}'>선택</button>`;
                        return html;
                    }
                },
            ],

            buttons: []
        });
    }

    function empty_text_switch() {
        let length = $(".approval_user_id").length;

        if(length == 0) {
            $("#empty_text").show();
        } else {
            $("#empty_text").hide();
        }
    }

    $(document).on('click', '.btn_delete_row', function() {
        $(this).parents('tr').remove();
        empty_text_switch();
    })

    $(document).on("click", ".btn_select", function() {
        var id = $(this).data("id");
        var user_name = $(this).data("user_name");
        btn_select(id, user_name);
        empty_text_switch();
    });

    function btn_select(id, user_name) {
        let html = `
                    <tr>
                        <td>
                            <select form="modal_form_1" name="approval_type[]" class="input-group search_false_select_box">
                                <option value="전결">전결</option>
                                <option value="결재">결재</option>
                                <option value="합의">합의</option>
                            </select>
                        </td>
                        <td class="text-center">
                            <span >${user_name}</span>
                            <input type="hidden" name="approval_user_id[]" class="form-control approval_user_id" placeholder="결재자" autocomplete="off" value="${id}">
                        </td>
                        <td class="text-center"><a class="btn btn-danger btn-sm btn_delete_row">삭제</a></td>
                     </tr>
                `;

        $("#approval_user_list").append(html);

        $(".select_box").select2();

        $(".search_false_select_box").select2({
            minimumResultsForSearch : -1    // search false
        });
    }


    $(".attach_file").on("change", function (e) {
        let file_size = 0;
        if (e.target.files[0]) {
            file_size = e.target.files[0].size;

            if (file_size >= 5242880) {
                e.preventDefault();
                toastr["error"]('파일 사이즈가 5메가를 초과했습니다.');
                $(this).val('');
            }
        }
    });
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

        $('input[type="file"]').change(function(e){
            let fileName
            e.target.files[0] ? fileName = e.target.files[0].name : fileName = '';
            $(e.target).parent('div').find('label').html(fileName);
        });
    })
</script>
<script>
</script>
