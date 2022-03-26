@extends('layouts.default')

@section('head')
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div id="ibox_1" class="ibox">
            <div class="ibox-title">
                <h3>회사정보</h3>
            </div>
            <div class="ibox-content">
                <div class="d-flex mb-3">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="logo">회사로고</label><span class="badge badge-overlay-danger ml-2">필수</span>

                            <div id='img_contain'>
                                <img class="img-fluid" id="blah" src="@if($company_data){{ $company_data->attachment }} @else /img/profile.png @endif" alt="" style="width: 150px; height: 150px;">
                            </div>

                            <div class="input-group mt-2">
                                <div class="custom-file">
                                    <input form="form_main" id="attach_file" name="attach_file[]" type="file" class="custom-file-input" accept="image/*">
                                    <label class="custom-file-label" for="attach_file">파일을 선택해주세요.</label>
                                </div>
                                <button class="btn btn-danger btn-sm" id="img_delete_btn" type="button" style="@if($company_data) @if(!$company_data->attachment) display: none; @endif @else @endif">삭제</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex mb-3">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="company_name">회사명</label><span class="badge badge-overlay-danger ml-2">필수</span>
                            <input form="form_main" type="text" id="company_name" name="company_name" placeholder="회사명" class="form-control" value="@if($company_data){{ $company_data->company_name }}@endif">
                        </div>
                    </div>
                </div>

                <div class="d-flex mb-3">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="position">등록 IP</label><span class="badge badge-overlay-danger ml-2">필수</span>
                            @if($company_data)
                                @foreach($company_data->ip_list as $item)
                                    <input form="form_main" type="text" name="ip_list[]" placeholder="IP" class="form-control mb-2" value="{{ $item }}">
                                @endforeach
                            @else
                                @for($i = 0; $i <= 4; $i++)
                                    <input form="form_main" type="text" name="ip_list[]" placeholder="IP" class="form-control mb-2" value="">
                                @endfor
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 text-right">
                        <button type="button" class="btn btn-primary btn-sm" id="btn_save">등록</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="form_main" name="form_main">
    <input type="hidden" id="id" name="id" value="@if($company_data){{ $company_data->id }}@endif">
</form>
@endsection

@section('modal')
@endsection

@section('script')
    <script src="{{ asset('asset/js/plugins/bs-custom-file/bs-custom-file-input.min.js') }}"></script>
    @include('setting.companyInfo_js')
@endsection
