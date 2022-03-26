<script>

    $(".btn_row_insert").on("click", function() {
        set_approval_user_list();
    });

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

    function rowAdd(result) {
        var html = `
                    <tr>
                        <td style='text-align: center;'><span class='sort'></span></td>
                        <td>
                            <select form="modal_form_1" name='approval_type[]' class='input-group search_false_select_box'>
                                <option value="전결">전결</option>
                                <option value="결재">결재</option>
                                <option value="합의">합의</option>
                            </select>
                        </td>
                        <td>
                            <select form="modal_form_1" name='approval_user_id[]' class='input-group approval_user_id select_box'>
                                <option value="">선택</option>
                                ${result}
                            </select>
                        </td>
                        <td class="text-center"><a class="btn btn-danger btn-icon btn-sm mb-1 btn_delete_row"><i class="fa fa-trash-o"></i></a></td>
                     </tr>
                `;

        $("#sub_list").append(html);

        row_index();

        $(".select_box").select2();

        $(".search_false_select_box").select2({
            minimumResultsForSearch : -1    // search false
        });
    }

    function set_approval_user_list() {
        $.ajax({
            type: "get",
            url: "/approval_user_list",
            dataType: "json",
            cache: false,
            async: false,
        }).done(function(result) {
            // $(".approval_user_id").append(result);
            rowAdd(result)
        });
    }

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


    $('#temp_save').on("click",function () {

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

        if (!$("#approval_contents").val()) {
            toastr["error"]('내용을 입력해주세요.');
            return false;
        }

        if (!$(".approval_user_id").val()) {
            toastr["error"]('결재자를 선택해주세요.');
            return false;
        }

        if ($(".approval_user_id").length < 1) {
            toastr["error"]('결재라인을 추가해주세요.');
            return false;
        }

        // 첨부파일 처리
        var formData = new FormData( $("#modal_form_1")[0] );

        formData.append('type', 'temp_save')
        $.ajax({
            type: "post",
            data: formData,
            url: "/approval_temp_create",
            dataType: "json",
            processData: false, // 첨부파일 처리
            contentType: false, // 첨부파일 처리
        }).done(function(result) {
            if (result.status == true) {
                toastr.success(result.message);

                window.location = "/approval_write_temp_list";
            } else {
                toastr.error(result.message);
            }
        });
    });

    function modal_approval_line_reg() {
        $('#modal_1').modal('show');
    }

</script>

<script type="text/javascript">
    $(document).ready(function(){

        $(".select_box").select2();

        $( "#sub_list" ).sortable({
            update: function () {
                row_index();
            }
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

        $('input[type="file"]').change(function(e){
            let fileName
            e.target.files[0] ? fileName = e.target.files[0].name : fileName = '';
            $(e.target).parent('div').find('label').html(fileName);
        });

    })
</script>
