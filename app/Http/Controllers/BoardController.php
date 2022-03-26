<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BoardController extends Controller
{
    public function page(Request $request)
    {
        return view('setting.notice');
    }

    public function list(Request $request)
    {
        $message = 'success';
        $status = true;


        $data = DB::table('boards as b')
            ->select(
                "b.*",
                "u.name as user_name",
            )
            ->leftJoin("users as u", "b.created_user_code", "=", "u.employee_code")
            ->orderByDesc('b.id')
            ->limit(5)
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
                'board_type'        => 'notice',
                'title'             => $title,
                'contents'          => $contents,
                'created_user_code' => Auth::user()->employee_code,
            ];

            $data = Board::insert($param);

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
        $data = DB::table('boards as b')
            ->select(
                "b.*",
                "u.name as user_name",
            )
            ->leftJoin("users as u", "b.created_user_code", "=", "u.employee_code")
            ->where('b.id', $request->id)
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
                'board_type'        => 'notice',
                'title'             => $title,
                'contents'          => $contents,
                'updated_user_code' => Auth::user()->employee_code,
            ];

            $data =Board::where('id', $request->modal_id)->update($param);

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
        $data = Board::where('id', $request->id)->first();

        if (!$data) {
            return ['data' => '', 'message' => '데이터가 없습니다.', 'status' => false];
        }

        try {
            DB::beginTransaction();

            $data = Board::where('id', $request->id)->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '삭제 오류입니다.', 'status' => false];
        }

        return ['data' => $data, 'message' => '삭제 되었습니다.', 'status' => true];
    }

}

