@extends('layouts.default')

@section('head')
<!-- fullcalendar CDN -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.min.css' rel='stylesheet' />
<link rel="stylesheet" href="/css/colorPick.min.css"/>

@endsection


@section('content')
<div class="row">
    <div class="col-xl-12">
        <div id="ibox_1" class="ibox">
            <div class="ibox-title">
                <h3>일정</h3>
            </div>
            {{-- todo: checkbox로 캘린더 구분 작업중 --}}
            <div class="ibox-content">
                <div class="row ">
                    <div class="col-xl-2 mb-3">
                        <div class="row mb-3">
                            <button class="btn btn-primary full-width" id="btn_calendar" type="button">일정등록</button>
                        </div>

                        <div class="" style="z-index:99;">
                            <ul class="nav metismenu">
                                <li class=" nav-border-bottom">
                                    <input id="check_all" type="checkbox" class="check_all" checked>
                                    <label class="mt-2"  for="check_all" style="cursor:pointer;">전체 캘린더</label>
                                </li>
                            </ul>
                        </div>

                        <div class="" style="z-index:99;">
                            <ul class="nav metismenu">
                                <li class="nav-border-bottom">
                                    <input class="check_all_com all" id="check_all_com" type="checkbox" checked>
                                    <label class="mt-2" for="check_all_com" style="cursor:pointer;">&nbsp;사내캘린더</label>
                                    <div class="float-right">
                                    <i class="fa fa-plus mt-3" style="cursor: pointer;" onclick="addCalender('com')"></i>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="calendar_category_inHouse" style="z-index:99;">
                            <ul class="nav metismenu calendar_list" id="calendarList">
                                @foreach ($system_com_data as $item)
                                <li class="nav-border-bottom" title="{{ $item->title }}">
                                    <input class="cs com_calendar all" style="vertical-align: middle;" id="calendarIdComm{{$item->id}}" name="calendarId" value="{{$item->id}}" type="checkbox" checked>
                                    <label for="calendarIdComm{{$item->id}}" style="cursor: pointer;">&nbsp;{{ $item->title }}</label>
                                    <span class="calendar_box" style="background-color:{{ $item->color }};"></span>
                                </li>
                                @endforeach
                                @foreach ($com_data as $item)
                                    <li class="nav-border-bottom" title="{{ $item->title }}">
                                        <input class="cs com_calendar all" onclick="" id="calendarIdComm{{$item->id}}" name="calendarId" value="{{$item->id}}" type="checkbox" checked>
                                        <label for="calendarIdComm{{$item->id}}" style="cursor: pointer;">&nbsp;{{ $item->title }}</label>
                                        <input type="hidden" id="cal5138" value="system">
                                        <span class="calendar_box" style="background-color:{{ $item->color }};"></span>
                                        <div class="float-right">
                                            <i class="fa fa-cog" style="cursor: pointer;" onclick="detailCalender({{$item->id}})"></i>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="calendar_add_my" style="z-index:99;">
                            <ul class="nav metismenu">
                                <li>
                                    <input class="check_all_my all" id="check_all_my" type="checkbox" checked>
                                    <label class="mt-2" for="check_all_my" style="cursor:pointer;">&nbsp;마이캘린더</label>
                                    <i class="fa fa-plus" style="cursor: pointer;" onclick="addCalender('my')"></i>
                                </li>
                            </ul>
                        </div>

                        <div class="calendar_category_my">
                            <ul class="nav metismenu calendar_list" id="myCalendarList">
                                @foreach ($my_com_data as $item)
                                    <li class="nav-border-bottom" title="내 캘린더">
                                        <input class="cs my_calender all" onclick="" id="calendarId{{$item->id}}" name="calendarId" value="{{$item->id}}" type="checkbox" checked>
                                        <label for="calendarId{{$item->id}}" style="cursor: pointer;">&nbsp;{{$item->title}}</label>
                                        <span class="calendar_box" style="background-color:{{ $item->color }};"></span>
                                    </li>
                                @endforeach

                                @foreach ($my_data as $item)
                                    <li class="nav-border-bottom" title="내 캘린더">
                                        <input class="cs my_calender all" onclick="" id="calendarId{{$item->id}}" name="calendarId" value="{{$item->id}}" type="checkbox" checked>
                                        <label for="calendarId{{$item->id}}" style="cursor: pointer;">&nbsp;{{$item->title}}</label>
                                        <span class="calendar_box" style="background-color:{{ $item->color }};"></span>
                                        <div class="float-right">
                                            <i class="fa fa-cog" style="cursor: pointer;" onclick="detailCalender({{$item->id}})"></i>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="col-xl-10">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<!-- Modal Window -->
