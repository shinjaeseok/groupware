@extends('layouts.default')

@section('head')
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div id="ibox_1" class="ibox">
                <div class="ibox-title">
                    <h3>결재함</h3>
                </div>
                <div class="ibox-content">

                    <div class="tabs-container">
                        <ul class="nav nav-tabs" id="myTab-01" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="approval-tab-01" data-toggle="tab" href="#dataTables_approval-01" role="tab" aria-controls="approval-01" aria-selected="true">
                                    전체</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="approval-tab-02" data-toggle="tab" href="#dataTables_approval-02" role="tab" aria-controls="approval-02" aria-selected="false">
                                    대기</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="approval-tab-03" data-toggle="tab" href="#dataTables_approval-03" role="tab" aria-controls="approval-03" aria-selected="false">
                                    완료</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            {{-- 전체 --}}
                            <div class="tab-pane fade show active" id="dataTables_approval-01" role="tabpanel" aria-labelledby="approval-tab-01">
                                <div class="table-responsive">
                                    <table class="table mb-0" id="dataTables_1" style="width: 100%">
                                        <colgroup>
                                            <col style="width: 70px;">
                                            <col style="width: 150px;">
                                            <col style="width: 150px;">
                                            <col style="width: 100px;">
                                            <col style="">
                                            <col style="width: 150px;">
                                            <col style="width: 150px;">
                                            <col style="width: 100px;">
                                            <col style="width: 100px;">
                                        </colgroup>
                                        <thead>
                                        <tr>
                                            <th scope="col" class="text-center">NO</th>
                                            <th scope="col" class="text-center no_orderable">기안일</th>
                                            <th scope="col" class="text-center no_orderable">양식구분</th>
                                            <th scope="col" class="text-center no_orderable">긴급</th>
                                            <th scope="col" class="text-center no_orderable">제목</th>
                                            <th scope="col" class="text-center no_orderable">첨부</th>
                                            <th scope="col" class="text-center">문서번호</th>
                                            <th scope="col" class="text-center no_orderable">문서상태</th>
                                            <th scope="col" class="text-center no_orderable">결재상태</th>
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
                                            <col style="width: 70px;">
                                            <col style="width: 150px;">
                                            <col style="width: 150px;">
                                            <col style="width: 100px;">
                                            <col style="">
                                            <col style="width: 150px;">
                                            <col style="width: 150px;">
                                            <col style="width: 100px;">
                                            <col style="width: 100px;">
                                        </colgroup>
                                        <thead>
                                        <tr>
                                            <th scope="col" class="text-center">NO</th>
                                            <th scope="col" class="text-center no_orderable">기안일</th>
                                            <th scope="col" class="text-center no_orderable">양식구분</th>
                                            <th scope="col" class="text-center no_orderable">긴급</th>
                                            <th scope="col" class="text-center no_orderable">제목</th>
                                            <th scope="col" class="text-center no_orderable">첨부</th>
                                            <th scope="col" class="text-center">문서번호</th>
                                            <th scope="col" class="text-center no_orderable">문서상태</th>
                                            <th scope="col" class="text-center no_orderable">결재상태</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- 완료 --}}
                            <div class="tab-pane fade show" id="dataTables_approval-03" role="tabpanel" aria-labelledby="approval-tab-03">
                                <div class="table-responsive">
                                    <table class="table mb-0" id="dataTables_3" style="width: 100%">
                                        <colgroup>
                                            <col style="width: 70px;">
                                            <col style="width: 150px;">
                                            <col style="width: 150px;">
                                            <col style="width: 100px;">
                                            <col style="">
                                            <col style="width: 150px;">
                                            <col style="width: 150px;">
                                            <col style="width: 100px;">
                                            <col style="width: 100px;">
                                        </colgroup>
                                        <thead>
                                        <tr>
                                            <th scope="col" class="text-center">NO</th>
                                            <th scope="col" class="text-center no_orderable">기안일</th>
                                            <th scope="col" class="text-center no_orderable">양식구분</th>
                                            <th scope="col" class="text-center no_orderable">긴급</th>
                                            <th scope="col" class="text-center no_orderable">제목</th>
                                            <th scope="col" class="text-center no_orderable">첨부</th>
                                            <th scope="col" class="text-center">문서번호</th>
                                            <th scope="col" class="text-center no_orderable">문서상태</th>
                                            <th scope="col" class="text-center no_orderable">결재상태</th>
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

    <form id="form_main" name="form_main">
        <input type="hidden" id="id" name="id" value="">
    </form>
