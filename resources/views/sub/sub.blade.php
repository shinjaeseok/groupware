@extends('layouts.default')

@section('head')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection

@section('content')


    <div class="row">
        <div class="col-xl-12">
            <div id="ibox_1" class="ibox">
                <div class="ibox-title">
                    <h3>테이블</h3>
                </div>

                <div class="ibox-content table-responsive">

                    <div class="row mb-2">
                        <div class="col-sm-8">
                        </div>
                        <div class="col-sm-2">
                            <select form="form_main" id="srch_key" name="srch_key" class="form-control">
                                <option value="title">제목</option>
                                <option value="contents">내용</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <input form="form_main" type="text" id="srch_keyword" name="srch_keyword" placeholder="검색어" class="form-control">
                                <span class="input-group-btn">
                                    <button form="form_main" type="submit" class="btn btn-sm btn-primary">검색</button>
                                    {{--<button form="form_main" type="button" class="btn btn-sm btn-default" onclick="location.reload();">초기화</button>--}}
                                </span>
                            </div>
                        </div>
                    </div>

                    <table class="table no-margins" id='dataTables_1' style="width: 100%">
                        <colgroup>
                            <col style="width: 50px">
                            <col style="width: 100px">
                            <col style="width: 250px">
                            <col style="">
                            <col style="width: 150px">
                            <col style="width: 150px">
                            <col style="width: 150px">
                        </colgroup>
                        <thead class="thead-themed">
                        <tr>
                            <th class='text-center no_orderable' style=''>번호</th>
                            <th class='text-center no_orderable' style=''>구분</th>
                            <th class='text-center no_orderable' style=''>제목</th>
                            <th class='text-center no_orderable' style=''>내용</th>
                            <th class='text-center no_orderable' style=''>작성자</th>
                            <th class='text-center no_orderable' style=''>등록일</th>
                            <th class='text-center no_orderable' style=''>관리</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <!-- datatable end -->

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
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">
                        모달 등록
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>

                <div class="modal-body">

                    <div class="d-flex mb-1">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label" for="division">구분</label>
                                <div>
                                    <select form="form_modal" id="division" name="division" class="form-control" style="width: 100%">
                                        <option value="">선택</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label" for="date">날짜</label>
                                <input form="form_modal" type="text" placeholder="날짜" id="date" name="date" class="form-control datepicker" value="{{ date('Y-m-d') }}" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex mb-1">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label" for="title">제목</label><span class="badge badge-overlay-danger ml-2">필수</span>
                                <input form="form_modal" type="text" placeholder="제목" id="title" name="title" class="form-control" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex mb-1">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label" for="contents">내용</label>
                                <textarea form="form_modal" id="contents" name="contents" class="form-control"></textarea>
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
    @include('sub.sub_js')
@endsection
