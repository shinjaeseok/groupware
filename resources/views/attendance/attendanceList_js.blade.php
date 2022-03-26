<script>
    // Ajax URL
    var url = "/attendance";

    // view
    function doSearch() {
        // 초기화
        $("#dataTables_1").DataTable().destroy();
        $("#dataTables_1").off("click");

        var oTable = $("#dataTables_1").DataTable({
            createdRow: function (row, data, index) {
                $(row).find("td").addClass("text-center");
                $(row).addClass("cursor-pointer")
            },
            ajax: {
                type: "GET",
                url: url + "/list",
                data: {
                    process_mode : "page_list"
                }
            },
            columns: [
                { data: "work_date" , class: "", orderable: false},
                { data: "user_name" , class: "", orderable: false},
                { data: "department_name" , class: "", orderable: false},
                { data: "position_name" , class: "", orderable: false},
                { data: "work_start_time" , class: "", orderable: false},
                { data: "work_end_time" , class: "", orderable: false},
                { data: "work_time" , class: "", orderable: false},
            ],
            buttons: [
            ],
        });
    }

    $(document).ready(function(){
        doSearch();
    })
</script>
