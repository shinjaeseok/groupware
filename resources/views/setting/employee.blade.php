@extends('layouts.default')

@section('head')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="{{ asset('asset/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
@endsection


@section('content')

    <div class="row">
        <div class="col-xl-12">
            <div id="ibox_1" class="ibox">
                <div class="ibox-title">
                    <h3>사원정보</h3>
                </div>

                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table" id="dataTables_1" style="width: 100%">
                            <colgroup>
                                <col style="width:10%">
                                <col style="width:15%">
                                <col style="width:15%">
                                <col style="width:15%">
                                <col style="width:15%">
                                <col style="width:15%">
                                <col style="width:20%">
                            </colgroup>
                            <thead class="thead-themed">
                            <tr>
                                <th class='text-center' style=''>상태</th>
                                <th class='text-center' style=''>이름</th>
                                <th class='text-center' style=''>연락처</th>
                                <th class='text-center' style=''>이메일</th>
                                <th class='text-center' style=''>부서</th>
                                <th class='text-center' style=''>직책</th>
                                <th class='text-center' style=''>관리</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        </div>
                    <div class="row">
                        <div class="col-xl-12 text-right">
                            <button type="button" class="btn btn-primary btn-sm" id="btn_create">등록</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="modal_input" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">
                        사원 등록
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>

                <div class="modal-body">
                    <div class="row mb-1">
                        <div class="col-xl-3 border-right">
                            <div class="row ml-1">
                                <img class="rounded-circle img-lg" src="" alt="" id='profile_img'>
                                <div class="ml-3">
                                    <h3>
                                        <span class="font-bold" id="left_bar_user_name">이름</span>
                                    </h3>
                                    <h4>
                                        <span class="font-normal" id="left_bar_department_name">부서</span>
                                    </h4>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-6 mb-2">
                                    <span class="btn full-width" id="left_bar_state">재직</span>
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <button type="button" class="btn btn-outline-danger full-width" id="left_bar_delete" disabled>삭제</button>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="form-group">
                                    <div id="new_employee">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-9">
                            <p class="font-bold">직무정보</p>
                            <div class="row mb-1">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="form-label" for="employee_code">사원코드</label><span class="badge badge-overlay-danger ml-2">필수</span>
                                        <input form="form_modal" type="text" placeholder="사원코드 입력" id="employee_code" name="employee_code" class="form-control bg-white border-0" autocomplete="off" readonly>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <label class="form-label" for="password_check">&nbsp;</label>
                                        <div class="input-group">
                                            <button type="button" class="btn btn-default" id="password_check">비밀번호 변경</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <label class="form-label" for="manager">관리자지정</label>
                                        <div class="form-check abc-checkbox abc-checkbox-danger">
                                            <input class="form-check-input" form="form_modal" id="manager"  name="manager" type="checkbox" >
                                            <label class="form-check-label" for="manager">

                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="form-label" for="department">부서</label><span class="badge badge-overlay-danger ml-2">필수</span>
                                        <select form="form_modal" id="department_id" name="department_id" class="form-control" style="width: 100%" required>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="form-label" for="position">직책</label><span class="badge badge-overlay-danger ml-2">필수</span>
                                        <select form="form_modal" id="position_id" name="position_id" class="form-control" style="width: 100%" required>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="form-label" for="is_deleted">상태</label><span class="badge badge-overlay-danger ml-2">필수</span>
                                        <select form="form_modal" id="is_deleted" name="is_deleted" class="form-control" style="width: 100%" required>
                                            <option value="N">재직</option>
                                            <option value="Y">퇴사</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="form-label" for="join_date">입사일</label><span class="badge badge-overlay-danger ml-2">필수</span>
                                        <input form="form_modal" type="text" placeholder="입사일 입력" id="join_date" name="join_date" class="form-control datepicker" value="{{ date('Y-m-d') }}" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="form-label" for="leave_date">퇴사일</label>
                                        <input form="form_modal" type="text" placeholder="퇴사일 입력" id="leave_date" name="leave_date" class="form-control datepicker" value="{{ date('Y-m-d') }}" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <p class="font-bold">개인정보</p>
                            <div class="row mb-1">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="form-label" for="name">이름</label><span class="badge badge-overlay-danger ml-2">필수</span>
                                        <input form="form_modal" type="text" placeholder="이름 입력" id="name" name="name" class="form-control" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="form-label" for="phone">연락처</label>
                                        <input form="form_modal" type="text" placeholder="연락처 입력" id="phone" name="연락처" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="form-label" for="email">이메일</label>
                                        <input form="form_modal" type="text" placeholder="이메일 입력" id="email" name="email" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <label class="form-label" for="post">우편번호</label>
                                        <div class="input-group">
                                            <input form="form_modal" type="text" placeholder="우편번호 입력" id="post" name="post" class="form-control" autocomplete="off">
                                            <span class="input-group-append"> <button type="button" class="btn btn-xs btn-default" onclick="sample2_execDaumPostcode()">우편번호찾기</button></span>
                                        </div>
                                    </div>

                                    <div id="layer" style="display:none;position:fixed;overflow:hidden;z-index:10;-webkit-overflow-scrolling:touch;">
                                        <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:10" onclick="closeDaumPostcode()" alt="닫기 버튼">
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-1">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="form-label" for="address_1">주소</label>
                                        <input form="form_modal" type="text" placeholder="주소 입력" id="address_1" name="address_1" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="form-label" for="address_2">상세주소</label>
                                        <input form="form_modal" type="text" placeholder="상세주소 입력" id="address_2" name="address_2" class="form-control" autocomplete="off">
                                    </div>
                                </div>
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


    <div class="modal fade" id="modal_2" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">
                        비밀번호 변경
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>

                <div class="modal-body">

                    <div class="row mb-1">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label class="form-label" for="new_password">신규 비밀번호</label><span class="badge badge-overlay-danger ml-2">필수</span>
                                <input form="form_modal_2" type="password" placeholder="신규 비밀번호" id="new_password" name="new_password" class="form-control" value="" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label class="form-label" for="check_password">비밀번호 확인</label><span class="badge badge-overlay-danger ml-2">필수</span>
                                <input form="form_modal_2" type="password" placeholder="비밀번호 확인" id="check_password" name="check_password" class="form-control" value="" autocomplete="off">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button form="form_modal_2" type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                    <button form="form_modal_2" type="button" class="btn btn-primary" id="btn_modal_password_save">저장</button>
                </div>
            </div>
        </div>
    </div>

    <form id="form_modal_2" name="form_modal_2">
        <input type="hidden" id="modal_id_2" name="modal_id_2">
    </form>
@endsection

@section('script')
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="{{ asset('asset/js/plugins/iCheck/icheck.min.js') }}"></script>
@include('setting.employee_js')
@endsection