@endsection

@section('modal')
    <div class="modal fade" id="modal_main" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">
                        기안 보기
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>

                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-lg-12 float-e-margins">
                            <button type="button" class="btn btn-w-sm btn-warning btn-sm" id="btn_approval_cancel"><i class="fa fa-info-circle mr-1"></i>결재취소</button>
                            <button type="button" class="btn btn-w-sm btn-info btn-sm" id="btn_approval_info"><i class="fa fa-info-circle mr-1"></i>문서정보</button>
                            <button type="button" class="btn btn-w-sm btn-info btn-sm" id="btn_approval_line"><i class="fa fa-list-ul mr-1"></i>결재선</button>
                            <button type="button" class="btn btn-w-sm btn-info btn-sm" id="btn_approval_comment" onclick="approvalComment()"><i class="fa fa-comment mr-1"></i>의견</button>
                            <button type="button" class="btn btn-w-sm btn-info btn-sm" id="btn_approval_attachment"><i class="fa fa-folder mr-1"></i>첨부파일</button>
                            <div class="float-right">
                                <button type="button" class="btn btn-w-sm btn-danger btn-sm" id="btn_approval_deny">반려</button>
                                <button type="button" class="btn btn-w-sm btn-primary btn-sm" id="btn_approval_admit">승인</button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" for="document_no">문서번호</label>
                                <input form="form_main" type="text" id="document_no" name="document_no" placeholder="문서번호" class="form-control" value="" readonly>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" for="user_name">작성자</label>
                                <input form="form_main" type="text" id="user_name" name="user_name" placeholder="작성자" class="form-control" value="" readonly>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" for="department_name">작성부서</label>
                                <input form="form_main" type="text" id="department_name" name="department_name" placeholder="작성부서" class="form-control" value="" readonly>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" for="approval_date">기안일자</label>
                                <input form="form_main" type="text" id="approval_date" name="approval_date" placeholder="기안일자" class="form-control" value="" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label" for="title">제목</label>
                                <input form="form_main" type="text" id="title" name="title" placeholder="제목" class="form-control" value="" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label" for="contents">내용</label>
                                <div class="card">
                                    <div id="contents" class="card-body"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <form id="form_modal_main" name="form_modal_main">
        <input type="hidden" id="modal_main_id" name="modal_main_idmodal_id">
    </form>

    <div class="modal fade" id="modal_1" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">
                        문서 정보
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>

                <div class="modal-body">

                    <div class="form-row">
                        <div class="table-responsive">
                            <table class="table table-centered mb-3" style="width: 100%">
                                <colgroup>
                                    <col style="width: 100px;">
                                    <col style="width: 150px;">
                                    <col style="width: 100px;">
                                    <col style="width: 150px;">
                                </colgroup>
                                <thead>
                                <tr class="text-left">
                                    <th scope="col" colspan="4">기본정보</th>
                                </tr>
                                </thead>

                                <tbody>
                                <tr>
                                    <td class="bg-bg-light-overlay">문서번호</td>
                                    <td>
                                        <input class="form-control" id="modal_document_no" name="modal_document_no" readonly>
                                    </td>
                                    <td class="bg-bg-light-overlay">발신종류</td>
                                    <td>
                                        <select form="form_modal" id="send_type" name='send_type' class="input-group select2" style="width: 100%" disabled>
                                            <option value="내부">내부</option>
                                            <option value="외부">외부</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-bg-light-overlay">긴급유무</td>
                                    <td>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input form="form_modal" type="radio" id="emergency_type_1" name="emergency_type" class="custom-control-input" value="N" disabled>
                                            <label class="custom-control-label" for="emergency_type_1">일반</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input form="form_modal" type="radio" id="emergency_type_2" name="emergency_type" class="custom-control-input" value="Y" disabled>
                                            <label class="custom-control-label" for="emergency_type_2">긴급</label>
                                        </div>
                                    </td>
                                    <td class="bg-bg-light-overlay">보존년한</td>
                                    <td>
                                        <select form="form_modal" id="document_life" name='document_life' class="input-group select2" style="width: 100%" disabled>
                                            <option value="0">영구</option>
                                            <option value="10">10년</option>
                                            <option value="5">5년</option>
                                            <option value="3">3년</option>
                                            <option value="1">1년</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-bg-light-overlay">합의방식</td>
                                    <td>
                                        <select form="form_modal" id="agreement_type" name='agreement_type' class="input-group select2" style="width: 100%" disabled>
                                            <option value="순차">순차</option>
                                            <option value="병렬">병렬</option>
                                        </select>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form id="form_modal" name="form_modal">
        <input type="hidden" id="modal_id" name="modal_id">
    </form>

    <div class="modal fade" id="modal_2" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">
                        결재선
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>

                <div class="modal-body">

                    <div class="row mb-1">
                        <div class="col-lg-12">
                            <label class="form-label">결재선</label>
                            <div class="card">
                                <div class="card-body">

                                    <table class="table table-centered mb-3" style="width: 100%">
                                        <colgroup>
                                            <col style="width: 150px;">
                                            <col style="">
                                            <col style="width: 100px;">
                                        </colgroup>
                                        <thead>
                                        <tr class="text-center">
                                            <th scope="col">결재방법</th>
                                            <th scope="col">결재자</th>
                                            <th scope="col">승인상태</th>
                                        </tr>
                                        </thead>

                                        <tbody id="approval_user_list"></tbody>

                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="form_modal_2" name="form_modal_2">
        <input type="hidden" id="modal_id_2" name="modal_id_2">
    </form>

    <div class="modal fade" id="modal_3" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">
                        의견
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>

                <div class="modal-body">

                    <div class="row mb-1">
                        <div class="col-lg-12">

                            <div class="feed-activity-list">

                                {{-- 리스트 --}}
                                <div id="comment_list">

                                </div>

                                {{-- 작성자 --}}
                                <div id="comment_textarea">
                                    <div class="feed-element mt-3" style="border-bottom: 0px;">
                                        <a href="#" class="float-left">
                                            <img alt="image" class="rounded-circle" src="{{ session()->get('profile_img') }}" style="width: 38px; height: 38px;">
                                        </a>
                                        <div class="media-body ">
                                            {{--<small class="float-right">2h ago</small>--}}
                                            <strong>{{ Auth::user()->name }}</strong><br>
                                            {{--<small class="text-muted">Today 2:10 pm - 12.06.2014</small>--}}
                                            <textarea form="form_modal_3" class="form-control well" name="comment" id="comment" rows="2"></textarea>
                                            <div class="float-right">
                                                <button form="form_modal_3" type="button" class="btn btn-xs btn-primary" id="btn_approval_comment_modal_save">저장</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button form="form_modal_3" type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                </div>
            </div>
        </div>
    </div>
    <form id="form_modal_3" name="form_modal_3">
        <input type="hidden" id="modal_id_3" name="modal_id_3">
    </form>

    <div class="modal fade" id="modal_4" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">
                        첨부파일
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>

                <div class="modal-body">

                    <div class="row mb-1">
                        <div class="col-lg-12">
                            <div id="file_upload_list">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form id="form_modal_4" name="form_modal_4">
        <input type="hidden" id="modal_id_4" name="modal_id_4">
    </form>

    <div class="modal fade" id="modal_5" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">
                        비밀번호 확인
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <input form="form_modal_5" type="password" placeholder="비밀번호" id="password" name="password" class="form-control password_input" value="" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button form="form_modal_5" type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                    <button form="form_modal_5" type="button" class="btn btn-primary" id="btn_approval_password_check">확인</button>
                </div>
            </div>
        </div>
    </div>

    <form id="form_modal_5" name="form_modal_5">
        <input type="hidden" id="modal_id_5" name="modal_id_5">
    </form>
@endsection

@section('script')
    @include('approval.approvalList_js')
@endsection
