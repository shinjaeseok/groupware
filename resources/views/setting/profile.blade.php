@extends('layouts.default')

@section('head')

@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div id="ibox_1" class="ibox">
                <div class="ibox-title">
                    <h3>개인정보</h3>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-xl-3 border-right">
                            <div class="form-group">
                                <div class="row ml-1">
                                    <img class="rounded-circle img-lg" src="{{ $user_data->attachment }}">
                                    <div class="ml-3">
                                        <h3>
                                            <span class="font-bold" id="left_bar_user_name">{{Auth::user()->name}}</span>
                                        </h3>
                                        <h4>
                                            <span class="font-normal" id="left_bar_department_name">{{ $user_data->department_name }}</span>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-9">
                            <div class="row mt-2">
                                <div class="col-xl-12 mb-2">
                                    <button type="button" class="btn btn-default" id="btn_profile_file">프로필 사진 변경</button>
                                </div>
                            </div>

                            <hr>

                            <p class="font-bold">직무정보</p>
                            <div class="row mb-3">
                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <label class="form-label" for="employee_code">사원코드</label>
                                        <input form="form_main" type="text" id="employee_code" name="employee_code" placeholder="사원코드" class="form-control bg-white border-0" value="@if($user_data){{ $user_data->employee_code }}@endif" disabled>
                                    </div>
                                </div>

                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <label class="form-label" for="password">비밀번호</label>
                                        <div class="input-group">
                                            <input form="form_main" type="password" id="password" name="password" placeholder="비밀번호" class="form-control" value="">
                                            <span class="input-group-append"> <button type="button" class="btn btn-xs btn-default" id="password_check">변경</button></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <label class="form-label" for="department_name">부서</label>
                                        <input form="form_main" type="text" class="form-control bg-white border-0" placeholder="부서" id="department_name" name="department_name"  autocomplete="off" value="@if($user_data){{ $user_data->department_name }}@endif" disabled>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <label class="form-label" for="position_name">직책</label>
                                        <input form="form_main" type="text" class="form-control bg-white border-0" placeholder="직책" id="position_name" name="position_name"  autocomplete="off" value="@if($user_data){{ $user_data->position_name }}@endif" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <label class="form-label" for="join_state">상태</label>
                                        <input form="form_main" type="text" id="join_state" name="join_state" placeholder="상태" class="form-control bg-white border-0" value="@if($user_data->leave_date)퇴사@else재직@endif" disabled>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <label class="form-label" for="join_date">입사일</label>
                                        <input form="form_main" type="text" id="join_date" name="join_date" placeholder="입사일" class="form-control bg-white border-0" value="@if($user_data){{ $user_data->join_date }}@endif" disabled>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <p class="font-bold">개인정보</p>

                            <div class="row mb-3">

                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <label class="form-label" for="name">이름</label>
                                        <input form="form_main" type="text" id="name" name="name" placeholder="이름" class="form-control bg-white border-0" value="@if($user_data){{ $user_data->name }}@endif" disabled>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <label class="form-label" for="phone">연락처</label>
                                        <input form="form_main" type="text" class="form-control" data-mask="000-0000-0000" placeholder="연락처 입력" id="phone" name="phone"  autocomplete="off" maxlength="15" value="@if($user_data){{ $user_data->phone }}@endif">
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <label class="form-label" for="email">이메일</label>
                                        <input form="form_main" type="text" id="email" name="email" placeholder="이메일 입력" class="form-control" value="@if($user_data){{ $user_data->email }}@endif">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <label class="form-label" for="post">우편번호</label>
                                        <div class="input-group">
                                        <input form="form_main" type="text" class="form-control" placeholder="우편번호 입력" id="post" name="post"  autocomplete="off" value="@if($user_data){{ $user_data->post }}@endif">
                                            <span class="input-group-append"> <button type="button" class="btn btn-xs btn-default" onclick="sample2_execDaumPostcode()">우편번호찾기</button></span>
                                        </div>
                                    </div>
                                    <div id="layer" style="display:none;position:fixed;overflow:hidden;z-index:10;-webkit-overflow-scrolling:touch;">
                                        <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:10" onclick="closeDaumPostcode()" alt="닫기 버튼">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="form-label" for="address_1">주소</label>
                                        <input form="form_main" type="text" id="address_1" name="address_1" placeholder="주소 입력" class="form-control" value="@if($user_data){{ $user_data->address_1 }}@endif">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="form-label" for="address_2">상세주소</label>
                                        <input form="form_main" type="text" id="address_2" name="address_2" placeholder="상세주소 입력" class="form-control" value="@if($user_data){{ $user_data->address_2 }}@endif">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12 text-right">
                            <button type="button" class="btn btn-primary btn-sm" id="btn_save">수정</button>
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
    <div class="modal fade" id="modal_1" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">
                        비밀번호 변경
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>

                <div class="modal-body">

                    <div class="row mb-1">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label class="form-label" for="new_password">신규 비밀번호</label><span class="badge badge-overlay-danger ml-2">필수</span>
                                <input form="form_modal" type="password" placeholder="신규 비밀번호" id="new_password" name="new_password" class="form-control" value="" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label class="form-label" for="check_password">비밀번호 확인</label><span class="badge badge-overlay-danger ml-2">필수</span>
                                <input form="form_modal" type="password" placeholder="비밀번호 확인" id="check_password" name="check_password" class="form-control" value="" autocomplete="off">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button form="form_modal" type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                    <button form="form_modal" type="button" class="btn btn-primary" id="btn_modal_save">저장</button>
                </div>
            </div>
        </div>
    </div>

    <form id="form_modal" name="form_modal">
        <input type="hidden" id="modal_id" name="modal_id">
    </form>

    <div class="modal fade" id="modal_2" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">
                        프로필 사진 변경
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <img class="rounded-circle img-lg" id="blah" src="{{ $user_data->attachment }}" style="display: block; margin: 0px auto;">
                    </div>
                    <div class="row">
                        <div class="input-group mt-2">
                            <div class="custom-file">
                                <label class="custom-file-label" style="text-overflow: ellipsis; overflow: hidden;" for="attach_file">파일을 선택해주세요.</label>
                                <input form="form_modal_2" type="file" id="attach_file" name="attach_file[]" class="custom-file-input" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button form="form_modal_2" type="button" class="btn btn-danger" id="img_delete_btn" style="text-align: left !important;">삭제</button>
                    <button form="form_modal_2" type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                    <button form="form_modal_2" type="button" class="btn btn-primary" id="btn_modal_profile_file_save">저장</button>
                </div>
            </div>
        </div>
    </div>

    <form id="form_modal_2" name="form_modal_2">
        <input type="hidden" id="modal_id_2" name="modal_id_2">
    </form>
@endsection

@section('script')
    <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    @include('setting.profile_js')
@endsection
