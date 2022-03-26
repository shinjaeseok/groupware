<script>
    $("#btn_search").on("click", function() {
        list();
    });

    function list() {

        // 초기화
        $('#dataTables_1' ).DataTable().destroy();

        let oTable = $('#dataTables_1').DataTable({
            ajax: {
                type: "get",
                url: "/api/approval_temp_list",
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
                        return data + ` <i class="" onclick="view_detail(${row.id})"></i>`;
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

        $('#dataTables_1').on( 'click', 'tbody > tr', function (e) {
            // 제목열을 클릭했을 경우
            var data = oTable.row(this).data();

            window.location = `/approval_temp_write/${data.id}` ;
        });
    }

</script>

<script type="text/javascript">
    $(document).ready(function(){

        list();
    })
</script>
