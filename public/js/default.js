// CSRF token setup
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function hrDate($val) {
    var date = !$val ? new Date() : new Date($val);
    year = date.getFullYear().toString();
    month = (date.getMonth() + 1).toString();
    day = date.getDate().toString();
    newDate = year + "-" + (month[1] ? month : "0" + month[0]) + "-" + (day[1] ? day : "0" + day[0]);

    return newDate;
}

// Datepicker Setting defaults
$.fn.datepicker.dates['kr'] = {
    days: ["일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일"],
    daysShort: ["일", "월", "화", "수", "목", "금", "토"],
    daysMin: ["일", "월", "화", "수", "목", "금", "토"],
    months: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
    monthsShort: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
    today: "오늘",
    clear: "비우기",
};

$('.datepicker').datepicker({
    format: "yyyy-mm-dd",
    titleFormat: "yyyy mm", /* Leverages same syntax as 'format' */
    weekStart: 0,
    todayBtn: "linked",
    keyboardNavigation: true,
    forceParse: false,
    // calendarWeeks: true,
    autoclose: true,
    language: 'kr',
    showMonthAfterYear: true,
});

// Datatables Setting defaults
$.extend( true, $.fn.dataTable.defaults, {
    retrieve: true,
    // "searching": false,
    // "ordering": false,
    columnDefs: [ { targets: ['no_orderable'], orderable: false } ],
    responsive: true,
    // paginate: false,
    order: [],
    // dom: '<"html5buttons"B>Tfgitp',
    dom:
        "<'row mb-1 mt-3'<'col-sm-6 d-flex justify-content-start'lB><'col-sm-6 d-flex justify-content-end'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-3'i><'col-sm-6 d-flex justify-content-center'p>>",
    lengthChange: false,
    paging: true,
    scrollX: true,
    pageLength: 10,
    language: {
        "decimal" : "",
        "emptyTable" : "데이터가 없습니다.",
        "info" : "_START_ - _END_ (총, _TOTAL_ 건)",
        "infoEmpty" : "0건",
        "infoFiltered" : "(전체 _MAX_ 건 중 검색결과)",
        "infoPostFix" : "",
        "thousands" : ",",
        "lengthMenu" : "_MENU_ 개씩 보기",
        // "loadingRecords" : "로딩중...",
        // "loadingRecords": "<div style='padding:25px;'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></div>",
        "loadingRecords": "<div style='padding:25px;'><div class='sk-spinner sk-spinner-three-bounce'><div class='sk-bounce1'></div><div class='sk-bounce2'></div><div class='sk-bounce3'></div></div></div>",
        // "processing" : "처리중...",
        // "processing" : "<div style='padding:25px;'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></div>",
        "processing": "<div style='padding:25px;'><div class='sk-spinner sk-spinner-three-bounce'><div class='sk-bounce1'></div><div class='sk-bounce2'></div><div class='sk-bounce3'></div></div></div>",
        "search" : "",
        "searchPlaceholder": "결과내 검색",
        "zeroRecords" : "검색된 데이터가 없습니다.",
        "paginate" : {
            "first" : "첫 페이지",
            "last" : "마지막 페이지",
            "next" : "다음",
            "previous" : "이전"
        },
        "aria" : {
            "sortAscending" : " :  오름차순 정렬",
            "sortDescending" : " :  내림차순 정렬"
        }
    }
});

$('.select2').select2();

$(".search_false_select_box").select2({
    minimumResultsForSearch : -1    // search false
});

// 말줄임
function shortening(str) {
    if (str.length >= 30){
        return str.substr(0,30)+"...";
    }
    return str
}
