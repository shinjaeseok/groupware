@extends('layouts.default')

@section('head')
@endsection
@section('content')
    <div class="main-panel">

        <div class="panel-hedding">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h1>기안 양식 선택</h1>
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
                        <div class="form-row">

                            <div class="col-md-6 mb-3">
                                <label class="font-md">기안양식</label>
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
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-md">미리보기</label>
                                <div class="card">
                                    <div class="card-title">
                                    </div>
                                    <div class="card-body">

                                        <div class="contents">

                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <input type="hidden" id="document_id" name="document_id">

                    <div class="card-footer">
                        <button class="btn btn-primary" type="button">선택</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="asset/js/jstree/jstree.min.js"></script>
    <script src="asset/js/jstree/custom-jstree.js"></script>
    @include('approval.write.approval_document_select_js')
@endsection
