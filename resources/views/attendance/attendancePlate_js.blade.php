<script>
    // Ajax URL
    var url = "/attendance";
    var global_department = new Array();

    // 부서정보 및 근태정보
    function doSearch() {
        $.ajax({
            type: "GET",
            url: url + "/info",
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function(result) {
            var html = "";
            var type = "";
            var i = 0;

            $.each(result.data, function(index, item) {
                if(type != index) {
                    type = index;
                    i = 0;
                }

                html += `
                    <div class="col-lg-4">
                        <div class="ibox">
                            <div class="ibox-content"><h5>${index}</h5>
                                <div class="ibox-content">`;
                $.each(item, function(index_sub, item_sub) {
                    if(item[index_sub]['user_name']) {
                        html +=
                                    `<div class="row" style="margin-bottom: 20px">
                                        <div class="col-8">
                                            <img alt="image" style="width: 150px; height: 150px; margin-left: auto; margin-right: auto; display: block; opacity: ${item_sub['opacity']}" class="rounded-circle" src="${item_sub['file_path']}">
                                        </div>
                                        <div class="col-4">
                                            <strong>${item_sub['user_name']}</strong>
                                        </div>
                                    </div>`;
                    } else {
                        if(!result.data[index][i+1]) {
                            html += `
                                    <div class="text-center">
                                        <strong>
                                            사원정보없음
                                        </strong>
                                    </div>
                            `;
                        }
                    }
                });
                    html +=
                                `</div>
                            </div>

                        </div>
                    </div>
                `;
                i++;
            });

            $("#content").html(html);

        });
    }

    $(document).ready(function(){
        doSearch();

        //TODO::인터벌 필요한가?
    })
</script>
