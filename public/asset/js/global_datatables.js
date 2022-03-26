var dataTableOpt  = {
    retrieve: true,
    language: {
        // "loadingRecords": '<div style="padding:25px; text-align:center; color:#0c0d0e;"><i class="fal fa-spinner fa-spin fa-3x fa-fw"></i></div>',
        "emptyTable": '<div style="font-size:12px; text-align:center; color:#0c0d0e;">'+"데이터가 없습니다."+'</div>',
        "zeroRecords": '<div style="font-size:12px; text-align:center; color:#0c0d0e;">'+"검색된 데이터가 없습니다."+'</div>',
        "search" : "",
        "searchPlaceholder": "결과내 검색",
        "sLengthMenu": "줄 표시 _MENU_",
        "paginate": {
            "first":      "처음",
            "last":       "마지막",
            "next":       "다음",
            "previous":   "이전"
        },
        "info": "총 _TOTAL_개 중, _START_~_END_번째",
    },
    paging: true,
    pageLength: 10,
    lengthChange: true,
    // dom: 't<"pull-left"><"pull-center"p>',
    dom:
        "<'row mb-1 mt-3'<'col-sm-6 d-flex justify-content-start'lB><'col-sm-6 d-flex justify-content-end'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-3'i><'col-sm-6 d-flex justify-content-center'p>>",
    order: [],
}
