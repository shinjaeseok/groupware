<script>
    const approval_id = $('#id').val();

    // Ajax URL
    const url = "/approval/write";

    // confirm check
    function clickSubmit(){
        if(!confirm('저장하시겠습니까?')){
            return true;
        } else {
            return false;
        }
    }

    // 문서 정보 modal show
    $("#btn_approval_info").on("click", function () {

        $.ajax({
            type: "GET",
            data: {
                "id": approval_id
            },
            url: url + "/info/select",
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function(result) {
            $("#modal_1").modal("show");
            if (result.status) {
                $("#agreement_type").val(result.data.agreement_type).trigger("change");
                $("#send_type").val(result.data.send_type).trigger("change");
                $("#document_life").val(result.data.document_life).trigger("change");

                $("#emergency_type_1").attr("checked" , true);
                if (result.data.emergency_type == 'Y') {
                    $("#emergency_type_2").attr("checked" , true);
                }

                $("#modal_id").val(result.data.id);
            } else {
                toastr["error"](result.message,'오류');
            }
        });
    });

    // 문서 정보 modal save
    $("#btn_approval_info_modal_save").click(function () {

        var id = $("#modal_id").val();

        if (!id) {
            toastr["error"]('기안 번호를 확인해주세요.','오류');
            return false;
        }

        var process_mode = "/info/update";

        $.ajax({
            type: "POST",
            data: $("#form_modal").serialize(),
            url: url + process_mode,
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function (result) {
            if (result.status) {
                $("#modal_1").modal("hide");
                toastr["success"](result.message,'성공');
            } else {
                toastr["error"](result.message,'오류');
            }
        });
    });

    // 결재선 modal show
    $("#btn_approval_line").on("click", function () {

        $.ajax({
            type: "GET",
            data: {
                "id": approval_id
            },
            url: url + "/line/select",
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function(result) {
            $("#modal_2").modal("show");

            getTreeJson();
            treeDatatable();

            $("#approval_user_list").empty();

            if (result.status) {
                $.each(result.data, function(key, val) {
                    btnSelect(val.fk_user_id, val.user_name);
                    $('.row_add_select_box').eq(key).val(val.approval_type).trigger('change');
                });
            } else {
                // toastr["error"](result.message,'오류');
            }
            emptyTextSwitch();
        });
    });

    // 결재선 modal save
    $("#btn_approval_line_modal_save").click(function () {
        if(clickSubmit()) return;

        let length = $(".approval_user_id").length;

        if (length == 0) {
            toastr["error"]('결재선을 한명이상 선택해주세요.','오류');
            return false;
        }

        var process_mode = "/line/insert";

        $.ajax({
            type: "POST",
            data: $("#form_modal_2").serialize() + "&approval_id=" + approval_id,
            url: url + process_mode,
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function (result) {
            if (result.status) {
                $("#modal_2").modal("hide");
                toastr["success"](result.message,'성공');
            } else {
                toastr["error"](result.message,'오류');
            }
        });
    });

    // 의견 modal show
    function approvalComment() {

        $.ajax({
            type: "GET",
            data: {
                "id": approval_id
            },
            url: url + "/comment/select",
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
                // toastr["error"](result.message,'오류');
            }
        });
    }

    // 의견 modal save
    $("#btn_approval_comment_modal_save").click(function () {
        let comment = $("#comment").val();

        if (!comment) {
            toastr["error"]('의견을 작성해주세요.','오류');
            return false;
        }

        var process_mode = "/comment/insert";

        $.ajax({
            type: "POST",
            data: $("#form_modal_3").serialize() + "&approval_id=" + approval_id,
            url: url + process_mode,
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function (result) {
            if (result.status) {
                toastr["success"](result.message,'성공');
                approvalComment();
            } else {
                toastr["error"](result.message,'오류');
            }
        });
    });

    // 첨부파일 modal show
    $("#btn_approval_attachment").on("click", function () {
        $("#modal_4").modal("show");
    });

    // 첨부파일 modal show
    $("#btn_file_uploaded_list").on("click", function () {
        $("#file_upload_list").empty();
        $.ajax({
            type: "GET",
            data: {
                "approval_id": approval_id
            },
            url: url + "/attachFile/select",
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function(result) {
            $("#modal_5").modal("show");
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

    // 첨부파일 저장
    $("#btn_approval_attachment_modal_save").click(function () {
        var formData = new FormData( $("#form_modal_4")[0] );

        formData.append('approval_id', approval_id)

        $.ajax({
            type: "POST",
            data: formData,
            url: url + '/attachFile/insert',
            dataType: 'json',
            cache: false,
            async: false,
            processData: false, // 첨부파일 처리
            contentType: false, // 첨부파일 처리
        }).done(function (result) {
            if (result.status) {
                $("#modal_4").modal("hide");
                DeleteFileAll();
                toastr["success"](result.message,'성공');
            } else {
                toastr["error"](result.message,'오류');
            }
        });
    });

    // 기안 상신
    $("#btn_approval_save").click(function () {

        var process_mode = "/update";

        let validation_array = {
            "user_name" : "user_name",
            "department_name" : "department_name",
            "approval_date" : "approval_date",
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
            data: $("#form_main").serialize(),
            url: url + process_mode,
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function (result) {
            if (result.status) {
                toastr["success"](result.message,'성공');
                location.href = result.redirect_url;
            } else {
                toastr["error"](result.message,'오류');
            }
        })
    });

    // 기안 임시저장
    $("#btn_approval_temp_save").click(function () {

        var process_mode = "/tempUpdate";

        $.ajax({
            type: "POST",
            data: $("#form_main").serialize(),
            url: url + process_mode,
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function (result) {
            if (result.status) {
                toastr["success"](result.message,'성공');
                location.href = result.redirect_url;
            } else {
                toastr["error"](result.message,'오류');
            }
        })
    });

    // 조직도 Ajax
    function getTreeJson() {

        $.ajax({
            type: "get",
            url:'/approval/approvalDepartmentTree',
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function (result) {

            var company = new Array();
            // 데이터 받아옴
            $.each(result, function(idx, item){
                company[idx] = { id:item.id, parent:item.parent_id, text:item.name };
            });


            // 트리 생성
            $('#tree').jstree({
                core: {
                    data: company    //데이터 연결
                },
                types: {
                    'default': {
                        'icon': 'jstree-folder'
                    }
                },
                plugins: ['wholerow', 'types'],
            })
        });
    }

    // 조직도
    $('#tree').on('activate_node.jstree', function (e, data) {
        if (data == undefined || data.node == undefined || data.node.id == undefined)
            return;

        $("#search_key").val("").trigger("change");
        $("#search_value").val("");
        treeDatatable(data.node.id);
    });

    // 결재선 조직도 사원 검색
    $("#btn_search").on("click", function () {
        treeDatatable();
    });

    // 사원 목록
    function treeDatatable(id) {

        let search_key  = $("#search_key").val();
        let search_value  = $("#search_value").val();

        $('#dataTables_1' ).DataTable().destroy();

        var oTable = $("#dataTables_1").DataTable({
            createdRow: function (row, data, index) {
                $(row).find("td").addClass("text-center");
                $(row).addClass("cursor-pointer")
            },
            pageLength: 5,
            ajax: {
                type: "GET",
                url: "/approval/approvalDepartmentUserList",
                data : {
                    'id' : id,
                    'search_key' : search_key,
                    'search_value' : search_value,
                },
            },
            columns: [
                { data: "attachment_path", className: "text-center", orderable: false,
                    render: function(data, type, row, meta) {
                        let html = `<div><img class="img-fluid" style="max-width: 50px;" src="${data}" alt=""></div>`;
                        return html;
                    }
                },
                { data: "department_name", className: "text-center" , orderable: false,},
                { data: "name", className: "text-center" , orderable: false,},
                { data: "position_name", className: "text-center" , orderable: false,},
                { data: "id", className: "text-center" , orderable: false,
                    render: function(data, type, row, meta) {
                        let html = `<button type='button' class='btn btn-default btn-sm btn_select' data-id='${row.id}' data-user_name='${row.name}'>선택</button>`;
                        return html;
                    }
                },
            ],
            buttons: [
            ],
        });
    }

    // 결재선
    function emptyTextSwitch() {
        let length = $(".approval_user_id").length;

        if (length == 0) {
            $("#empty_text").show();
        } else {
            $("#empty_text").hide();
        }
    }

    // 결재선 row 삭제
    $(document).on('click', '.btn_delete_row', function() {
        $(this).parents('tr').remove();
        emptyTextSwitch();
    })

    // 결재선 row 선택
    $(document).on("click", ".btn_select", function() {
        var id = $(this).data("id");
        var user_name = $(this).data("user_name");
        btnSelect(id, user_name);
        emptyTextSwitch();
    });

    // 결재선 row 추가
    function btnSelect(id, user_name) {
        let html = `
                    <tr>
                        <td>
                            <select form="form_modal_2" name="approval_type[]" class="input-group row_add_select_box">
                                <option value="결재">결재</option>
                                <option value="합의">합의</option>
                                <option value="전결" disabled>전결</option>
                            </select>
                        </td>
                        <td class="text-center">
                            <span >${user_name}</span>
                            <input form="form_modal_2" type="hidden" name="approval_user_id[]" class="form-control approval_user_id" placeholder="결재자" autocomplete="off" value="${id}">
                        </td>
                        <td class="text-center"><a class="btn btn-danger btn-sm btn_delete_row">삭제</a></td>
                     </tr>
                `;

        $("#approval_user_list").append(html);

        $(".row_add_select_box").select2({
            minimumResultsForSearch : -1    // search false
        });
    }

    // 의견 추가
    function commentAdd(id, user_name, img, datetime, comment, permission) {
        let html = `<div class="feed-element comment_add">
                        <a href="#" class="float-left">
                            <img alt="image" class="rounded-circle" src="${img}">
                        </a>
                        <div class="media-body ">
                            <strong>${user_name}</strong><br>
                            <small class="text-muted">${datetime}</small>
                            <div class="well">${comment}</div>

                `;

        if (permission) {
            // todo:: 추후 수정기능 추가 예정
            html += `<div class="float-right">
                        <!--<button type="button" class="btn btn-xs btn-white">수정</button>-->
                        <button type="button" class="btn btn-xs btn-danger" onclick="commentDelete(${id})">삭제</button>
                    </div>
                </div>
            </div>
                    `;
        } else {
            html += `</div></div>`;
        }
        $("#comment_list").append(html);
    }

    // 의견 삭제
    function commentDelete(id) {
        $.ajax({
            type: "POST",
            data: {
                "id": id
            },
            url: url + "/comment/delete",
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function (result) {
            if (result.status) {
                toastr["success"](result.message,'성공');
                approvalComment();
            } else {
                toastr["error"](result.message,'오류');
            }
        });
    }

    function fileAdd(id, file_ori_name, file_size) {
        let file_size_change = sizeToString(file_size)
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
                            <div class="file-name text-center">
                                <button class="btn btn-danger btn-xs" type="button" onclick="fileDelete(${id}, this)">삭제</button>
                            </div>
                        </div>
                    </div>`;
        $("#file_upload_list").append(html);
    }

    function fileDelete(id, e) {
        var process_mode = '/attachFile/delete'

        $.ajax({
            type: "POST",
            data: { "id": id },
            url: url + process_mode,
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function (result) {
            if (result.status) {
                e.parentNode.parentNode.parentNode.remove();
                toastr["success"](result.message,'성공');
            } else {
                toastr["error"](result.message,'오류');
            }
        });
    }

    // mail 첨부파일 복사
    var ouploadFiles;
    var normalSize = 0;
    var normailCount = 0;
    var hugSize = 0;
    var success_cnt = 0;
    var failed_cnt = 0;
    var fileUploadComplete = false;
    var fileUploadSuccess;
    var fileUpCheck;
    var allFileSize = 0;
    var allSendFileSize = 0;
    var allSendProgress =  Elem("all_upload_progressbar");
    var allProgressPercent = Elem("all_upload_progress_percent");
    var file_upload_msg1 = "파일 업로드에 실패하였습니다.";
    var file_upload_msg2 = "일반첨부";
    var file_upload_msg3 = "대용량첨부";
    var file_upload_msg4 = "변경 불가";
    var file_upload_msg5 = "변경";
    var file_upload_msg6 = "전송대기";
    var file_upload_msg7 = "일반 파일 최대 첨부 용량을 초과하기에 선택된 파일의\n첨부 형태를 변경할 수 없습니다.\n기존에 첨부된 파일을 삭제 후 다시 변경 하시기 바랍니다.\n일반 파일의 최대 첨부 용량은 50MB 입니다.";
    var is_msie = false;

    var normalCount = 0;

    // 파일 업로드 핸들러
    function Html5FileUploadInit() {
        var fileupload = $("#attach_file");
        fileupload.on('change', FileSelectHandler);
    }

    // 파일 핸들러
    function FileSelectHandler(e) {

        var mFiles;
        if(e != null && e.target == undefined) {
            mFiles = e;
        }
        else if(e.target.files != null) {
            mFiles = e.target.files;
        }
        else if(e.originalEvent != null) {
            mFiles = e.originalEvent.dataTransfer.files;
        }

        if(mFiles == null) {
            return;
        }

        var Html = "";
        var totalsize = 0;
        var attmode = "";

        if(ouploadFiles == null) {

            normalSize = 0;
            normalCount = 0;
            hugSize = 0;

            Html = `<table id='uploadFileTable' class='table-sm w-100'>
                        <colgroup>
                            <col style="width: 30px;">
                            <col style="">
                            <col style="width: 100px;">
                        </colgroup>
                    `;

            ouploadFiles = [];

            for (var i=0; i < mFiles.length; i++){
                if(i < 50 && mFiles[i].size <= 2147483648 && totalsize <= 5368709120 && (mFiles[i].size + totalsize) <= 5368709120) {
                    totalsize = totalsize + mFiles[i].size;
                    ouploadFiles.push(mFiles[i]);
                    attmode = "N";
                    normalSize = normalSize + mFiles[i].size;
                    normalCount = normalCount + 1;
                    Html += MakeTableRowHtml(mFiles[i].name, mFiles[i].size, i, attmode, "N");
                }
            }

            if(totalsize > 0) {

                Elem("divFileTable").innerHTML = Html + "</table>";
                Elem("divFileArea").style.display = "";
                Elem("divDropArea").style.display = "none";
                Elem("btnDeleteFileAll").style.display = "";
                Elem("btnDeleteFile").style.display = "";

                allFileSize = totalsize;
            }
            else {
                ouploadFiles = null;
            }

        }
        else {

            for (var i=0; i < ouploadFiles.length; i++) {
                totalsize = totalsize + ouploadFiles[i].size;
            }

            for (var i=0; i < mFiles.length; i++){

                var overlap = false;

                for(var j=0; j < ouploadFiles.length; j++) {

                    if(mFiles[i].name == ouploadFiles[j].name && mFiles[i].type == ouploadFiles[j].type && mFiles[i].size == ouploadFiles[j].size) {
                        overlap = true;
                        break;
                    }
                }

                if(i < 50 && mFiles[i].size <= 2147483648 && totalsize <= 5368709120 && mFiles[i].size + totalsize <= 5368709120 && overlap == false) {

                    totalsize = totalsize + mFiles[i].size;

                    var ck = document.getElementsByName("chkDelete");
                    var cv = Number(ck[ouploadFiles.length - 1].value) + 1;

                    var uft = Elem("uploadFileTable");
                    var row = uft.insertRow(uft.rows.length);
                    var cell1 = row.insertCell(0);
                    cell1.className = "check text-center";
                    var cell2 = row.insertCell(1);
                    cell2.className = "";
                    var cell3 = row.insertCell(2);
                    cell3.className = "capacity text-center";

                    cell1.innerHTML = "<input type=checkbox name=chkDelete value=\"" + cv  + "\" class='no-margin-r'>";
                    var icon = iconCheck(mFiles[i].name);
                    cell2.innerHTML =  "<span class='icon " + icon +"'></span>" + mFiles[i].name;
                    cell3.innerHTML = "<span id='attsize" + cv +"' value='" + mFiles[i].size + "'>" + sizeToString(mFiles[i].size) + "</span>";

                    normalSize = normalSize + mFiles[i].size;
                    normalCount = normalCount + 1;
                    attmode = "N";
                    cell2.innerHTML =  "<span id='attmode" + cv + "' value='N' class='icon " + icon +"'></span>" + mFiles[i].name;


                    ouploadFiles.splice(ouploadFiles.length,1,mFiles[i]);

                }
            }
        }
        allFileSize = totalsize;

        Elem("html5normalSize").innerHTML = sizeToString(normalSize);
        Elem("html5normalCount").innerHTML = normalCount + " 개";
    }

    // 첨부파일 로우 추가
    function MakeTableRowHtml(fileName, fileSize, i, attmode, Htmltype){

        var Html = "";
        var icon = iconCheck(fileName);

        Html = "<tr>";
        Html += "<td class='check text-center'><input type='checkbox' name='chkDelete' value=\"" + i + "\" class='no-margin-r'> </td>";
        Html += "<td class='' style='max-width: 100px; text-overflow: ellipsis;overflow: hidden;'><span id='attmode" + i + "' value='N' class='icon " + icon +"'></span>" + fileName + "</td>";
        Html += "<td class='capacity text-center'><span id='attsize" + i +"' value='" + fileSize + "'>" + sizeToString(fileSize) + "</span></td>";
        Html += "</tr>";
        return Html;
    }

    // 아이콘 체크
    function iconCheck(fileName) {

        var extIndex = fileName.lastIndexOf(".");
        var extName = fileName.substring(extIndex + 1, fileName.length);
        extName = extName.toLowerCase();

        switch (extName) {
            case "hwp" :
                break;
            case "txt" :
                break;
            case "pdf" :
                break;
            case "xlsx" :
                break;
            case "xls" :
                extName = "xlsx";
                break;
            case "pptx" :
                break;
            case "jpg" :
                break;
            case "doc" :
                break;
            case "docx" :
                extName = "doc";
                break;
            case "zip" :
                break;
            default :
                extName = "etc";
                break;
        }
        return extName;
    }

    // 파일 용량 문자 변환
    function sizeToString(size) {

        var length;

        if(size == 0) {
            return size + " KB";
        }

        if (size < 12)
            length = size + " b";
        else if (size < 1024 * 1024)
            length = (size/1024).formatNumber(2,',','.') + " KB";
        else if (size < 1024 * 1024 * 1024)
            length = (size/(1024 * 1024)).formatNumber(2,',','.') + " MB";
        else
            length = (size / (1024 * 1024 * 1024)).formatNumber(2,',','.') + " GB";

        return length;
    }

    // 파일 전체 선택
    function DeleteAllChk(chk){
        var chkBoxes = document.getElementsByName("chkDelete");

        for (var i=0; i < chkBoxes.length; i++){

            chkBoxes[i].checked = chk.checked;
        }
    }

    // 파일 전체 삭제
    function DeleteFileAll() {

        if (!ouploadFiles) {
            return false;
        }

        Elem("divFileTable").innerHTML = "";
        Elem("divFileArea").style.display = "none";
        Elem("divDropArea").style.display = "";
        Elem("btnDeleteFileAll").style.display = "none";
        Elem("btnDeleteFile").style.display = "none";

        ouploadFiles.splice(0, ouploadFiles.length);
        normalSize = 0;
        normalCount = 0;
        hugSize = 0;
        allFileSize = 0;
        ouploadFiles = null;

        clearFileObject();
        Elem("html5normalSize").innerHTML = sizeToString(normalSize);
        Elem("html5normalCount").innerHTML = normalCount + " 개";
    }

    // 파일 삭제
    function DeleteFile() {
        var dchkbox = document.getElementsByName("chkDelete");
        if(dchkbox.length == 0) {

            Elem("divFileArea").style.display = "none";
            Elem("divDropArea").style.display = "";
            Elem("btnDeleteFileAll").style.display = "none";
            Elem("btnDeleteFile").style.display = "none";

            normalSize = 0;
            normalCount = 0;
            hugSize = 0;
            allFileSize = 0;
            ouploadFiles = null;

            Elem("html5normalSize").innerHTML = sizeToString(normalSize);
            Elem("html5normalCount").innerHTML = normalCount + " 개";
            return false;
        }

        for(var i=0; i < dchkbox.length; i++) {

            if(dchkbox[i].checked) {
                if(Elem("attmode" + dchkbox[i].value).getAttribute("value") == "N") {
                    normalSize = normalSize - (ouploadFiles[i].size);
                    normalCount = normalCount - 1;
                }
                else {
                    hugSize = hugSize - (ouploadFiles[i].size);
                }

                allFileSize = allFileSize - (ouploadFiles[i].size);

                Elem("uploadFileTable").deleteRow(i);
                ouploadFiles.splice(i,1);
                DeleteFile();
            }
        }

        clearFileObject();

        Elem("html5normalSize").innerHTML = sizeToString(normalSize);
        Elem("html5normalCount").innerHTML = normalCount + " 개";
    }

    function clearFileObject() {
        $("#attach_file").val("");
    }

    // ID 가져오기
    function Elem(id) {
        return document.getElementById(id);
    }

    // 용량 표기
    Number.prototype.formatNumber = function(decPlaces, thouSeparator, decSeparator) {
        var n = this,
            decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
            decSeparator = decSeparator == undefined ? "." : decSeparator,
            thouSeparator = thouSeparator == undefined ? "," : thouSeparator,
            sign = n < 0 ? "-" : "",
            i = parseInt(n = Math.abs(+n || 0).toFixed(decPlaces)) + "",
            j = (j = i.length) > 3 ? j % 3 : 0;
        return sign + (j ? i.substr(0, j) + thouSeparator : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thouSeparator) + (decPlaces ? decSeparator + Math.abs(n - i).toFixed(decPlaces).slice(2) : "");
    };


    $( document ).ready(function() {

        Html5FileUploadInit();

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

        $("#approval_user_list").sortable();
    });

</script>
