@extends('layouts.default')

@section('head')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="{{ asset('asset/css/plugins/jsTree/style.min.css') }}" rel="stylesheet">

    <style>
        .filebox input[type="file"] {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            border: 0;
        }
    </style>

@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div id="ibox_1" class="ibox">
                <div class="ibox-title">
                    <h3>기안 작성</h3>
                </div>
                <div class="ibox-content">
                    <div class="row mb-3">
                        <div class="col-lg-12 float-e-margins">
                            <button type="button" class="btn btn btn-w-sm btn-default btn-sm" id="btn_approval_temp_save">임시저장</button>
                            <button type="button" class="btn btn btn-w-sm btn-primary btn-sm" id="btn_approval_save">기안상신</button>
                            <button type="button" class="btn btn btn-w-sm btn-info btn-sm" id="btn_approval_info"><i class="fa fa-info-circle mr-1"></i>문서정보</button>
                            <button type="button" class="btn btn btn-w-sm btn-info btn-sm" id="btn_approval_line"><i class="fa fa-list-ul mr-1"></i>결재선</button>
                            <button type="button" class="btn btn btn-w-sm btn-info btn-sm" id="btn_approval_comment" onclick="approvalComment()"><i class="fa fa-comment mr-1"></i>의견</button>
                            <button type="button" class="btn btn btn-w-sm btn-info btn-sm" id="btn_approval_attachment"><i class="fa fa-folder mr-1"></i>첨부파일</button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" for="user_name">작성자</label>
                                <input form="form_main" type="text" id="user_name" name="user_name" placeholder="작성자" class="form-control" value="{{ $approval_data->user_name }}" disabled>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" for="department_name">작성부서</label>
                                <input form="form_main" type="text" id="department_name" name="department_name" placeholder="작성부서" class="form-control" value="{{ $approval_data->department_name }}" disabled>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" for="approval_date">기안일자</label><span class="badge badge-overlay-danger ml-2">필수</span>
                                <input form="form_main" type="text" id="approval_date" name="approval_date" placeholder="기안일자" class="form-control datepicker" value="@if($approval_data->approval_date){{ $approval_data->approval_date }}@else{{ date('Y-m-d') }}@endif">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label" for="title">제목</label><span class="badge badge-overlay-danger ml-2">필수</span>
                                <input form="form_main" type="text" id="title" name="title" placeholder="제목" class="form-control" value="{{ $approval_data->title }}">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label" for="contents">내용</label><span class="badge badge-overlay-danger ml-2">필수</span>
                                <textarea form="form_main" id="contents" name="contents" class="form-control summernote" rows="15">{{ $approval_data->contents }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="form_main" name="form_main">
        <input type="hidden" id="id" name="id" value="{{ $approval_data->id }}">
    </form>
@endsection

@section('modal')
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
                            <table class="table table-centered mb-3">
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
                                        <input class="form-control" id="document_no" name="document_no" readonly>
                                    </td>
                                    <td class="bg-bg-light-overlay">발신종류</td>
                                    <td>
                                        <select form="form_modal" id="send_type" name='send_type' class="input-group select2" style="width: 100%">
                                            <option value="내부">내부</option>
                                            <option value="외부">외부</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-bg-light-overlay">긴급유무</td>
                                    <td>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input form="form_modal" type="radio" id="emergency_type_1" name="emergency_type" class="custom-control-input" value="N" checked>
                                            <label class="custom-control-label" for="emergency_type_1">일반</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input form="form_modal" type="radio" id="emergency_type_2" name="emergency_type" class="custom-control-input" value="Y">
                                            <label class="custom-control-label" for="emergency_type_2">긴급</label>
                                        </div>
                                    </td>
                                    <td class="bg-bg-light-overlay">보존년한</td>
                                    <td>
                                        <select form="form_modal" id="document_life" name='document_life' class="input-group select2" style="width: 100%">
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
                                        <select form="form_modal" id="agreement_type" name='agreement_type' class="input-group select2" style="width: 100%">
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

                <div class="modal-footer">
                    <button form="form_modal" type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                    <button form="form_modal" type="button" class="btn btn-primary" id="btn_approval_info_modal_save">저장</button>
                </div>
            </div>
        </div>
    </div>
    <form id="form_modal" name="form_modal">
        <input type="hidden" id="modal_id" name="modal_id">
    </form>

    <div class="modal fade" id="modal_2" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">
                        결재선
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>

                <div class="modal-body">

                    <div class="row mb-1">
                        <div class="col-xl-6 mt-2">
                            <label class="form-label">조직도</label>
                            <div class="card" >

                                <div class="card-title border-bottom">
                                    <div class="row">
                                        <div class="col-xl-4">
                                            <select form="form_modal_2" name='search_key' id="search_key" class='input-group search_false_select_box'>
                                                <option value="">전체</option>
                                                <option value="name" >이름</option>
                                                <option value="department" >부서</option>
                                            </select>
                                        </div>

                                        <div class="col-xl-8">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="search_value" name="search_value" placeholder="검색어" aria-label="Recipient's username" aria-describedby="button-addon2">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-sm btn-primary" id="btn_search">검색</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div id="tree" class="mb-3"></div>

                                    <div>
                                        <table class="table table-centered mb-3" id="dataTables_1" style="width: 100%">
                                            <colgroup>
                                                <col style="width: 20%;">
                                                <col style="width: 20%;">
                                                <col style="width: 20%;">
                                                <col style="width: 20%;">
                                                <col style="width: 20%;">
                                            </colgroup>
                                            <thead>
                                            <tr class="text-center">
                                                <th>프로필</th>
                                                <th>부서</th>
                                                <th>이름</th>
                                                <th>직책</th>
                                                <th>선택</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 mt-2">
                            <label class="form-label">결재선</label>
                            <div class="card">
                                <div class="card-body">

                                    <table class="table table-centered mb-3">
                                        <colgroup>
                                            <col style="width: 150px;">
                                            <col style="">
                                            <col style="width: 100px;">
                                        </colgroup>
                                        <thead>
                                        <tr class="text-center">
                                            <th scope="col">결재방법</th>
                                            <th scope="col">결재자</th>
                                            <th scope="col">관리</th>
                                        </tr>
                                        </thead>

                                        <tbody id="approval_user_list"></tbody>

                                        <tbody id="empty_text">
                                            <tr>
                                                <td class="text-center" colspan="3">결재자를 선택해주세요.</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button form="form_modal_2" type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                    <button form="form_modal_2" type="button" class="btn btn-primary" id="btn_approval_line_modal_save">저장</button>
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
                    {{--<button form="form_modal_3" type="button" class="btn btn-primary" id="btn_approval_attachment_modal_save">저장</button>--}}
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
                            <div class="addfile">
                                <!-- S://파일첨부 버튼영역 -->
                                <div class="dis_table">
                                    <div class="td">
                                        <div class="filebox" style="width: 400px">
                                            <label class="btn btn-sm btn-default mt-2" id="btn_file_uploaded_list">업로드 파일 목록</label>
                                            <label class="btn btn-sm btn-primary mt-2" for="attach_file">파일선택</label>
                                            <input form="form_modal_4" type="file" id="attach_file" name="attach_file[]" multiple="multiple">
                                            <button type="button" value="전체 삭제" id="btnDeleteFileAll" class="btn btn-sm btn-danger" style="display: none" onclick="DeleteFileAll()">전체 삭제</button>
                                            <button type="button" value="선택 삭제" id="btnDeleteFile" class="btn btn-sm btn-danger" style="display: none" onclick="DeleteFile();">선택 삭제</button>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-right">파일 용량&nbsp;<b><span class="text-primary" id="html5normalSize"></span><span class="text-primary">/50MB</span></b>
                                            <b class="hidden"><span class="text-primary" id="html5normalCount"></span></b>
                                        </p>
                                    </div>
                                </div>

                                <!-- S://드래그 파일존 -->
                                <div class="" id="divMain" style="border: 1px solid #a8b0b9;">
                                    <table class="table table-bordered table-sm table-striped w-100" style="margin-bottom:0px; ">
                                        <colgroup>
                                            <col style="width: 30px;">
                                            <col style="">
                                            <col style="width: 100px;">
                                        </colgroup>
                                        <thead>
                                        <tr style="border: 1px solid #dbe4ec; !important;">
                                            <th class="check">
                                                <input type="checkbox" name="chkDeleteAll" onclick="DeleteAllChk(this)" class="text-center">
                                            </th>
                                            <th class="text-center">파일명</th>
                                            <th class="capacity text-center">용량</th>
                                        </tr>
                                        </thead>
                                    </table>

                                    <!-- 첨부파일 없을때 -->
                                    <div class="dropbox" id="divDropArea" style="height: 110px;position: relative;">
                                        <div class="" style="position: absolute;top: 50%;left: 50%;transform: translate(-50%,-50%);">
                                            <span>첨부파일을 추가해주세요</span>
                                        </div>
                                    </div>

                                    <!-- 첨부파일 있을 때 -->
                                    <div class="file_list" id="divFileArea" style="">
                                        <div id="divFileTable" style="">
                                            <table id="uploadFileTable" width="100%" class="">
                                                <tbody>
                                                <tr>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div><!-- E://첨부파일 있을 때 -->
                                </div><!-- E://file_drag -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button form="form_modal_4" type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                    <button form="form_modal_4" type="button" class="btn btn-primary" id="btn_approval_attachment_modal_save">저장</button>
                </div>
            </div>
        </div>
    </div>
    <form id="form_modal_4" name="form_modal_4">
        <input type="hidden" id="modal_id_4" name="modal_id_4">
    </form>

    <div class="modal fade" id="modal_5" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">
                        업로드 파일 목록
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
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-ko-KR.js"></script>
    <script src="{{ asset('asset/js/plugins/jsTree/jstree.min.js') }}"></script>
    <script src="{{ asset('asset/js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    @include('approval.approvalWriteStep2_js')
@endsection
