@extends('layouts.default')

@section('head')
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div id="ibox_1" class="ibox">
                <div class="ibox-title">
                    <h3>임시저장함</h3>
                </div>
                <div class="ibox-content">
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
                                <th scope="col" class="text-center no_orderable">결재상태</th>
                                <th scope="col" class="text-center no_orderable">관리</th>
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

    <form id="form_main" name="form_main">
        <input type="hidden" id="id" name="id" value="">
    </form>
@endsection

@section('modal')
@endsection

@section('script')
    @include('approval.approvalTempList_js')
@endsection
