<script>

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        let target = $(e.target).attr("id") // activated tab

        let table_id = 1;
        let type = '';

        if (target == 'approval-tab-01') {
            table_id = 1;
            type = 'all';
        } else if (target == 'approval-tab-02') {
            table_id = 2;
            type = 'Proceeding';
        } else if (target == 'approval-tab-03') {
            table_id = 3;
            type = 'approval';
        } else {
            table_id = 4;
            type = 'deny';
        }

        list(table_id, type)
    });

    function list(table_id = 1, type = 'all') {

        // 초기화
        $('#dataTables_' + table_id ).DataTable().destroy();

        let oTable = $('#dataTables_' + table_id).DataTable({
            ajax: {
                type: "get",
                url: "/api/approval_write_list/" + type,
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

            createdRow: function (row, data, index) { },
            drawCallback: function(settings, json) { },
            columns: [
                { data: "id", className: "text-center" },
                { data: "approval_date", className: "text-center" },
                { data: "fk_approval_document_id", className: "text-center" ,
                    render: function(data, type, row, meta) {
                        let html = data;
                        if(!data) {
                            html = `기본`
                        }
                        return html;
                    }},
                { data: "emergency_type", className: "text-center" ,
                    render: function(data, type, row, meta) {
                        let html = '';
                        if(data == 'Y') {
                            html = `<span class="badge badge-danger">긴급</span>`
                        }
                        return html;
                    }
                },
                { data: "title", className: "text-left" ,
                    render: function(data, type, row, meta) {
                        return data + ` <i class="feather icon-external-link" style="cursor: pointer;" onclick="view_detail(${row.id})"></i>`;
                    }
                },
                { data: "attach_file_status", className: "text-center" ,
                    render: function(data, type, row, meta) {
                        let html = '';
                        if(data == 'Y') {
                            html = `<i class="feather icon-file"></i>`
                        }
                        return html;
                    }
                },
                { data: "document_no", className: "text-center" },
                { data: "status", className: "text-center",
                    render: function(data, type, row, meta) {
                        let style = '';
                        if (data == '진행중') {
                            style = 'badge-success';
                        } else if (data == '완료') {
                            style = 'badge-overlay-dark"';
                        } else {
                            style = 'badge-overlay-warning';
                        }

                        let html = `<span class="badge ${style}">${data}</span>`
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

    function view_detail(row_id) {
        $('#modal_1').modal('show');

        // 결제라인 초기화
        $("#sub_list").empty();

        if (row_id) {
            $.ajax({
                type: "get",
                data: {
                    id: row_id
                },
                url: "/api/approval_write_detail",
                dataType: "json",
                cache: false,
                async: false,
            }).done(function(result) {

                $("#modal_id").val(result.id);

                // 기안 정보
                $("#modal_approval_title").val(result.title);
                $("#modal_approval_writer_user").val(result.user_name);
                $("#modal_approval_writer_user_department").val(result.department);
                $("#modal_approval_date").val(result.approval_date);
                $("#modal_fk_approval_document_id").val(result.fk_approval_document_id);

                result.emergency_type == 'Y' ? $("#modal_emergency_type").show() : $("#modal_emergency_type").hide();

                $("#modal_approval_document_id").val(result.fk_approval_document_id).trigger("change");
                $("#modal_agreement_type").val(result.agreement_type).trigger("change");

                $("#modal_contents_view").html( result.contents );

                // 결재라인 정보

                $.each(result.items, function(key, val) {
                    rowAdd();
                    $('.approval_type').eq(key).val(val.approval_type).trigger('change');
                    $('.approval_user_id').eq(key).val(val.fk_user_id).trigger('change');
                    $('.approval_type').eq(key).prop('disabled', true);
                    $('.approval_user_id').eq(key).prop('disabled', true);
                    $('.approval_result').eq(key).text(val.approval_result);
                });

                $("#attach_file_down *").remove();

                let tmp = '';
                $.each(result.attach_files, function(key, val) {
                    if (val) {
                        tmp = `<a href='/file_download/${val.id}' class="form-control mb-sm-1"><i class="fa fa-download mr-1"></i> ${val.file_ori_name}</a>`;
                    }
                    $("#attach_file_down").append(tmp);
                });

                if (result.attach_files.length == 0) {
                    tmp = `<a class="form-control mb-sm-1">없음</a>`;
                    $("#attach_file_down").append(tmp);
                }
            });
        }
    }


    $(document).on('click', '.btn_delete_row', function() {
        $(this).parents('tr').remove();
        row_index();
    })

    function row_index() {
        let length = $(".sort").length;

        for (let i = 0; i <= length; i++) {
            $(".sort").eq(i).text(i + 1);
        }
    }

    function rowAdd() {
        var html = `
                    <tr>
                        <td style='text-align: center;'><span class='sort'></span></td>
                        <td>
                            <select form="modal_form_1" name='approval_type[]' class='input-group approval_type select_box' required>
                                <option value="전결">전결</option>
                                <option value="결재">결재</option>
                                <option value="합의">합의</option>
                            </select>
                        </td>
                        <td>
                            <select form="modal_form_1" name='approval_user_id[]' class='input-group approval_user_id select_box' required>
                                <option value="">선택</option>
                            </select>
                        </td>
                        <td class="text-center approval_result" ></td>
                     </tr>
                `;

        $("#sub_list").append(html);

        row_index();

        approval_user_list();

        $(".select_box").select2({
            minimumResultsForSearch : -1    // search false
        });
    }

    function approval_user_list() {
        $.ajax({
            type: "get",
            url: "/api/approval_user_select_list",
            dataType: "json",
            cache: false,
            async: false,
        }).done(function(result) {
            $(".approval_user_id").append(result);
        });
    }

</script>

<script type="text/javascript">
    $(document).ready(function(){

        $("#btn_search").on("click", function() {
            list();
        });

        list();

        $("#modal_approval_document_id").select2();

        $(".select_box").select2({
            minimumResultsForSearch : -1    // search false
        });

        $('.summernote').summernote({
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ],
            height: 400,
        });

    })
</script>
