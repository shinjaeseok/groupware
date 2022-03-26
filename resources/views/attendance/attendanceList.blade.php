@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="col-xl-12">
            <div id="ibox_1" class="ibox">
                <div class="ibox-title">
                    <h3>전체 근태현황</h3>
                </div>

                <div class="ibox-content table-responsive">

                    <table class="table no-margins" id='dataTables_1' style="width: 100%">
                        <colgroup>
                            <col style="width: 10%">
                            <col style="">
                            <col style="width: 15%">
                            <col style="width: 15%">
                            <col style="width: 10%">
                            <col style="width: 10%">
                            <col style="width: 10%">
                        </colgroup>
                        <thead class="thead-themed">
                        <tr>
                            <th class='text-center' style=''>근무일</th>
                            <th class='text-center' style=''>이름</th>
                            <th class='text-center' style=''>부서</th>
                            <th class='text-center' style=''>직책</th>
                            <th class='text-center' style=''>출근</th>
                            <th class='text-center' style=''>퇴근</th>
                            <th class='text-center' style=''>근무</th>
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
    @include('attendance.attendanceList_js')
@endsection
