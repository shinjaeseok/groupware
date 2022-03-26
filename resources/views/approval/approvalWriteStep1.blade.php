@extends('layouts.default')

@section('head')

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
                        <div class="col-lg-6 col-12">
                            <div id="ibox_1" class="ibox">
                                <div class="ibox-title">
                                    <h3>기안 양식 선택</h3>
                                </div>
                                <div class="ibox-content table-responsive">
                                    <table class="table no-margins" id='dataTables_1' style="width: 100%">
                                        <colgroup>
                                            <col style="width: 10%">
                                            <col style="width: 15%">
                                            <col style="">
                                            <col style="width: 15%">
                                            <col style="width: 10%">
                                        </colgroup>
                                        <thead class="thead-themed">
                                        <tr>
                                            <th class='text-center' style=''>번호</th>
                                            <th class='text-center' style=''>양식구분</th>
                                            <th class='text-center' style=''>제목</th>
                                            <th class='text-center' style=''>등록일</th>
                                            <th class='text-center' style=''>선택</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-6 col-12">

                            <div id="ibox_1" class="ibox">
                                <div class="ibox-title">
                                    <h3>미리보기</h3>
                                </div>
                                <div class="ibox-content">

                                    <div class="d-flex mb-3">
                                        <div class="col-lg-12">
                                            <div class="mt-4" id="document_preview"><span class="font-bold">기안 양식을 선택해주세요.</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12 text-right">
                            <button type="button" class="btn btn-primary btn-sm" id="btn_save">선택</button>
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
@endsection

@section('script')
    @include('approval.approvalWriteStep1_js')
@endsection
