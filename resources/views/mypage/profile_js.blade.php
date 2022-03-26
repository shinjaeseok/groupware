<script>
    $('#submit').on("click",function () {
        let url = "/mypage/profile/update"; // 수정
        // 첨부파일 처리
        var formData = new FormData( $("#modal_form_1")[0] );

        $.ajax({
            type: "post",
            data: formData,
            url: url,
            dataType: "json",
            processData: false, // 첨부파일 처리
            contentType: false, // 첨부파일 처리
        }).done(function(result) {
            if (result.status == true) {
                toastr.success(result.message);
            } else {
                toastr.error(result.message);
            }

            setTimeout(function(){
                location.reload();
            }, 800);

        });
    });

    $(document).ready(function () {

    });
</script>
