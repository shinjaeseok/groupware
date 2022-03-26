@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="col-xl-12">
            <div id="ibox_1" class="ibox">
                <div class="ibox-title">
                    <h3>근태관리</h3>
                </div>

                <div class="ibox-content table-responsive">

                    <table class="table no-margins" id='dataTables_1' style="width: 100%">
                        <colgroup>
                            <col style="width: 10%">
                            <col style="width: 10%">
                            <col style="width: 10%">
                            <col style="width: 10%">
                            <col style="width: 10%">
                            <col style="width: 10%">
                            <col style="">
                            <col style="width: 15%">
                            <col style="width: 10%">
                        </colgroup>
                        <thead class="thead-themed">
                        <tr>
                            <th class='text-center no_orderable' style=''>이름</th>
                            <th class='text-center no_orderable' style=''>근무일</th>
                            <th class='text-center no_orderable' style=''>요청전출근</th>
                            <th class='text-center no_orderable' style=''>요청전퇴근</th>
                            <th class='text-center no_orderable' style=''>요청출근</th>
                            <th class='text-center no_orderable' style=''>요청퇴근</th>
                            <th class='text-center no_orderable' style=''>근무</th>
                            <th class='text-center no_orderable' style=''>처리상태</th>
                            <th class='text-center no_orderable' style=''>상세보기</th>
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

@section('modal')
    <div class="modal fade" id="modal_input" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">
                        근태 상세보기
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>

                <div class="modal-body">

                    <div class="d-flex mb-1">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="modal_user_name">이름</label>
                                <input form="form_modal" type="text" placeholder="이름" id="modal_user_name" name="modal_user_name" class="form-control" autocomplete="off" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="modal_work_date">근무일</label>
                                <input form="form_modal" type="text" placeholder="근무일" id="modal_work_date" name="modal_work_date" class="form-control" autocomplete="off" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex mb-1">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="modal_work_start_time">요청전출근</label>
                                <input form="form_modal" type="text" placeholder="요청전출근" id="modal_work_start_time" name="modal_work_start_time" class="form-control" autocomplete="off" readonly>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="modal_work_end_time">요청전퇴근</label>
                                <input form="form_modal" type="text" placeholder="요청전퇴근" id="modal_work_end_time" name="modal_work_end_time" class="form-control" autocomplete="off" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex mb-1">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="modal_work_start_time_after">요청출근</label>
                                <input form="form_modal" type="text" placeholder="요청출근" id="modal_work_start_time_after" name="modal_work_start_time_after" class="form-control" autocomplete="off" readonly>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="modal_work_end_time_after">요청퇴근</label>
                                <input form="form_modal" type="text" placeholder="요청퇴근" id="modal_work_end_time_after" name="modal_work_end_time_after" class="form-control" autocomplete="off" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex mb-1">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="modal_status">처리상태</label>
                                <select form="form_modal" type="text" placeholder="처리상태" id="modal_status" name="modal_status" class="form-control">
                                    <option value="미처리">미처리</option>
                                    <option value="승인">승인</option>
                                    <option value="반려">반려</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex mb-1">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label" for="modal_reason">사유</label>
                                <textarea  form="form_modal" id="modal_reason" name="modal_reason" class="form-control" style="width: 100%" readonly></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex mb-1">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label" for="modal_answer">답변</label>
                                <textarea  form="form_modal" id="modal_answer" name="modal_answer" class="form-control" style="width: 100%"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button form="form_modal" type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                    <button form="form_modal" type="button" class="btn btn-primary" id="btn_save">저장</button>
                </div>
            </div>
        </div>
    </div>

    <form id="form_modal" name="form_modal">
        <input type="hidden" id="modal_id" name="modal_id">
    </form>
@endsection

@section('script')
    @include('attendance.attendanceManage_js')
@endsection
