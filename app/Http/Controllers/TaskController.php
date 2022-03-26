<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function dailyTaskPage(Request $request)
    {
        return view('task.dailyTask');
    }

    public function projectPage(Request $request)
    {
        return view('task.project');
    }

    public function dailyTaskManagerPage(Request $request)
    {
        return view('task.dailyTaskManager');
    }

    public function list(Request $request)
    {
        $message = 'success';
        $status = true;


        $data = DB::table('tasks as t')
            ->select(
                "t.*",
                "u.name as user_name",
            )
            ->leftJoin("users as u", "t.fk_user_id", "=", "u.id")
            ->where('fk_user_id', Auth::user()->id)
            ->orderByDesc('t.id')
            ->get();

        if(!$data) {
            $message = 'no data';
            $status = false;
        }

        foreach($data as $item) {
        }

        return ['data' => $data, 'message' => $message, 'status' => $status];
    }


    public function insert(Request $request)
    {
        $title = $request->title;

        if (!$title) {
            return ['data' => '', 'message' => '제목을 입력해주세요.', 'status' => false];
        }

        $contents = $request->contents;

        if (!$contents) {
            return ['data' => '', 'message' => '제목을 입력해주세요.', 'status' => false];
        }

        try {
            DB::beginTransaction();

            //저장
            $param = [
                'task_type'         => 'daily',
                'fk_user_id'        => Auth::user()->id,
                'title'             => $title,
                'contents'          => $contents,
                'created_user_code' => Auth::user()->employee_code,
            ];

            $data = Task::insert($param);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '등록 오류입니다.', 'status' => false];
        }

        return ['data' => $data, 'message' => '등록 되었습니다.', 'status' => true];
    }

    public function select(Request $request)
    {
        $data = DB::table('tasks as t')
            ->select(
                "t.*",
                "u.name as user_name",
            )
            ->leftJoin("users as u", "t.fk_user_id", "=", "u.id")
            ->where('t.id', $request->id)
            ->first();

        if (!$data) {

            return ['data' => '', 'message' => '데이터가 없습니다.', 'status' => false];
        }

        return ['data' => $data, 'message' => '', 'status' => true];
    }

    public function update(Request $request)
    {
        $title = $request->title;

        if (!$title) {
            return ['data' => '', 'message' => '제목을 입력해주세요.', 'status' => false];
        }

        $contents = $request->contents;

        if (!$contents) {
            return ['data' => '', 'message' => '제목을 입력해주세요.', 'status' => false];
        }

        try {
            DB::beginTransaction();

            // 수정
            $param = [
                'task_type'        => 'daily',
                'title'             => $title,
                'contents'          => $contents,
                'updated_user_code' => Auth::user()->employee_code,
            ];

            $data = Task::where('id', $request->modal_id)->update($param);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '등록 오류입니다.', 'status' => false];
        }

        return ['data' => $data, 'message' => '등록되었습니다.', 'status' => true];
    }

    public function delete(Request $request)
    {
        $data = Task::where('id', $request->id)->first();

        if (!$data) {
            return ['data' => '', 'message' => '데이터가 없습니다.', 'status' => false];
        }

        try {
            DB::beginTransaction();

            $data = Task::where('id', $request->id)->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '삭제 오류입니다.', 'status' => false];
        }

        return ['data' => $data, 'message' => '삭제 되었습니다.', 'status' => true];
    }

    public function managerList(Request $request)
    {
        $message = 'success';
        $status = true;


        $data = DB::table('tasks as t')
            ->select(
                "t.*",
                "u.name as user_name",
            )
            ->leftJoin("users as u", "t.fk_user_id", "=", "u.id")
            ->orderByDesc('t.id')
            ->get();

        if(!$data) {
            $message = 'no data';
            $status = false;
        }

        foreach($data as $item) {
        }

        return ['data' => $data, 'message' => $message, 'status' => $status];
    }

    public function managerSelect(Request $request)
    {
        $data = DB::table('tasks as t')
            ->select(
                "t.*",
                "u.name as user_name",
            )
            ->leftJoin("users as u", "t.fk_user_id", "=", "u.id")
            ->where('t.id', $request->id)
            ->first();

        if (!$data) {

            return ['data' => '', 'message' => '데이터가 없습니다.', 'status' => false];
        }

        return ['data' => $data, 'message' => '', 'status' => true];
    }
}

