@extends('layouts.default')

@section('head')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection


@section('content')

    <div class="row">
        <div class="col-xl-12">
            <div id="ibox_1" class="ibox">
                <div class="ibox-title">
                    <h3>공지사항</h3>
                </div>

                <div class="ibox-content table-responsive">
                    <table class="table no-margins" id='dataTables_1' style="width: 100%">
                        <colgroup>
                            <col style="width:10%">
                            <col style="">
                            <col style="width:10%">
                            <col style="width:10%">
                            @if(Auth::user()->manager == 'Y')
                            <col style="width:10%">
                            @endif
                        </colgroup>
                        <thead class="thead-themed">
                        <tr>
                            <th class='text-center no_orderable' style=''>NO</th>
                            <th class='text-center no_orderable' style=''>제목</th>
                            <th class='text-center no_orderable' style=''>작성자</th>
                            <th class='text-center no_orderable' style=''>작성일</th>
                            @if(Auth::user()->manager == 'Y')
                            <th class='text-center no_orderable' style=''>관리</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <!-- datatable end -->

                    @if(Auth::user()->manager == 'Y')
                    <div class="row">
                        <div class="col-xl-12 text-right">
                            <button type="button" class="btn btn-primary btn-sm" id="btn_create">등록</button>
                        </div>
                    </div>
                    @endif
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
                        공지사항 등록
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>

                <div class="modal-body">
                    <div class="row mb-1">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label class="form-label" for="title">제목</label><span class="badge badge-overlay-danger ml-2">필수</span>
                                <input form="form_modal" type="text" placeholder="제목" id="title" name="title" class="form-control" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label class="form-label" for="contents">내용</label><span class="badge badge-overlay-danger ml-2">필수</span>
                                <textarea form="form_modal" id="contents" name="contents" class="form-control summernote" rows="15"></textarea>
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

    <div class="modal fade" id="modal_input_2" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">
                        공지사항
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>

                <div class="modal-body">
                    <div class="row mb-1">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label class="form-label" for="view_user_name">작성자</label>
                                <input form="form_modal" type="text" placeholder="작성자" id="view_user_name" name="view_user_name" class="form-control bg-white" autocomplete="off" disabled>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label class="form-label" for="view_created_at">작성일</label>
                                <input form="form_modal" type="text" placeholder="작성일" id="view_created_at" name="view_created_at" class="form-control bg-white" autocomplete="off" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-1">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label class="form-label" for="view_title">제목</label>
                                <input form="form_modal_2" type="text" placeholder="제목" id="view_title" name="view_title" class="form-control bg-white" autocomplete="off" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label class="form-label" for="view_contents">내용</label>
                                <div id="view_contents" class="form-control bg-white" style="height: 400px;" readonly></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button form="form_modal_2" type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                </div>
            </div>
        </div>
    </div>

    <form id="form_modal_2" name="form_modal_2">
        <input type="hidden" id="modal_id_2" name="modal_id_2">
    </form>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-ko-KR.js"></script>
    @include('setting.notice_js')
@endsection
