@extends('layouts.default')

@section('head')
@endsection

@section('content')
    <div class="main-panel">

        <div class="panel-hedding">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h1>기안작성</h1>
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
                        <form id="modal_form_1" method="post" onsubmit="return submitCheck();" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-9 mb-3">
                                    <label for="approval_title">제목</label>
                                    <span class="badge badge-overlay-danger ml-2">필수</span>
                                    <input form="modal_form_1" type="text" class="form-control" id="approval_title" name="approval_title" placeholder="제목" value="{{ $approval->title }}" autocomplete="off">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="custom-control custom-checkbox d-inline-block" style="padding-top:2.5rem;">
                                        <input type="checkbox" class="custom-control-input" name="emergency_type" id="emergency_type">
                                        <label class="custom-control-label" for="emergency_type">긴급결재</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-3 mb-3">
                                    <label for="approval_writer_user">기안자</label>
                                    <span class="badge badge-overlay-danger ml-2">필수</span>
                                    <input form="modal_form_1" type="text" class="form-control" id="approval_writer_user" name="approval_writer_user" placeholder="기안자" value="{{ Auth::user()->user_name }}" autocomplete="off">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="approval_writer_user_department">기안부서</label>
                                    <span class="badge badge-overlay-danger ml-2">필수</span>
                                    <input form="modal_form_1" type="text" class="form-control" id="approval_writer_user_department" name="approval_writer_user_department" placeholder="기안부서" value="{{ Auth::user()->department }}" autocomplete="off">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="approval_date">기안일</label>
                                    <span class="badge badge-overlay-danger ml-2">필수</span>
                                    <div class="input-group">
                                        <input form="modal_form_1" type="text" class="form-control date_picker" id="approval_date" name="approval_date" placeholder="기안일" value="{{ $approval->approval_date }}" autocomplete="off">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="la la-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="approval_date">합의구분</label>
                                    <span class="badge badge-overlay-danger ml-2">필수</span>
                                    <div class="input-group">
                                        <select form="modal_form_1" class="input-group search_false_select_box" name="agreement_type" id="agreement_type">
                                            <option value="병렬" @if($approval->agreement_type == '병렬') selected @endif>병렬합의</option>
                                            <option value="순차"  @if($approval->agreement_type == '순차') selected @endif>순차합의</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{--<div class="form-row">--}}
                            {{--    <div class="col-md-6 mb-3">--}}
                            {{--        <button type="button" class="btn btn-info btn-sm" onclick="modal_approval_line_reg();">결재선 등록</button>--}}
                            {{--    </div>--}}
                            {{--</div>--}}

                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="">결재선</label>
                                    <span class="badge badge-overlay-danger ml-2 mr-3">필수</span>
                                    <button type="button" class="btn btn-info btn-sm btn_row_insert">추가</button>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="table-responsive">
                                    <table class="table table-centered table-hover mb-3">
                                        <thead>
                                        <tr class="text-center">
                                            <th style="width:50px;" scope="col">순서</th>
                                            <th style="width:200px;" scope="col">결재구분</th>
                                            <th style="" scope="col">결재자</th>
                                            <th style="width:100px;" scope="col">관리</th>
                                        </tr>
                                        </thead>

                                        <tbody id="sub_list">
                                        @foreach($approval_items as $item )
                                            <tr>
                                                <td style='text-align: center;'><span class='sort'>{{$item->sort}}</span></td>
                                                <td>
                                                    <select form="modal_form_1" name='approval_type[]' class='input-group search_false_select_box'>
                                                        <option value="전결" @if($item->approval_type == '전결') selected @endif>전결</option>
                                                        <option value="결재" @if($item->approval_type == '결재') selected @endif>결재</option>
                                                        <option value="합의" @if($item->approval_type == '합의') selected @endif>합의</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select form="modal_form_1" name='approval_user_id[]' class='input-group approval_user_id select_box'>
                                                        <option value="">선택</option>
                                                        @foreach($user_list as $user)
                                                            <option value="{{ $user->id }}" {{ ($user->id == $item->fk_user_id) ? 'selected' : '' }}>
                                                                {{ $user->user_name }} ({{ $user->position }} | {{ $user->department }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="text-center"><a class="btn btn-danger btn-icon btn-sm mb-1 btn_delete_row"><i class="fa fa-trash-o"></i></a></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-3 mb-3">
                                    <label for="approval_document_id">기안 양식</label>
                                    <select form="modal_form_1" class="input-group select_box" name="approval_document_id" id="approval_document_id">
                                        <option value="">선택</option>
                                        <option value="1">양식1</option>
                                        <option value="2">양식2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="approval_contents">내용</label>
                                    <span class="badge badge-overlay-danger ml-2">필수</span>
                                    <textarea form="modal_form_1" id="approval_contents" name="approval_contents" class="form-control input-sm summernote" autocomplete="off">
                                    </textarea>
                                </div>
                            </div>

                            @for ( $i = 0; $i < 2; $i++ )
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <div class="custom-file">
                                        <input form="modal_form_1" type="file" class="custom-file-input" name="attach_file[]">
                                        <label class="custom-file-label" for="attach_file"></label>
                                    </div>
                                </div>
                            </div>
                            @endfor

                            <div class="text-center">
                                {{--<button class="btn btn-outline-light outline-2px" type="button" id="temp_save">임시저장</button>--}}
                                <button class="btn btn-outline-light outline-2px" type="submit" formaction="/approval_temp_store">임시저장</button>
                                <button class="btn btn-primary" type="submit" formaction="/approval_store">기안등록</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('approval.temp.approval_temp_write_js')
@endsection
