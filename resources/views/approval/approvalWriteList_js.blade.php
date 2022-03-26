<script>

    // Ajax URL
    const approvalListUrl = "/approval/writeList";

    const approvalUrl = "/approval/write";

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

        doSearch(table_id, type)
    });


    function doSearch(table_id = 1, type = 'all') {

        // 초기화
        $('#dataTables_' + table_id ).DataTable().destroy();

        let oTable = $('#dataTables_' + table_id).DataTable({
            createdRow: function (row, data, index) {
                $(row).find("td").addClass("text-center");
                $(row).addClass("cursor-pointer");
                $(row).find("td").eq(4).removeClass("text-center").addClass("text-left");
            },
            ajax: {
                type: "GET",
                url: approvalListUrl + "/list/" + type,
                dataType: "json",
                cache: false,
                async: false,
                dataSrc: '',
            },
            columns: [
                { data: "id" },
                { data: "approval_date" },
                { data: "document_division" ,
                    render: function(data, type, row, meta) {
                        return data ? data : '기본';
                    }},
                { data: "emergency_type" ,
                    render: function(data, type, row, meta) {
                        return data == 'Y' ? '<span class="badge badge-danger">긴급</span>' : '';
                    }
                },
                { data: "title", className: "text-left" ,
                    render: function(data, type, row, meta) {
                        return data + ` <i class="fa fa-external-link" style="cursor: pointer;" onclick="view_detail(${row.id})"></i>`;
                    }
                },
                { data: "attach_file_status" ,
                    render: function(data, type, row, meta) {
                        return data == 'Y' ? '<i class="fa fa-file-o"></i>' : '';
                    }
                },
                { data: "document_no" },
                { data: "status",
                    render: function(data, type, row, meta) {
                        let style = '';
                        if (data == '진행') {
                            style = 'badge-overlay-warning';
                        } else if (data == '완료') {
                            style = 'badge-overlay-success';
                        } else {
                            style = 'badge-overlay-danger';
                        }

                        let html = `<span class="badge ${style}">${data}</span>`
                        return html;
                    }
                },
            ],

            buttons: [
            ]
        });
    }

    function view_detail(id) {
        $('#modal_main_id').val(id);

        $.ajax({
            type: "GET",
            data: {
                "id": id
            },
            url: approvalUrl + "/info/select",
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function(result) {
            $('#modal_main').modal('show');

            $("#document_no").val(result.data.document_no);
            $("#user_name").val(result.data.user_name);
            $("#department_name").val(result.data.department_name);
            $("#approval_date").val(result.data.approval_date);
            $("#title").val(result.data.title);
            $("#contents").html(result.data.contents);
        });
    }

    // 문서 정보 modal show
    $("#btn_approval_info").on("click", function () {
        let approval_id =  $('#modal_main_id').val();

        $.ajax({
            type: "GET",
            data: {
                "id": approval_id
            },
            url: approvalUrl + "/info/select",
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function(result) {
            $("#modal_1").modal("show");
            if (result.status) {
                $("#modal_document_no").val(result.data.document_no);
                $("#agreement_type").val(result.data.agreement_type).trigger("change");
                $("#send_type").val(result.data.send_type).trigger("change");
                $("#document_life").val(result.data.document_life).trigger("change");

                $("#emergency_type_1").attr("checked" , true);
                if (result.data.emergency_type == 'Y') {
                    $("#emergency_type_2").attr("checked" , true);
                }
            } else {
                toastr["error"](result.message,'오류');
            }
        });
    });

    // 결재선 modal show
    $("#btn_approval_line").on("click", function () {
        let approval_id =  $('#modal_main_id').val();

        $.ajax({
            type: "GET",
            data: {
                "id": approval_id
            },
            url: approvalUrl + "/line/select",
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function(result) {
            $("#modal_2").modal("show");

            $("#approval_user_list").empty();

            if (result.status) {
                $.each(result.data, function(key, val) {
                    btnSelect(val.fk_user_id, val.user_name, val.approval_result);
                    $('.row_add_select_box').eq(key).val(val.approval_type).trigger('change');
                });
            } else {
                // toastr["error"](result.message,'오류');
            }
        });
    });

    // 의견 modal show
    function approvalComment() {

        let approval_id =  $('#modal_main_id').val();

        $.ajax({
            type: "GET",
            data: {
                "id": approval_id
            },
            url: approvalUrl + "/comment/select",
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function(result) {
            $("#modal_3").modal("show");

            $("#comment_list").empty();
            $("#comment").val('');

            if (result.status) {
                $.each(result.data, function(key, val) {
                    commentAdd(val.id, val.user_name, val.attachment_path, val.created_at, val.comments, val.permission);
                });
            } else {

                let html = `<div class="text-center">등록된 의견이 없습니다.</div>`;

                $("#comment_list").append(html);
            }
        });
    }

    // 첨부파일 modal show
    $("#btn_approval_attachment").on("click", function () {
        let approval_id =  $('#modal_main_id').val();

        $("#file_upload_list").empty();
        $.ajax({
            type: "GET",
            data: {
                "approval_id": approval_id
            },
            url: approvalUrl + "/attachFile/select",
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function(result) {
            $("#modal_4").modal("show");
            if (result.status) {
                $.each(result.data, function(key, val) {
                    fileAdd(val.id, val.file_ori_name, val.file_size);
                });
            } else {
                let html = `<div class="text-center">등록된 파일이 없습니다.</div>`;
                $("#file_upload_list").append(html);
            }
        });
    });

    // 결재선 row 추가
    function btnSelect(id, user_name, status) {
        let html = `
                    <tr>
                        <td>
                            <select form="form_modal_2" name="approval_type[]" class="input-group row_add_select_box" disabled>
                                <option value="전결">전결</option>
                                <option value="결재">결재</option>
                                <option value="합의">합의</option>
                            </select>
                        </td>
                        <td class="text-center">
                            <span >${user_name}</span>
                            <input form="form_modal_2" type="hidden" name="approval_user_id[]" class="form-control approval_user_id" placeholder="결재자" autocomplete="off" value="${id}">
                        </td>
                `;

        if (status == '승인') {
            html += `<td class="text-center"><label class="label label-success">${status}</label></td></tr>`;
        } else if (status == '반려') {
            html += `<td class="text-center"><label class="label label-danger">${status}</label></td></tr>`;
        } else if (status == '대기') {
            html += `<td class="text-center"><label class="label label-warning">${status}</label></td></tr>`;
        }

        $("#approval_user_list").append(html);


        $(".row_add_select_box").select2({
            minimumResultsForSearch : -1    // search false
        });
    }

    // 의견 추가
    function commentAdd(id, user_name, img, datetime, comment) {
        let html = `<div class="feed-element comment_add">
                        <a href="#" class="float-left">
                            <img alt="image" class="rounded-circle" src="${img}">
                        </a>
                        <div class="media-body ">
                            <strong>${user_name}</strong><br>
                            <small class="text-muted">${datetime}</small>
                            <div class="well">${comment}</div>
                        </div>
                    </div>
                    `;

        $("#comment_list").append(html);
    }

    function fileAdd(id, file_ori_name, file_size) {
        let html = `<div class="file-box">
                        <div class="file">
                            <a href="/fileDownload/${id}">
                                <span class="corner"></span>
                                <div class="icon">
                                    <i class="fa fa-file"></i>
                                </div>
                                <div class="file-name" style="text-overflow: ellipsis;overflow: hidden;">
                                    ${file_ori_name}
                                </div>
                            </a>
                        </div>
                    </div>`;
        $("#file_upload_list").append(html);
    }

    $("#btn_approval_retrieve").on("click", function () {
        $('#modal_5').modal('show');
        $('#modal_id_5').val('approvalLineStateChangeRetrieve');
    });

    $("#btn_approval_password_check").on("click", function () {
        let password =  $('#password').val();
        if (!password) {
            toastr["error"]('올바른 비밀번호를 입력해주세요.','오류');
            return false;
        }

        let admitProcess =  $('#modal_id_5').val();
        if (!admitProcess) {
            toastr["error"]('process 정보가 없습니다.','오류');
            return false;
        }

        $.ajax({
            type: "POST",
            data: {
                'password' : password,
            },
            url: '/setting/profile/password_check',
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function (result) {
            if (result.status) {
                admit(admitProcess);
            } else {
                toastr["error"](result.message,'오류');
            }
        });
    });

    function admit(process) {
        let approval_id =  $('#modal_main_id').val();

        $.ajax({
            type: "POST",
            data: {
                'approval_id' : approval_id,
            },
            url: '/approval/' + process,
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function (result) {
            $('#modal_5').modal('hide');

            if (result.status) {
                toastr["success"](result.message,'성공');
                $('#modal_main').modal('hide');
                $('#modal_id_5').val('');
                $('#password').val('');

                if ($('#approval-tab-01').hasClass('active')) {
                    $("#dataTables_1").DataTable().ajax.reload();
                }
                if ($('#approval-tab-02').hasClass('active')) {
                    $("#dataTables_2").DataTable().ajax.reload();
                }
                if ($('#approval-tab-03').hasClass('active')) {
                    $("#dataTables_3").DataTable().ajax.reload();
                }
                if ($('#approval-tab-04').hasClass('active')) {
                    $("#dataTables_4").DataTable().ajax.reload();
                }
            } else {
                toastr["error"](result.message,'오류');
            }
        });
    }

    $( document ).ready(function() {
        doSearch();
    });

</script>
