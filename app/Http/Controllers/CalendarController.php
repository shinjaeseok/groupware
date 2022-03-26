<?php

namespace App\Http\Controllers;

use App\Models\CalendarKind;
use App\Models\User;
use App\Models\Calendar;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CalendarController extends Controller
{
    public function page(Request $request)
    {
        $system_com_data = CalendarKind::where('type', 'system')->where('kind','사내캘린더')->get();
        $system_my_data = CalendarKind::where('type', 'system')->where('kind','마이캘린더')->get();
        $com_data = CalendarKind::where('kind','사내캘린더')->where('fk_user_id', Auth::user()->id)->get();
        $my_data = CalendarKind::where('kind','마이캘린더')->where('fk_user_id', Auth::user()->id)->get();

        return view('calendar.calendar', [ 'system_com_data' => $system_com_data, 'com_data' => $com_data, 'my_com_data' => $system_my_data, 'my_data'=> $my_data]);
    }

    public function list(Request $request)
    {

        $data = DB::table('calendars as c')
            ->select('c.*', 'ck.color', 'ck.type as kind_type', 'ck.title as kind_title')
            ->leftJoin('calendar_kinds as ck', 'c.fk_kind_child_id', 'ck.id')
            ->where('c.writer', "=" , Auth::user()->employee_code )
            ->orwhere('c.kind', '=' ,'사내캘린더')
            ->get();

        if(!$data) {
            return ['data' => '', 'message' => '데이터가 없습니다.', 'status' => false];
        }

        foreach($data as $item) {
            if(!$item->color) {
                $item->color = '#CC2EFA';
            }

            if ( $item->allDay == 'Y') $item->allDay = true;
            else $item->allDay = false;

            if ( Auth::user()->manager == 'Y') $item->manager = true;
            else $item->manager = false;
        }

        return $data;
    }

    public function insert(Request $request)
    {
        $kind = $request->kind;
        $title = $request->title;
        $contents = $request->contents;
        $start = $request->start;
        $end = $request->end;
        $allDay = $request->allDay;
        $type = $request->type;
        $kind_child = $request->kind_child;

        if ( $allDay== 'true') $allDay = "Y";
        else $allDay = "N";

        try {
            DB::beginTransaction();

            //저장
            $param = [
                'type'              => $type,
                'kind'              => $kind,
                'fk_kind_child_id'  => $kind_child,
                'title'             => $title,
                'contents'          => $contents,
                'start'             => $start,
                'end'               => $end,
                'writer'            => Auth::user()->employee_code,
                'allDay'            => $allDay,
                'created_user_code' => Auth::user()->employee_code,
            ];

            $data =Calendar::insert($param);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '등록 오류입니다.', 'status' => false];
        }

        return ['data' => $data, 'message' => '등록 되었습니다.', 'status' => true];
    }

    public function update(Request $request)
    {
        // 기안 정보
        $kind = $request->kind;
        $title = $request->title;
        $contents = $request->contents;
        $start = $request->start;
        $end = $request->end;
        $allDay = $request->allDay;
        $type = $request->type;
        $kind_child = $request->kind_child;

        if ( $allDay== 'true') $allDay = "Y";
        else $allDay = "N";

        $writer = DB::table('calendars')->select('writer')->where('id', '=', $request->id)->first();

        if (Auth::user()->manager == "Y" || $writer->writer == Auth::user()->employee_code) {

            try {
                DB::beginTransaction();
                // 수정
                $param = [
                    'type'              => $type,
                    'kind'              => $kind,
                    'fk_kind_child_id'  => $kind_child,
                    'title'             => $title,
                    'contents'          => $contents,
                    'start'             => $start,
                    'end'               => $end,
                    'writer'            => Auth::user()->employee_code,
                    'allDay'            => $allDay,
                    'updated_user_code' => Auth::user()->employee_code,
                ];

                $data =Calendar::where('id', $request->id)->update($param);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

                return ['data' => '', 'message' => '등록 오류입니다.', 'status' => false];
            }

            return ['data' => $data, 'message' => '등록되었습니다.', 'status' => true];
        }

        return ['data' => '', 'message' => '수정 권한이 없습니다.', 'status' => false];
    }

    public function delete(Request $request)
    {
        $data =Calendar::where('id', $request->id)->first();

        if (!$data) {
            return ['data' => '', 'message' => '데이터가 없습니다.', 'status' => false];
        }

        $writer = DB::table('calendars')->select('writer')->where('id', '=', $request->id)->first();

        if (Auth::user()->manager == "Y" || $writer->writer == Auth::user()->employee_code) {
            try {
                DB::beginTransaction();

                $data =Calendar::where('id', $request->id)->delete();

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

                return ['data' => '', 'message' => '삭제 오류입니다.', 'status' => false];
            }


            return ['data' => $data, 'message' => '삭제 되었습니다.', 'status' => true];
        }
        return ['data' => '', 'message' => '삭제 권한이 없습니다.', 'status' => false];
    }

    public function calendarKindChildInsert(Request $request) {
        $modal_cal_type = $request->modal_cal_type;
        $kind_title = $request->kind_title;
        $kind_contents = $request->kind_contents;
        $pick_color = $request->pick_color;
        $user_id = Auth::user()->id;

        $kind = '마이캘린더';
        if ($modal_cal_type == 'com') {
            $kind = '사내캘린더';
        }

        if (!$pick_color) {
            $pick_color = '#3498db';
        }

        try {
            DB::beginTransaction();

            $param = [
                'type'              => 'user',
                'fk_user_id'        => $user_id,
                'kind'              => $kind,
                'title'             => $kind_title,
                'content'           => $kind_contents,
                'color'             => $pick_color,
                'created_user_code' => Auth::user()->employee_code
            ];

           CalendarKind::insert($param);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '저장 오류입니다.', 'status' => false];
        }

        return ['data' => '', 'message' => '저장되었습니다.', 'status' => true];
    }

    public function calendarKindChildSelect(Request $request) {
        $id = $request->id;
        $user_id = Auth::user()->id;

        $data =CalendarKind::where('id',$id)->where('fk_user_id', $user_id)->first();

        if (!$data) {
            return ['data' => '', 'message' => '캘린더 정보가 없습니다.', 'status' => true];
        }

        $modal_cal_type = 'my';
        if ($data->kind == '사내캘린더') {
            $modal_cal_type = 'com';
        }

        $data->modal_cal_type = $modal_cal_type;

        return ['data' => $data, 'message' => '', 'status' => true];
    }

    public function calendarKindChildUpdate(Request $request) {
        $id = $request->id;

        $data =CalendarKind::where('id', $id)->where('fk_user_id', Auth::user()->id)->first();

        if (!$data) {
            return ['data' => '', 'message' => '정보가 없습니다.', 'status' => false];
        }

        $kind_title = $request->kind_title;
        $kind_contents = $request->kind_contents;
        $pick_color = $request->pick_color;

        if (!$pick_color) {
            $pick_color = '#3498db';
        }

        try {
            DB::beginTransaction();

            $param = [
                'title'             => $kind_title,
                'content'           => $kind_contents,
                'color'             => $pick_color,
                'updated_user_code' => Auth::user()->employee_code
            ];

           CalendarKind::where('id', $id)->update($param);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '저장 오류입니다.', 'status' => false];
        }

        return ['data' => '', 'message' => '저장되었습니다.', 'status' => true];
    }

    public function calendarKindChildDelete(Request $request) {
        $id = $request->id;

        $data =CalendarKind::where('id', $id)->where('fk_user_id', Auth::user()->id)->first();

        if (!$data) {
            return ['data' => '', 'message' => '정보가 없습니다.', 'status' => false];
        }

        try {
            DB::beginTransaction();

           CalendarKind::where('id', $id)->delete();

           Calendar::where('fk_kind_child_id', $id)->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '삭제 오류입니다.', 'status' => false];
        }

        return ['data' => '', 'message' => '삭제되었습니다.', 'status' => true];
    }

    public function childList(Request $request) {
        $data =CalendarKind::where('kind', $request->type)->get();

        if (!$data) {
            return ['data' => '', 'message' => '정보가 없습니다..', 'status' => false];
        }

        return ['data' => $data, 'message' => '조회되었습니다.', 'status' => true];
    }
}

