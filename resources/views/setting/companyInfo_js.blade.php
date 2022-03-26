<script>

    // Ajax URL
    var url = "/setting/companyInfo";

    // 저장
    $("#btn_save").click(function () {

        var id = $('#id').val();
        var process_mode

        if (id) { // 수정
            process_mode = "/update";
        } else { // 등록
            process_mode = "/insert";
        }

        // 첨부파일 처리
        var formData = new FormData( $("#form_main")[0] );

        $.ajax({
            type: "POST",
            data: formData,
            url: url + process_mode,
            dataType: 'json',
            cache: false,
            async: false,
            processData: false, // 첨부파일 처리
            contentType: false, // 첨부파일 처리
        }).done(function (result) {
            if (result.status) {
                toastr["success"](result.message,'성공');
                location.reload();
            } else {
                toastr["error"](result.message,'오류');
                if(result.data) window.location.href = result.data;
            }
        });
    });

    $("#attach_file").change(function(event) {
        readURL(this);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var filename = $("#attach_file").val();
            filename = filename.substring(filename.lastIndexOf('\\')+1);
            reader.onload = function(e) {
                $('#blah').attr('src', e.target.result);
                $('#blah').hide();
                $('#blah').fadeIn(500);
                $('.custom-file-label').text(filename);
                $('#img_delete_btn').show();
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            // fixme: 빈 이미지 표기

            $('#blah').attr('src', '/img/profile.png');
            $('.custom-file-label').text('파일을 선택해주세요.');
            $('#img_delete_btn').hide();
            $("#attach_file").val("");
        }

        $(".alert").removeClass("loading").hide();
    }

    $('#img_delete_btn').on("click", function () {

        var process_mode = '/fileDelete'
        var id = $('#id').val();

        $.ajax({
            type: "POST",
            data: { "id": id },
            url: url + process_mode,
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function (result) {
            if (result.status) {
                toastr["success"](result.message,'성공');
            } else {
                toastr["error"](result.message);
            }
            location.reload();
        });
    });

    $( document ).ready(function() {

    });

</script>
