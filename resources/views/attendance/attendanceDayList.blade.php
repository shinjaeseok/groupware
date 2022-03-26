@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="col-xl-12">
            <div id="ibox_1" class="ibox">
                <div class="ibox-title">
                    <h3>일별 근태현황</h3>
                </div>

                <div class="ibox-content table-responsive">

                    <div class="row">
                        <div class="col-lg-3">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input form="form_main" type="text" id="work_date" name="work_date" placeholder="조회일자" class="form-control datepicker" value="{{ date('Y-m-d') }}">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-sm btn-default" id="btn_search">검색</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table no-margins" id='dataTables_1' style="width: 100%">
                        <colgroup>
                            <col style="width: 10%">
                            <col style="width: 10%">
                            <col style="width: 6%">
                            <col style="">
                            <col style="width: 10%">
                            <col style="width: 6%">
                            <col style="width: 6%">
                            <col style="width: 6%">
                            <col style="width: 6%">
                        </colgroup>
                        <thead class="thead-themed">
                        <tr>
                            <th class='text-center no_orderable' style=''>이름</th>
                            <th class='text-center no_orderable' style=''>부서</th>
                            <th class='text-center no_orderable' style=''>근무상태</th>
                            <th class='text-center no_orderable' style=''>근로시간</th>
                            <th class='text-center no_orderable' style=''>목표달성도</th>
                            <th class='text-center no_orderable' style=''>출근시간</th>
                            <th class='text-center no_orderable' style=''>퇴근시간</th>
                            <th class='text-center no_orderable' style=''>휴식시간</th>
                            <th class='text-center no_orderable' style=''>연장근로</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <!-- datatable end -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('asset/js/plugins/peity/jquery.peity.min.js') }}"></script>
    @include('attendance.attendanceDayList_js')
@endsection