<div class="modal fade" id="modal_input" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="modal_title">
                    일정 등록
                </h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <div class="row mb-1">
                    <div class="col-xl-9">
                        <div class="form-group" id="data_5">
                            <label class="font-normal">일자</label><span class="badge badge-overlay-danger ml-2">필수</span>
                            <div class="input-daterange input-group" id="datepicker">
                                <input type="text" class="form-control datepicker" id="start_date" name="start_date">
                                <select class="form-control" id="start_time" onchange="" style="height: calc(1.5em + 0.75rem + 2px);" disabled>
                                    <option value="09:00" selected>09:00</option>
                                    <option value="09:30">09:30</option>
                                    <option value="10:00">10:00</option>
                                    <option value="10:30">10:30</option>
                                    <option value="11:00">11:00</option>
                                    <option value="11:30">11:30</option>
                                    <option value="12:00">12:00</option>
                                    <option value="12:30">12:30</option>
                                    <option value="13:00">13:00</option>
                                    <option value="13:30">13:30</option>
                                    <option value="14:00">14:00</option>
                                    <option value="14:30">14:30</option>
                                    <option value="15:00">15:00</option>
                                    <option value="15:30">15:30</option>
                                    <option value="16:00">16:00</option>
                                    <option value="16:30">16:30</option>
                                    <option value="17:00">17:00</option>
                                    <option value="17:30">17:30</option>
                                    <option value="18:00">18:00</option>
                                    <option value="18:30">18:30</option>
                                </select>
                                <span class="input-group-addon">to</span>
                                <input type="text" class="form-control datepicker" id="end_date" name="end_date">
                                <select class="form-control" id="end_time" onchange="" style="height: calc(1.5em + 0.75rem + 2px);" disabled>
                                    <option value="09:30">09:30</option>
                                    <option value="10:00">10:00</option>
                                    <option value="10:30">10:30</option>
                                    <option value="11:00">11:00</option>
                                    <option value="11:30">11:30</option>
                                    <option value="12:00">12:00</option>
                                    <option value="12:30">12:30</option>
                                    <option value="13:00">13:00</option>
                                    <option value="13:30">13:30</option>
                                    <option value="14:00">14:00</option>
                                    <option value="14:30">14:30</option>
                                    <option value="15:00">15:00</option>
                                    <option value="15:30">15:30</option>
                                    <option value="16:00">16:00</option>
                                    <option value="16:30">16:30</option>
                                    <option value="17:00">17:00</option>
                                    <option value="17:30">17:30</option>
                                    <option value="18:00">18:00</option>
                                    <option value="18:30">18:30</option>
                                    <option value="19:00" selected>19:00</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <label class="form-label" for="all_day_check">종일</label>
                        <fieldset>
                            <div class="form-check abc-checkbox abc-checkbox-primary">
                                <input class="form-check-input" id="all_day_check" type="checkbox" onclick="allDayCheck()" checked>
                                <label class="form-check-label" for="all_day_check">
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label class="form-label" for="type">일정타입</label><span class="badge badge-overlay-danger ml-2">필수</span>
                            <select form="form_modal" id="type" name="type" class="form-control" style="width: 100%" >
                                <option value="">선택</option>
                                <option value="업무">업무</option>
                                <option value="출장">출장</option>
                                <option value="휴가">휴가</option>
                                <option value="휴일">휴일</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label class="form-label" for="kind">캘린더</label><span class="badge badge-overlay-danger ml-2">필수</span>
                            <select form="form_modal" id="kind" name="kind" class="form-control" style="width: 100%" onchange="kindChildList(this.val)">
                                <option value="">선택</option>
                                <option value="사내캘린더">사내캘린더</option>
                                <option value="마이캘린더">마이캘린더</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label class="form-label" for="kind_child">상세 캘린더</label>
                            <select form="form_modal" id="kind_child" name="kind_child" class="form-control" style="width: 100%">
                                <option value="">선택</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mb-1">
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label class="form-label" for="title">제목</label><span class="badge badge-overlay-danger ml-2">필수</span>
                            <input form="form_modal" type="text" id="title" name="title" class="form-control" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label class="form-label" for="contents">내용</label>
                            <textarea form="form_modal" id="contents" name="contents" class="form-control" autocomplete="off" rows="10"></textarea>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button form="form_modal" type="button" class="btn btn-white" data-dismiss="modal">닫기</button>
                <button form="form_modal" type="button" class="btn btn-primary btn_save" id="btn_save">저장</button>
                <button form="form_modal" type="button" class="btn btn-danger btn_delete" id="btn_delete">삭제</button>
            </div>

        </div>
    </div>
</div>
<form id="form_modal" name="form_modal">
    <input type="hidden" id="id" name="id">

    <input type="hidden" id="arg" name="arg">
    <input type="hidden" id="allDay" name="allDay">
</form>

<div class="modal fade" id="modal_input_2" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="modal_title">
                    캘린더 추가
                </h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <div class="row mb-1">
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label class="form-label" for="kind_title">캘린더 이름</label><span class="badge badge-overlay-danger ml-2">필수</span>
                            <input form="form_modal_2" type="text" id="kind_title" name="kind_title" class="form-control" autocomplete="off">
                        </div>
                    </div>
                </div>

                <div class="row mb-1">
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label class="form-label" for="kind_contents">설명</label>
                            <textarea form="form_modal_2" id="kind_contents" name="kind_contents" class="form-control" autocomplete="off" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="colorPickSelector"></div>
                <input type="hidden" id="pick_color">

            </div>
            <div class="modal-footer">
                <button form="form_modal_2" type="button" class="btn btn-white" data-dismiss="modal">닫기</button>
                <button form="form_modal_2" type="button" class="btn btn-danger" id="btn_kind_delete">삭제</button>
                <button form="form_modal_2" type="button" class="btn btn-primary" id="btn_kind_add">저장</button>
            </div>

        </div>
    </div>
</div>

<form id="form_modal_2" name="form_modal_2">
    <input type="hidden" id="modal_id_2" name="modal_id_2">
    <input type="hidden" id="modal_cal_type" name="modal_cal_type">
</form>


@endsection

@section('script')
<script src="/js/colorPick.min.js"></script>
<!-- fullcalendar CDN -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/locales-all.min.js'></script>
@include('calendar.calendar_js')
@endsection
