@extends('layouts.default')

@section('head')
@endsection

@section('content')
    <div class="main-panel">
        <div class="panel-hedding">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h1>기안함</h1>
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
                        </div>

                        <div class="tab tab-outline">
                            <ul class="nav" id="myTab-02" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="approval-tab-01" data-toggle="tab" href="#dataTables_approval-01" role="tab" aria-controls="approval-01" aria-selected="true"> 전체</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="approval-tab-02" data-toggle="tab" href="#dataTables_approval-02" role="tab" aria-controls="approval-02" aria-selected="false"> 진행</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="approval-tab-03" data-toggle="tab" href="#dataTables_approval-03" role="tab" aria-controls="approval-03" aria-selected="false"> 완료</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="approval-tab-04" data-toggle="tab" href="#dataTables_approval-04" role="tab" aria-controls="approval-04" aria-selected="false"> 반려</a>
                                </li>
                            </ul>

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
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- 진행중 --}}
                                <div class="tab-pane fade show" id="dataTables_approval-02" role="tabpanel" aria-labelledby="approval-tab-02">
                                    <div class="table-responsive">
                                        <table class="table mb-0" id="dataTables_2">
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
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- 완료 --}}
                                <div class="tab-pane fade show" id="dataTables_approval-03" role="tabpanel" aria-labelledby="approval-tab-03">
                                    <div class="table-responsive">
                                        <table class="table mb-0" id="dataTables_3">
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
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- 반려 --}}
                                <div class="tab-pane fade show" id="dataTables_approval-04" role="tabpanel" aria-labelledby="approval-tab-04">
                                    <div class="table-responsive">
                                        <table class="table mb-0" id="dataTables_4">
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
                                            <tbody>

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

    {{-- todo:: 모달 사이즈 조절 --}}
    <div class="modal fade bd-example-modal-lg" id="modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">기안 열람</h5>
                    <span class="badge badge-danger ml-2 mt-1" id="modal_emergency_type">긴급</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="modal_form_1">
                        <input type="hidden" id="modal_id" name="modal_id">
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="approval_title">제목</label>
                                <input form="modal_form_1" type="text" class="form-control" id="modal_approval_title" name="modal_approval_title" placeholder="제목" value="" autocomplete="off" disabled>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-3 mb-3">
                                <label for="approval_writer_user">기안자</label>
                                <input form="modal_form_1" type="text" class="form-control" id="modal_approval_writer_user" name="modal_approval_writer_user" placeholder="기안자" required="" autocomplete="off" disabled>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="approval_writer_user_department">기안부서</label>
                                <input form="modal_form_1" type="text" class="form-control" id="modal_approval_writer_user_department" name="modal_approval_writer_user_department" placeholder="기안부서" value="" required="" autocomplete="off" disabled>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="approval_date">기안일</label>
                                <div class="input-group">
                                    <input form="modal_form_1" type="text" class="form-control date_picker" id="modal_approval_date" name="modal_approval_date" placeholder="기안일" required="" autocomplete="off" disabled>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="la la-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="approval_date">합의구분</label>
                                <div class="input-group">
                                    <select form="modal_form_1" class="input-group select_box" name="modal_agreement_type" id="modal_agreement_type" disabled>
                                        <option value="병렬">병렬합의</option>
                                        <option value="순차">순차합의</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <div id="accordionExample">
                                <label for="">결재선</label>
                                    <button type="button" class="btn btn-info btn-sm ml-1"  data-toggle="collapse" data-target="#collapseOne" aria-expanded="true">보기</button>
                                </div>
                            </div>
                        </div>

                        <div id="collapseOne" class="collapse" data-parent="#accordionExample" style="">
                            <div class="form-row collapse show" id="#collapseOne" data-parent="#accordionExample">
                                <div class="table-responsive">
                                    <table class="table table-centered table-hover mb-3">
                                        <thead>
                                        <tr class="text-center">
                                            <th style="width:50px;" scope="col">순서</th>
                                            <th style="width:200px;" scope="col">결재구분</th>
                                            <th style="" scope="col">결재자</th>
                                            <th style="width:100px;" scope="col">승인결과</th>
                                        </tr>
                                        </thead>
                                        <tbody id="sub_list"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="approval_contents">내용</label>
                                <div id="modal_contents_view" class="p-sm white-bg table-bordered" style="min-height: 200px;"></div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="attach_file_down">첨부파일</label>
                                <div class="custom-file" id="attach_file_down"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('approval.write.approval_write_list_js')
@endsection
