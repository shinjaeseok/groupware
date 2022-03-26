<script>

    // Ajax URL
    var url = "/approval/tempList";

    function doSearch() {

        let oTable = $('#dataTables_1').DataTable({
            createdRow: function (row, data, index) {
                $(row).find("td").addClass("text-center");
                $(row).addClass("cursor-pointer");
                $(row).find("td").eq(4).removeClass("text-center").addClass("text-left");
            },
            ajax: {
                type: "GET",
                url: url + "/list",
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
                        if (!data) {
                            data = '제목 없음';
                        }
                        return data + ` <i class="fa fa-external-link" style="cursor: pointer;" onclick="location.href='/approval/write_step2?id='+${row.id}"></i>`;
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
                        return `<span class="badge badge-light">${data}</span>`;
                    }
                },
                { data: "id", className: "text-left" ,
                    render: function(data, type, row, meta) {
                        return `<button class="btn btn-xs btn-danger" onclick="btnDelete('${data}')">삭제</button>`;
                    }
                },
            ],

            buttons: [
            ]
        });
    }

    function btnDelete(id) {
        if (!confirm("해당 내용을 삭제하시겠습니까?")) {
            return false;
        }

        $.ajax({
            type: "POST",
            data: {
                "id": id
            },
            url: "/approval/write/tempDelete",
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function (result) {
            if (result.status) {
                toastr["success"](result.message,'성공');
                $("#dataTables_1").DataTable().ajax.reload();
            } else {
                toastr["error"](result.message,'오류');
            }
        });
    }

    $( document ).ready(function() {
        doSearch();
    });

</script>
