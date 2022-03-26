@extends('layouts.default')

@section('head')
@endsection

@section('content')
    <div class="main-panel">
        <div class="panel-hedding">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h1>임시저장함</h1>
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
                                {{-- 전체 --}}
                                <div class="tab-pane fade show active" id="dataTables_approval-01" role="tabpanel" aria-labelledby="approval-tab-01">
                                    <div class="table-responsive">
                                        <table class="table mb-0" id="dataTables_1">
                                            <colgroup>
                                                <col style="width: 70px;">
                                                <col style="width: 150px;">
                                                <col style="width: 150px;">
                                                <col style="width: 100px;">
                                                <col style="">
                                                <col style="width: 150px;">
                                                <col style="width: 150px;">
                                                <col style="width: 150px;">
                                            </colgroup>
                                            <thead>
                                            <tr>
                                                <th scope="col" class="text-center">NO</th>
                                                <th scope="col" class="text-center">기안일</th>
                                                <th scope="col" class="text-center">결재양식</th>
                                                <th scope="col" class="text-center">긴급</th>
                                                <th scope="col" class="text-center">제목</th>
                                                <th scope="col" class="text-center">첨부</th>
                                                <th scope="col" class="text-center">문서번호</th>
                                                <th scope="col" class="text-center">결재상태</th>
                                            </tr>
                                            </thead>
                                            <tbody style="cursor: pointer;">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('approval.temp.approval_temp_list_js')
@endsection
