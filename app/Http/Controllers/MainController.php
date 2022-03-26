<?php

namespace App\Http\Controllers;

use App\Models\ApprovalLine;
use App\Models\Attendance;
use App\Models\TodoList;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class MainController extends Controller
{
    public function page(Request $request)
    {
        $now = Carbon::now()->format("Y-m-d H:i:s");
        $now = explode(' ', $now);
        $now_date = $now[0];
        $now_time = $now[1];

        $attendance_data = Attendance::where("work_date", $now_date)
            ->where("user_id", Auth::user()->id)
            ->first();

        if($attendance_data) {
            $temp_end_time = $attendance_data->work_end_time ? $attendance_data->work_end_time : $now_time;

            $attendance_data->work_time = strtotime($temp_end_time) - strtotime($attendance_data->work_start_time);
            $attendance_data->work_time = !$attendance_data->work_start_time  ? '출근전' : Carbon::parse($attendance_data->work_time)->format("H:i:s");
            $attendance_data->work_end_time = $attendance_data->work_end_time ? $attendance_data->work_end_time : '퇴근전';
        }

        return view('main', [
            'attendance_data' => $attendance_data,
            'now' => $now_date
        ]);
    }

    public function approvalCheck(Request $request) {

        $approval_count = ApprovalLine::where('fk_user_id', Auth::user()->id)->where('approval_status', '가능')->count();

        return ['data' => $approval_count, 'message' => '', 'status' => true];
    }

    public function todoList(Request $request) {

        $todo_list = TodoList::where('fk_user_id', Auth::user()->id)->get();

        return ['data' => $todo_list, 'message' => '', 'status' => true];
    }

    public function todoListInsert(Request $request) {

        $todo = $request->todo;


        try {
            DB::beginTransaction();

            // 수정
            $param = [
                'fk_user_id'        => Auth::user()->id,
                'todo'              => $todo,
                'done_type'         => 'off',
                'created_user_code' => Auth::user()->employee_code,
            ];

            $data['id'] = TodoList::insertGetId($param);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{" . $e->getFile() . "} : {" . $e->getMessage() . "} => {" . $e->getLine() . "}");

            return ['data' => '', 'message' => '등록 오류입니다.', 'status' => false];
        }

        return ['data' => $data, 'message' => '', 'status' => true];
    }

    public function todoListUpdate(Request $request) {

        $id = $request->id;
        $done_type = $request->done_type;

        try {
            DB::beginTransaction();

            // 수정
            $param = [
                'done_type'         => $done_type,
                'updated_user_code' => Auth::user()->employee_code,
            ];

            $data = TodoList::where('id', $id)->update($param);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{" . $e->getFile() . "} : {" . $e->getMessage() . "} => {" . $e->getLine() . "}");

            return ['data' => '', 'message' => '등록 오류입니다.', 'status' => false];
        }

        return ['data' => $data, 'message' => '', 'status' => true];
    }

    public function todoListDelete(Request $request) {

        $id = $request->id;

        $data = TodoList::where('id', $id)->first();

        if (!$data) {
            return ['data' => '', 'message' => '데이터가 없습니다.', 'status' => false];
        }

        try {
            DB::beginTransaction();

            // 삭제
            $data = TodoList::where('id', $id)->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '삭제 오류입니다.', 'status' => false];
        }

        return ['data' => $data, 'message' => '삭제 되었습니다.', 'status' => true];
    }
}
