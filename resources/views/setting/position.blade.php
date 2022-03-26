@extends('layouts.default')

@section('head')

@endsection

@section('content')
<div class="row">
        <div class="col-xl-12">
            <div id="ibox_1" class="ibox">
                <div class="ibox-title">
                    <h2>직책정보</h2>
                </div>

                <div class="ibox-content table-responsive">
                    <table class="table no-margins" id='dataTables_1' style="width: 100%">
                        <colgroup>
                            <col style="width:30%">
                            <col style="width:30%">
                            <col style="width:40%">
                        </colgroup>
                        <thead class="thead-themed">
                        <tr>
                            <th class='text-center' style=''>직책</th>
                            <th class='text-center' style=''>직책등급</th>
                            <th class='text-center' style=''>관리</th>
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
                        직책 등록
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                <div class="d-flex mb-3">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="position">직책</label></label><span class="badge badge-overlay-danger ml-2">필수</span>
                            <input form="form_modal" type="text" id="position" name="position" placeholder="직책" class="form-control" value="" require>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="position_grade">직책 등급</label></label><span class="badge badge-overlay-danger ml-2">필수</span>
                            <input form="form_modal" type="text" id="position_grade" name="position_grade" placeholder="직책등급" class="form-control" value="" require>
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

    <form id="form_modal" name="form_modal">
        <input type="hidden" id="modal_id" name="modal_id">
    </form>
@endsection

@section('script')
    @include('setting.position_js')
@endsection
