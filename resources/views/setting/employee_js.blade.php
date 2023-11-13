l<script>
    // Ajax URL
    var url = "/setting/employee";

    // view
    function doSearch(table_id = 1, type = 'current') {
        // 초기화

        $('#dataTables_' + table_id ).DataTable().destroy();

        let oTable = $('#dataTables_' + table_id).DataTable({
            createdRow: function (row, data, index) {
                $(row).find("td").addClass("text-center");
                $(row).addClass("cursor-pointer")

            },
            ajax: {
                type: "GET",
                url: url + "/list/" + type,
            },
            columns: [
                {
                    data: "is_deleted", orderable: false,
                    render: function (data, type, row, meta) {

                        let selected = '';
                        let selected2 = '';
                        if (data == 'Y') {
                            selected = 'selected';
                        } else {
                            selected2 = 'selected';
                        }

                        return `<select class="form-control input-sm active_change" data-active='${data}' data-id='${row.idx}'>
                                            <option value="Y" ${selected}>재직</option>
                                            <option value="N" ${selected2}>퇴사</option>
                                    </select>`;
                    }
                },
                { data: "name" , orderable: false},
                { data: "phone" , orderable: false , render : function ( data, type, row, meta ) {
                        return data ? data : '미입력';
                    }},
                { data: "email" , orderable:  false , render : function ( data, type, row, meta ) {
                        return data ? data : '미입력';
                    }},
                { data: "department_name" , orderable: false,},
                { data: "position_name" , orderable: false},
                { data: "id", orderable: false , render : function ( data, type, row, meta ) {
                        return `<button class="btn btn-xs btn-default waves-effect waves-themed btn_update" onclick="btn_edit('${data}')">상세보기</button>`;
                    }},
            ],
            buttons: [
            ],
        });
    }

    // 삭제
    function btn_delete(id) {
        if (!confirm("해당 내용을 삭제하시겠습니까?")) {
            return false;
        }

        $.ajax({
            type: "POST",
            data: {
                "id": id
            },
            url: url + "/delete",
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function (result) {

            if (result.status) {
                toastr["success"](result.message,'성공');
                location.reload();
                // $("#modal_input").modal("hide");
                // $("#dataTables_1").DataTable().ajax.reload();
            } else {
                toastr["error"](result.message,'오류');
                if(result.data) window.location.location.href = result.data;
            }
        });
    }

    // 수정
    function btn_edit(id) {

        $.ajax({
            type: "GET",
            data: {
                "id": id
            },
            url: url + "/select",
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function(result) {
            if(result.status) {
                $("#modal_input").modal("show");
                $("#modal_title").text("사원 정보 수정");
                $("#btn_save").text("수정");
                $('#new_employee').empty();
                $('#password_request').empty();
                $('#password_request').prop('request' , false);
                $("#employee_code").val(result.data.employee_code).prop("readonly" , true);
                $("#password").val("");
                $("#name").val(result.data.name);
                $("#department_id").val(result.data.department_id);
                $("#position_id").val(result.data.position_id);
                $("#join_date").val(result.data.join_date);
                $("#leave_date").val(result.data.leave_date);
                $("#email").val(result.data.email);
                $("#phone").val(result.data.phone);
                $("#post").val(result.data.post);
                $("#address_1").val(result.data.address_1);
                $("#address_2").val(result.data.address_2);
                $("#is_deleted").val(result.data.is_deleted);

                $("#password_check").show();
                $("#left_bar_state").show();
                $("#left_bar_delete").show();
                // left menu data
                $("#left_bar_user_name").text(result.data.name);
                $("#left_bar_department_name").text(result.data.department_name);

                let state = '재직';
                let state_style = 'btn-success';

                if (result.data.is_deleted == 'Y') {
                    state = '퇴사';
                    state_style = 'btn-secondary';
                    $("#left_bar_state").removeClass('btn-success');
                }

                $("#left_bar_state").addClass(state_style).text(state);

                $("#modal_id").val(result.data.id);

                if (result.data.manager == "Y") {
                    $("#manager").prop("checked" , true);
                } else {
                    $("#manager").prop("checked" , false);
                }

                if (result.data.attachment) {
                    $("#profile_img").attr('src' , result.data.attachment);
                } else {
                    $("#profile_img").attr('src' ,'/img/profile.png');
                }


            } else {
                toastr["error"](result.message,'오류');
                if(result.data) window.location.location.href = result.data;
            }
        });
    }

    // 신규 등록 모달
    $("#btn_create").on("click", function() {
        // 내용 초기화
        emptyData();
        $("#btn_save").text("저장");
        $("#modal_title").text("사원등록");
        $("#modal_input").modal("show");
        //기본 사진 이미지
        $("#profile_img").attr('src' ,'/img/profile.png');
        //초기화
        $('#new_employee').empty();
        $('#password_request').empty();
        $('#password_request').prop('request' , false);
        $("#password_check").hide();
        $("#left_bar_state").hide();
        $("#left_bar_delete").hide();
        //신규등록시만 필수사항 표시
        var html = '<label class="form-label text-navy">※ 사진은 개인정보에서 본인이 등록 가능합니다</label>';
        $('#new_employee').append(html);
        var span = '<span class="badge badge-overlay-danger ml-2">필수</span>';
        $('#password_request').append(span);
        $('#password_request').prop('request' , 'true');
    });

    // 저장
    $("#btn_save").click(function () {
        var id = $("#modal_id").val();
        var process_mode

        if (id) { // 수정
            // $("#employee_code").html("disabled");
            process_mode = "/update";

            // 입력사항 체크
            var validation_array = {
                "employee_code" : "employee_code",
                "name" : "name",
                "department_id" : "department_id",
                "position_id" : "position_id",
                "join_date" : "join_date",
        };
        } else { // 등록
            process_mode = "/insert";

            // 입력사항 체크
            var validation_array = {
                "employee_code" : "employee_code",
                "password" : "password",
                "name" : "name",
                "department_id" : "department_id",
                "position_id" : "position_id",
                "join_date" : "join_date",
        };
        }


        for (var item in validation_array) {
            if (!$("#" + item).val()) {
                toastr["error"]($("#" + item).attr("placeholder") + "(을/를) 입력해 주세요.");
                return false;
                break;
            }
        }

        $.ajax({
            type: "POST",
            data: $("#form_modal").serialize(),
            url: url  + process_mode,
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function (result) {
            if (result.status) {
                toastr["success"](result.message,'성공');
                location.reload();
                // $("#modal_input").modal("hide");
                // $("#dataTables_1").DataTable().ajax.reload();
            } else {
                toastr["error"](result.message,'오류');
                if(result.data) window.location.location.href = result.data;
            }
        });
    });

    // modal 초기화
    function emptyData(){
        $("#modal_id").val("");
        $("#profile_img").attr('src' ,'');
        $("#employee_code").val("").prop("readonly" , false);
        $("#password").val("");
        $("#name").val("");
        $("#department_id").val("");
        $("#position_id").val("");
        $("#manager").prop("checked" , false);
        $("#join_date").val("");
        $("#leave_date").val("");
        $("#post").val("");
        $("#address_1").val("");
        $("#address_2").val("");
        $("#phone").val("");
        $("#email").val("");
        $("#left_bar_user_name").text('');
        $("#left_bar_department_name").text('');
        $("#left_bar_state").removeClass('btn-secondary');
        $("#left_bar_state").addClass('btn-success').text('신규등록');
    }

    function hrDate($val) {
        var date = !$val ? new Date() : new Date($val);
        year = date.getFullYear().toString();
        month = (date.getMonth() + 1).toString();
        day = date.getDate().toString();
        newDate = year + "-" + (month[1] ? month : "0" + month[0]) + "-" + (day[1] ? day : "0" + day[0]);

        return newDate;
    }

    function department_list() {
        $.ajax({
            type: "get",
            url: "/setting/department/list",
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function (result) {
            if (result.status) {
                var select = `<option value="">선택</option>`;
                $.each(result.data , function(index, item){
                    select += `<option value="${item.id}">${item.name}</option>`;
                });
                $("#department_id").html(select);
            } else {
                toastr["error"](result.message,'오류');
                if(result.data) window.location.location.href = result.data;
            }
        });
    }

    function position_list() {
        $.ajax({
            type: "get",
            url: "/setting/position/list",
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function (result) {
            if (result.status) {
                var select = `<option value="">선택</option>`;
                $.each(result.data , function(index, item){
                    select += `<option value="${item.id}">${item.position}</option>`;
                });
                $("#position_id").html(select);
            } else {
                toastr["error"](result.message,'오류');
                if(result.data) window.location.location.href = result.data;
            }
        });
    }

    // function changeState(id, state, thiz) {
    //     thiz.parentElement.classList.remove('show');
    //     let mainBtn = thiz.parentElement.previousElementSibling;
    //     if(mainBtn.getAttribute('data-state') === state){
    //         return false;
    //     }
    //
    //     $.ajax({
    //         type: "POST",
    //         data: {
    //             id:id,
    //             state:state,
    //         },
    //         url: url + "/delete",
    //         dataType: 'json',
    //         cache: false,
    //         async: false,
    //     }).done(function (result) {
    //         if (result.status) {
    //             toastr["success"](result.message,'성공');
    //             doSearch();
    //         } else {
    //             toastr["error"](result.message,'오류');
    //         }
    //     });
    // }


    $(document).on("change", ".active_change", function() {
        let id = $(this).data("id");
        let state = $(this).val();

        $.ajax({
            type: "POST",
            data: {
                id:id,
                state:state,
            },
            url: url + "/delete",
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function(result) {
            if (result.status) {
                toastr["success"](result.message);
            } else {
                toastr["error"](result.message);
            }
        });
    });

    $('#password_check').on("click", function (){
        $('#modal_2').modal("show");
        $('#password').val('');
    })

    $("#btn_modal_password_save").click(function () {

        var process_mode = "/password_change";

        $.ajax({
            type: "POST",
            data: $("#form_modal").serialize(),
            url: "/setting/profile" + process_mode,
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function (result) {
            if (result.status) {
                toastr["success"](result.message,'성공');
                $('#modal_2').modal("hide");
            } else {
                toastr["error"](result.message,'오류');
            }
        });
    });

</script>
<script>
    // 우편번호 찾기 화면을 넣을 element
    var element_layer = document.getElementById('layer');

    function closeDaumPostcode() {
        // iframe을 넣은 element를 안보이게 한다.
        element_layer.style.display = 'none';
    }

    function sample2_execDaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
                // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var addr = ''; // 주소 변수
                var extraAddr = ''; // 참고항목 변수

                //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                    addr = data.roadAddress;
                } else { // 사용자가 지번 주소를 선택했을 경우(J)
                    addr = data.jibunAddress;
                }

                // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
                if(data.userSelectedType === 'R'){
                    // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                    // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                    if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                        extraAddr += data.bname;
                    }
                    // 건물명이 있고, 공동주택일 경우 추가한다.
                    if(data.buildingName !== '' && data.apartment === 'Y'){
                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                    }
                    // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                    if(extraAddr !== ''){
                        extraAddr = ' (' + extraAddr + ')';
                    }
                    // 조합된 참고항목을 해당 필드에 넣는다.
                    // document.getElementById("sample2_extraAddress").value = extraAddr;
                } else {
                    // document.getElementById("sample2_extraAddress").value = '';
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('post').value = data.zonecode;
                document.getElementById("address_1").value = addr;
                // 커서를 상세주소 필드로 이동한다.
                document.getElementById("address_2").focus();

                // iframe을 넣은 element를 안보이게 한다.
                // (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
                element_layer.style.display = 'none';
            },
            width : '100%',
            height : '100%',
            maxSuggestItems : 5
        }).embed(element_layer);

        // iframe을 넣은 element를 보이게 한다.
        element_layer.style.display = 'block';

        // iframe을 넣은 element의 위치를 화면의 가운데로 이동시킨다.
        initLayerPosition();
    }

    // 브라우저의 크기 변경에 따라 레이어를 가운데로 이동시키고자 하실때에는
    // resize이벤트나, orientationchange이벤트를 이용하여 값이 변경될때마다 아래 함수를 실행 시켜 주시거나,
    // 직접 element_layer의 top,left값을 수정해 주시면 됩니다.
    function initLayerPosition(){
        var width = 300; //우편번호서비스가 들어갈 element의 width
        var height = 400; //우편번호서비스가 들어갈 element의 height
        var borderWidth = 5; //샘플에서 사용하는 border의 두께

        // 위에서 선언한 값들을 실제 element에 넣는다.
        element_layer.style.width = width + 'px';
        element_layer.style.height = height + 'px';
        element_layer.style.border = borderWidth + 'px solid';
        // 실행되는 순간의 화면 너비와 높이 값을 가져와서 중앙에 뜰 수 있도록 위치를 계산한다.
        element_layer.style.left = (((window.innerWidth || document.documentElement.clientWidth) - width)/2 - borderWidth) + 'px';
        element_layer.style.top = (((window.innerHeight || document.documentElement.clientHeight) - height)/2 - borderWidth) + 'px';
    }
</script>
<script type="text/javascript">
    // 초기화
    $(document).ready(function(){
        doSearch();
        department_list();
        position_list();
    })
</script>
