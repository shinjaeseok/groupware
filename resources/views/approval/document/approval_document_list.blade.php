@extends('layouts.default')

@section('head')
@endsection

@section('content')
    <div class="main-panel">
        <div class="panel-hedding">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h1>문서대장</h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-title">
                        <div class="card-title-left">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="search-box mb-3">
                            <div class="row">
                                <div class="col-md-7 col-xl-7">
                                </div>
                                <div class="col-md-2 col-xl-2">
                                    <select for="form_main" class='custom-select select_box' name="search_type" id="search_type">
                                        <option value=''>선택</option>
                                        <option value='title' @if(Request::get("search_type") == "title") selected @endif>제목</option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-xl-3">
                                    <div class="search">
                                        <div class="input-group ">
                                            <input for="form_main" type="text" class="form-control" name="search_value" id="search_value" placeholder="검색어" value="{{Request::get("search_value")}}" aria-label="Recipient's username" aria-describedby="button-addon2" autocomplete="off">
                                            <div class="input-group-append">
                                                {{-- todo:: form 전송 변경? 검색 방법 구상--}}
                                                <button for="form_main" class="btn btn-outline-primary" type="button" id="search_btn">검색</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab tab-outline">
                                <div class="tab-content">
                                    <div class="table-responsive">
                                        <table class="table mb-0" id="dataTables_1">
                                            <colgroup>
                                                <col style="width: 70px;">
                                                <col style="width: 70px;">
                                                <col style="width: 150px;">
                                                <col style="">
                                                <col style="width: 150px;">
                                            </colgroup>
                                            <thead>
                                            <tr>
                                                <th scope="col" class="text-center"></th>
                                                <th scope="col" class="text-center">NO</th>
                                                <th scope="col" class="text-center">문서</th>
                                                <th scope="col" class="text-center">제목</th>
                                                <th scope="col" class="text-center">관리</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-danger btn-sm" id="btn_delete_batch">선택 삭제</button>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="button" class="btn btn-primary" id="btn_create">등록</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">문서 양식 작성</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="modal_form_1">
                        <div class="form-row">
                            <div class="col-md-12 mb-12">
                                <label for="modal_title">제목</label>
                                <span class="badge badge-overlay-danger ml-2">필수</span>
                                <input type="text" form="form_modal" class="form-control" id="modal_title" name="modal_title" placeholder="제목" required="" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-3 mb-3">
                                <label for="modal_document_type">문서구분</label>
                                <div class="input-group">
                                    <select form="form_modal" class="input-group select_box" name="modal_document_type" id="modal_document_type">
                                        <option value="기본">기본</option>
                                        <option value="A">A</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{--<div class="form-row">--}}
                        {{--    <div class="col-md-12 mb-12">--}}
                        {{--        <label for="modal_contents">내용</label>--}}
                        {{--        <span class="badge badge-overlay-danger ml-2">필수</span>--}}
                        {{--        <textarea type="text" form="form_modal" class="form-control summernote" id="modal_contents" name="modal_contents"></textarea>--}}
                        {{--    </div>--}}
                        {{--</div>--}}


                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="approval_contents">내용</label>
                                <span class="badge badge-overlay-danger ml-2">필수</span>
                                <div class="document-editor">
                                    <div class="document-editor__toolbar"></div>
                                    <div class="document-editor__editable-container">
                                        <div class="document-editor__editable" id="modal_contents" name="modal_contents"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button form="form_modal" type="button" class="btn btn-light" data-dismiss="modal">닫기</button>
                    <button form="form_modal" type="submit" class="btn btn-success">저장</button>
                </div>
            </div>
        </div>
    </div>

    <form id="form_modal" name="form_modal">
        <input type="hidden" id="modal_id" name="modal_id">
    </form>

    <div class="modal fade bd-example-modal-lg" id="modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">문서양식</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="modal_form_1">
                        <div class="form-row">
                            <div class="col-md-12 mb-12">
                                <label for="modal_title_view">제목</label>
                                <span class="badge badge-overlay-danger ml-2">필수</span>
                                <input type="text" form="form_modal" class="form-control" id="modal_title_view" name="modal_title_view" placeholder="제목" required="" autocomplete="off" readonly>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-3 mb-3">
                                <label for="modal_document_type_view">문서구분</label>
                                <div class="input-group">
                                    <select form="form_modal" class="input-group select_box" name="modal_document_type_view" id="modal_document_type_view" disabled>
                                        <option value="기본">기본</option>
                                        <option value="A">A</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-12 mb-12">
                                <label for="modal_contents_view">내용</label>
                                <span class="badge badge-overlay-danger ml-2">필수</span>
                                <div class="form-control" id="modal_contents_view" style="min-height: 200px;"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button form="form_modal" type="button" class="btn btn-light" data-dismiss="modal">닫기</button>
                    {{--<button form="form_modal" type="submit" class="btn btn-success">저장</button>--}}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    @include('approval.document.approval_document_list_js')
@endsection
