@extends('layouts.default')

@section('head')
@endsection

@section('content')

    <div class="main-panel">
        <div class="panel-hedding">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h1>내 프로필</h1>

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
                        <form id="modal_form_1">
                            <div class="form-row">
                                <div class="avatar avatar-xlll d-block mx-auto mb-3">
                                    @if(Auth::user()->attachment)
                                        <img class="img-fluid" src="{{ Storage::url(Auth::user()->attachment)}}" alt="">
                                    @else
                                        <img class="img-fluid" src="asset/images/team/01.jpg" alt="">
                                    @endif
                                </div>

                                <div class="col-md-10 mb-3">
                                    <label for="attachment">프로필</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="attachment" name="attachment" accept="image/*">
                                        <label class="custom-file-label" for="attachment">파일업로드</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="user_code">아이디</label>
                                    <span class="badge badge-overlay-danger ml-2">필수</span>
                                    <input type="text" class="form-control" id="user_code" name="user_code" value="{{Auth::user()->user_code}}" placeholder="아이디" readonly autocomplete="off">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="user_password">비밀번호</label>
                                    <span class="badge badge-overlay-danger ml-2">필수</span>
                                    <input type="password" class="form-control" id="user_password" name="user_password" placeholder="비밀번호" required="" autocomplete="off">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="user_name">이름</label>
                                    <span class="badge badge-overlay-danger ml-2">필수</span>
                                    <input type="text" class="form-control" id="user_name" name="user_name" placeholder="이름" value="{{Auth::user()->user_name}}" required="" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="user_entry_date">입사일</label>
                                    <span class="badge badge-overlay-danger ml-2">필수</span>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="user_entry_date" name="user_entry_date" value="{{Auth::user()->entry_date}}" placeholder="입사일" readonly autocomplete="off">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="la la-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="user_email">이메일</label>
                                    <span class="badge badge-overlay-danger ml-2">필수</span>
                                    <input type="email" class="form-control" id="user_email" name="user_email" placeholder="이메일" value="{{Auth::user()->email}}" required="" autocomplete="off">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="user_phone">연락처</label>
                                    <span class="badge badge-overlay-danger ml-2">필수</span>
                                    <input type="text" class="form-control" id="user_phone" name="user_phone" placeholder="연락처" value="{{Auth::user()->phone}}" required="" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="department_id">부서</label>
                                    <span class="badge badge-overlay-danger ml-2">필수</span>
                                    <input type="text" class="form-control" id="department_id" name="department_id" value="{{Auth::user()->department}}" placeholder="부서" readonly autocomplete="off">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="position_id">직책</label>
                                    <span class="badge badge-overlay-danger ml-2">필수</span>
                                    <input type="text" class="form-control" id="position_id" name="position_id" placeholder="직책" value="{{Auth::user()->position}}" readonly autocomplete="off">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="user_zip_code">우편번호</label>
                                    <span class="badge badge-overlay-danger ml-2">필수</span>
                                    <input type="text" class="form-control" id="user_zip_code" name="user_zip_code" placeholder="우편번호" value="{{Auth::user()->zip_code}}" required="" autocomplete="off">
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label for="user_address">주소</label>
                                    <span class="badge badge-overlay-danger ml-2">필수</span>
                                    <input type="text" class="form-control" id="user_address" name="user_address" placeholder="주소" value="{{Auth::user()->address}}" required="" autocomplete="off">
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="button" class="btn btn-success" id="submit">정보수정</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    @include('mypage.profile_js')
@endsection
