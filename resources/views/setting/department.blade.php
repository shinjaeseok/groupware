@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="col-xl-12">
            <div id="ibox_1" class="ibox">
                <div class="ibox-title">
                    <h3>부서정보</h3>
                </div>

                <div class="ibox-content table-responsive">

                    <table class="table no-margins" id='dataTables_1' style="width: 100%">
                        <colgroup>
                            <col style="">
                            <col style="width: 15%">
                        </colgroup>
                        <thead class="thead-themed">
                        <tr>
                            <th class='text-center' style=''>부서명</th>
                            <th class='text-center' style=''>관리</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <!-- datatable end -->

                    <div class="row">
                        <div class="col-xl-12 text-right">
                            <button type="button" class="btn btn-primary btn-sm" id="btn_create">최상위 부서 추가</button>
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
                        최상위 부서 추가
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>

                <div class="modal-body">

                    <div class="d-flex mb-1">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="modal_name">부서명</label><span class="badge badge-overlay-danger ml-2">필수</span>
                                <input form="form_modal" type="text" placeholder="부서명" id="modal_name" name="modal_name" class="form-control" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="modal_sort">정렬순서</label><span class="badge badge-overlay-danger ml-2">필수</span>
                                <input form="form_modal" type="text" placeholder="정렬순서" id="modal_sort" name="modal_sort" class="form-control" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex mb-1">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="modal_status">사용여부</label><span class="badge badge-overlay-danger ml-2">필수</span>
                                <select form="form_modal" id="modal_status" name="modal_status" class="form-control" style="width: 100%">
                                    <option value="Y">사용</option>
                                    <option value="N">미사용</option>
                                </select>
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
        <input type="hidden" id="modal_parent_id" name="modal_parent_id">
    </form>
@endsection

@section('script')
    @include('setting.department_js')
@endsection
