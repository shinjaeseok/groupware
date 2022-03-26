@extends('layouts.default')

@section('head')
@endsection
@section('content')
    <div class="main-panel">

        <div class="panel-hedding">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h1>기안작성</h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-title">
                        <div class="card-title-left">
                            <button type="submit" class="btn btn-light btn-sm mr-1" formaction="/approval_write/temp_store">임시저장</button>
                            <button type="submit" class="btn btn-primary btn-sm mr-1" formaction="/approval_write/store">기안상신</button>
                            <button type="button" class="btn btn-info btn-sm mr-1" onclick="documentSetting();"><i class="zmdi zmdi-assignment"></i>문서정보</button>
                            <button type="button" class="btn btn-info btn-sm mr-1" onclick="approvalSetting();"><i class="zmdi zmdi-device-hub"></i>결재선</button>
                            <button type="button" class="btn btn-info btn-sm mr-1" onclick="approvalComment();"><i class="zmdi zmdi-comments"></i>의견</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="modal_form_1" method="post" onsubmit="return submitCheck();" enctype="multipart/form-data">
                            @csrf

                            <div class="form-row">
                                <div class="col-md-3 mb-3">
                                    <label for="approval_writer_user">작성자</label>
                                    <p class="form-control" id="approval_writer_user">{{ Auth::user()->user_name }}</p>
                                    {{--<input form="modal_form_1" type="text" class="form-control" id="approval_writer_user" name="approval_writer_user" placeholder="기안자" value="{{ Auth::user()->user_name }}" autocomplete="off">--}}
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="approval_writer_user_department">작성부서</label>
                                    <p class="form-control" id="approval_writer_user_department">{{ Auth::user()->department }}</p>
                                    {{--<input form="modal_form_1" type="text" class="form-control" id="approval_writer_user_department" name="approval_writer_user_department" placeholder="기안부서" value="{{ Auth::user()->department }}" autocomplete="off">--}}
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="approval_date">기안일자</label>
                                    <div class="input-group">
                                        <p class="form-control" id="approval_date">{{ date('Y-m-d') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="approval_title">제목</label>
                                    <span class="badge badge-overlay-danger ml-2">필수</span>
                                    <input form="modal_form_1" type="text" class="form-control" id="approval_title" name="approval_title" placeholder="제목" value="" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-3 mb-3">
                                    <label for="approval_document_id">기안 양식</label>
                                    <select form="modal_form_1" class="input-group select_box" name="approval_document_id" id="approval_document_id">
                                        <option value="">선택</option>
                                        <option value="1">양식1</option>
                                        <option value="2">양식2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="approval_contents">내용</label>
                                    <span class="badge badge-overlay-danger ml-2">필수</span>
                                    <div class="document-editor">
                                        <div class="document-editor__toolbar"></div>
                                        <div class="document-editor__editable-container">
                                            <div class="document-editor__editable"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @for ( $i = 0; $i < 2; $i++ )
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <div class="custom-file">
                                        <input form="modal_form_1" type="file" class="custom-file-input attach_file" name="attach_file[]">
                                        <label class="custom-file-label" for="attach_file"></label>
                                    </div>
                                </div>
                            </div>
                            @endfor

                            <div class="text-center">
                                {{--<button class="btn btn-outline-light outline-2px" type="submit" formaction="/approval_write/temp_store">저장</button>--}}
                                {{--<button class="btn btn-primary" type="submit" formaction="/approval_write/store">기안상신</button>--}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="exampleModalLabel">문서정보</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="modal_form_1">

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
                                            <select form="modal_form_1" name='send_type' class='input-group search_false_select_box'>
                                                <option value="내부" selected>내부</option>
                                                <option value="외부">외부</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bg-bg-light-overlay">긴급유무</td>
                                        <td>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="emergency_type_1" name="emergency_type" class="custom-control-input" value="N" checked>
                                                <label class="custom-control-label" for="emergency_type_1">일반</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="emergency_type_2" name="emergency_type" class="custom-control-input" value="Y">
                                                <label class="custom-control-label" for="emergency_type_2">긴급</label>
                                            </div>
                                        </td>
                                        <td class="bg-bg-light-overlay">보존년한</td>
                                        <td>
                                            <select form="modal_form_1" name='document_life' id="document_life" class='input-group search_false_select_box'>
                                                <option value="0" selected>영구</option>
                                                <option value="10" >10년</option>
                                                <option value="5" >5년</option>
                                                <option value="3" >3년</option>
                                                <option value="1" >1년</option>
                                            </select>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button form="form_modal" type="button" class="btn btn-light" data-dismiss="modal">닫기</button>
                    <button form="form_modal" type="button" class="btn btn btn-primary btn_document_setting_save">확인</button>
                </div>
            </div>
        </div>
    </div>
    <form id="form_modal" name="form_modal">
        <input type="hidden" id="modal_id" name="modal_id">
    </form>

    <div class="modal fade" id="modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="exampleModalLabel">결재선</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="modal_form_2">

                        <div class="form-row">

                            <div class="col-md-6 mb-3">
                                <label class="font-md">조직도</label>
                                <div class="card" style="margin-bottom: 0px;">
                                    <div class="card-title border-bottom">
                                        <div class="col-md-4">
                                            <select form="modal_form_1" name='search_key' id="search_key" class='input-group search_false_select_box'>
                                                <option value="">선택</option>
                                                <option value="user_name" >이름</option>
                                                <option value="department" >부서</option>
                                            </select>
                                        </div>

                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="search_value" name="search_value" placeholder="검색어" aria-label="Recipient's username" aria-describedby="button-addon2">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-sm btn-primary" id="btn_search">검색</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">

                                        <div id="tree" class="mb-3">

                                        </div>

                                        <div>
                                            <table class="table table-centered mb-3" id="dataTables_1">
                                                <colgroup>
                                                    <col style="width: 100px;">
                                                    <col style="width: 150px;">
                                                    <col style="width: 100px;">
                                                    <col style="width: 100px;">
                                                    <col style="width: 100px;">
                                                </colgroup>
                                                <thead>
                                                <tr class="text-center">
                                                    <th scope="col">프로필</th>
                                                    <th scope="col">부서</th>
                                                    <th scope="col">이름</th>
                                                    <th scope="col">직책</th>
                                                    <th scope="col">관리</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-md">결재선</label>
                                <div class="card">
                                    <div class="card-title">

                                        <div class="col-sm-4"></div>
                                        <label class="col-sm-4 col-form-label text-right">합의방식</label>
                                        <div class="col-sm-4">
                                            <select form="modal_form_2" name='agreement_type' id="agreement_type" class='input-group search_false_select_box'>
                                                <option value="병렬" >병렬합의</option>
                                                <option value="순차" >순차합의</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="card-body">

                                        <table class="table table-centered mb-3">
                                            <colgroup>
                                                <col style="width: 100px;">
                                                <col style="width: 150px;">
                                                <col style="width: 100px;">
                                            </colgroup>
                                            <thead>
                                            <tr class="text-center">
                                                <th scope="col">결재방법</th>
                                                <th scope="col">결재자</th>
                                                <th scope="col">관리</th>
                                            </tr>
                                            </thead>

                                            <tbody id="approval_user_list">
                                                <tr id="empty_text">
                                                    <td class="text-center" colspan="3">결재자를 선택해주세요.</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button form="form_modal_2" type="button" class="btn btn-light" data-dismiss="modal">닫기</button>
                    <button form="form_modal_2" type="button" class="btn btn btn-primary btn_approval_setting_save">확인</button>
                </div>
            </div>
        </div>
    </div>
    <form id="form_modal_2" name="form_modal_2">
        <input type="hidden" id="modal_id_2" name="modal_id_2">
    </form>

    <div class="modal fade" id="modal_3" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="exampleModalLabel">의견</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="modal_form_3">
                        <textarea form="modal_form_3" id="approval_comment" name="approval_comment" class="form-control input-sm">
                        </textarea>
                    </form>
                </div>
                <div class="modal-footer">
                    <button form="form_modal_3" type="button" class="btn btn-light" data-dismiss="modal">닫기</button>
                    <button form="form_modal_3" type="button" class="btn btn btn-primary btn_approval_comment_save">확인</button>
                </div>
            </div>
        </div>
    </div>
    <form id="form_modal_3" name="form_modal_3">
        <input type="hidden" id="modal_id_3" name="modal_id_3">
    </form>

@endsection

@section('script')
    <script src="asset/js/jstree/jstree.min.js"></script>
    <script src="asset/js/jstree/custom-jstree.js"></script>
    @include('approval.write.approval_write_page_js')
@endsection
