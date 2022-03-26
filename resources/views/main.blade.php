@extends('layouts.default')

@section('head')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <!-- d3 and c3 charts -->
    <link href="{{ asset("asset/css/plugins/c3/c3.min.css") }}" rel="stylesheet">
    <script src=""></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <h3><i class="fa fa-clock-o"></i> 근무시간</h3>
                </div>

                <div class="ibox-content">
                    <div class="row mb-3">
                        <div class="col-xl-12" style="text-align: center;">
                            <div class="today-info">
                                <span class="font-bold" id="" style="line-height: 44px;">{{ $now }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12" style="text-align: center;">
                            <div class="today-info">
                                금일 근무 시간:
                                <span class="font-bold" id="work_time" style="line-height: 46px;"> {{ isset($attendance_data) ? $attendance_data->work_time : '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="widget style1" style="background-color: #1ab39412; padding: 10px 15px;">
                                <div class="row vertical-align">
                                    <div class="col-6 text-center">
                                        <h5 class="font-normal">츨근</h5>
                                        <h3 class="font-bold" id="work_start_time">{{ isset($attendance_data) ? substr($attendance_data->work_start_time,0,5) : '출근전' }}</h3>
                                    </div>
                                    <div class="col-6 text-center">

                                        <h5 class="font-normal">퇴근</h5>
                                        <h3 class="font-bold" id="work_end_time">{{ isset($attendance_data) ? substr($attendance_data->work_end_time,0,5) : '퇴근전' }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--<div class="col-6">--}}
                        {{--    <div class="widget style1 lazur-bg">--}}
                        {{--        <div class="row vertical-align">--}}
                        {{--            <div class="col-12 text-center">--}}
                        {{--                <h3 class="font-bold" id="work_end_time">{{ isset($attendance_data) ? $attendance_data->work_end_time : '-' }}</h3>--}}
                        {{--            </div>--}}
                        {{--        </div>--}}
                        {{--    </div>--}}
                        {{--</div>--}}
                    </div>

                    <div class="row">
                        <div class="col-12" style="cursor: pointer" id="btn_work_check">
                            <input type="hidden" id="work_check_data">
                            <div class="btn btn-default full-width">
                                <div class="text-center">
                                    <h3 class="font-bold work_check_text">출근하기</h3>
                                </div>
                            </div>
                        </div>
                        {{--<div class="col-6" style="cursor: pointer" id="work_end">--}}
                        {{--    <div class="widget style1 lazur-bg">--}}
                        {{--        <div class="row vertical-align">--}}
                        {{--            <div class="col-5">--}}
                        {{--                <i class="fa fa-home fa-3x"></i>--}}
                        {{--            </div>--}}
                        {{--            <div class="col-7 text-center">--}}
                        {{--                <h3 class="font-bold">퇴근</h3>--}}
                        {{--            </div>--}}
                        {{--        </div>--}}
                        {{--    </div>--}}
                        {{--</div>--}}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h3><i class="fa fa-suitcase"></i> 금주 근무 현황</h3>
                </div>
                <div class="ibox-content">
                    <div>
                        <div id="chart"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <h3><i class="fa fa-list-ol"></i> 할일관리</h3>
                </div>
                <div class="ibox-content">
                    <ul class="todo-list m-t small-list ui-sortable" id="todo_list"></ul>

                    <div class="todo-list">
                        <div class="input-group">
                        <input type="text" id="todo_list_input" class="form-control" placeholder="할일 등록" autocomplete="off">
                        <span class="input-group-append"> <button type="button" class="btn btn-xs btn-primary" id="btn_todo_list_save">등록</button> </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4">
            <div id="ibox_1" class="ibox">
                <div class="ibox-title">
                    <h3><i class="fa fa-thumb-tack"></i> 공지사항</h3>
                    <div class="ibox-tools mt-1">
                        <a href="/setting/notice"><i class="fa fa-plus"></i>더보기</a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table mb-0" id="dataTables_3" style="width: 100%">
                            <colgroup>
                                <col style="">
                                <col style="width: 100px;">
                            </colgroup>
                            <thead>
                            <tr>
                                <th scope="col" class="text-center no_orderable">제목</th>
                                <th scope="col" class="text-center no_orderable">작성일</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div id="ibox_1" class="ibox">
                <div class="ibox-title">
                    <h3><i class="fa fa-pencil"></i> 전자결재</h3>
                    <div class="ibox-tools mt-1">
                        <a id="approval_plus"><i class="fa fa-plus"></i>더보기</a>
                    </div>
                </div>
                <div class="ibox-content">

                    <div class="tabs-container">
                        <ul class="nav nav-tabs" id="myTab-01" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="approval-tab-01" data-toggle="tab" href="#dataTables_approval-01" role="tab" aria-controls="approval-01" aria-selected="true">
                                    내가 상신한 문서</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="approval-tab-02" data-toggle="tab" href="#dataTables_approval-02" role="tab" aria-controls="approval-02" aria-selected="false">
                                    내가 결재할 문서</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            {{-- 전체 --}}
                            <div class="tab-pane fade show active" id="dataTables_approval-01" role="tabpanel" aria-labelledby="approval-tab-01">
                                <div class="table-responsive">
                                    <table class="table mb-0" id="dataTables_1" style="width: 100%">
                                        <colgroup>
                                            <col style="width: 150px;">
                                            <col style="width: 100px;">
                                            <col style="">
                                            <col style="width: 150px;">
                                            <col style="width: 100px;">
                                        </colgroup>
                                        <thead>
                                        <tr>
                                            <th scope="col" class="text-center no_orderable">기안일</th>
                                            <th scope="col" class="text-center no_orderable">긴급</th>
                                            <th scope="col" class="text-center no_orderable">제목</th>
                                            <th scope="col" class="text-center no_orderable">문서번호</th>
                                            <th scope="col" class="text-center no_orderable">문서상태</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- 진행중 --}}
                            <div class="tab-pane fade show" id="dataTables_approval-02" role="tabpanel" aria-labelledby="approval-tab-02">
                                <div class="table-responsive">
                                    <table class="table mb-0" id="dataTables_2" style="width: 100%">
                                        <colgroup>
                                            <col style="width: 150px;">
                                            <col style="width: 100px;">
                                            <col style="">
                                            <col style="width: 150px;">
                                            <col style="width: 100px;">
                                        </colgroup>
                                        <thead>
                                        <tr>
                                            <th scope="col" class="text-center no_orderable">기안일</th>
                                            <th scope="col" class="text-center no_orderable">긴급</th>
                                            <th scope="col" class="text-center no_orderable">제목</th>
                                            <th scope="col" class="text-center no_orderable">문서번호</th>
                                            <th scope="col" class="text-center no_orderable">문서상태</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')

@endsection

@section('script')
    <!-- d3 and c3 charts -->
    <script src="{{ asset("asset/js/plugins/d3/d3.min.js") }}"></script>
    <script src="{{ asset("asset/js/plugins/c3/c3.min.js") }}"></script>
    @include('main_js')
@endsection
