<script>

    // Ajax URL
    var url = "/approval/write";

    // 기안 양식 목록
    function doSearch() {

        var oTable = $("#dataTables_1").DataTable({
            createdRow: function (row, data, index) {
                $(row).find("td").addClass("text-center");
                $(row).addClass("cursor-pointer")
            },
            ajax: {
                type: "GET",
                url: "/approval/document/list",
            },
            columns: [
                { data: "id" , orderable: false},
                { data: "division" , orderable: false},
                { data: "title" , orderable: false},
                { data: "created_at", orderable: false , render : function ( data, type, row, meta ) {
                        return data.substr(0, 10);
                    }},
                { data: "id", orderable: false , render : function ( data, type, row, meta ) {
                        return `<button class="btn btn-xs btn-default" onclick="btn_select('${data}')">선택</button>`;
                }},
            ],
            buttons: [
            ],
        });
    }

    function btn_select(id){
        $.ajax({
            type: "GET",
            data: {
                "id": id
            },
            url: "/approval/document/select",
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function(result) {
            $('#id').val(result.data.id);
            $('#document_preview').html(result.data.contents);
        });
    }

    // 기안 양식 선택
    $("#btn_save").click(function () {

        let id = $('#id').val();

        if (!id) {
            toastr["error"]('기안 양식을 선택해주세요.','오류');
            return false;
        }

        $("#btn_save").attr('disabled', true);

        $.ajax({
            type: "POST",
            data: $("#form_main").serialize(),
            url: '/approval/write/insert',
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function (result) {
            if (result.status) {
                toastr["success"](result.message,'성공');
                location.href = result.redirect_url;
            } else {
                toastr["error"](result.message,'오류');
                $("#btn_save").attr('disabled', false);
            }
        });
    });

    $( document ).ready(function() {
        doSearch();
    });

</script>
