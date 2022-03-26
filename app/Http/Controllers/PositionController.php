<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Position;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PositionController extends Controller
{
    public function page(Request $request)
    {
        return view('setting.position');
    }

    public function list(Request $request)
    {
        $message = 'success';
        $status = true;

        $data = DB::table('positions')
            ->orderBy('position_grade')
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
        $position = $request->position;
        $position_grade = $request->position_grade;

        try {
            DB::beginTransaction();

            //저장
            $param = [
                'position'        => $position,
                'position_grade'     => $position_grade,
                'created_user_code' => Auth::user()->employee_code,
            ];

            $data =Position::insert($param);

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
        $data =Position::where('id', $request->id)->first();

        if (!$data) {

            return ['data' => '', 'message' => '데이터가 없습니다.', 'status' => false];
        }

        return ['data' => $data, 'message' => '', 'status' => true];
    }

    public function update(Request $request)
    {
        // 기안 정보
        $position = $request->position;
        $position_grade = $request->position_grade;

        try {
            DB::beginTransaction();

            // 수정
            $param = [
                'position'        => $position,
                'position_grade'     => $position_grade,
                'updated_user_code' => Auth::user()->employee_code,
            ];

            $data =Position::where('id', $request->modal_id)->update($param);

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

        $data =JgwPosition::where('id', $request->id)->first();

        if (!$data) {

            return ['data' => '', 'message' => '데이터가 없습니다.', 'status' => false];
        }

        try {
            DB::beginTransaction();

            $data =Position::where('id', $request->id)->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '삭제 오류입니다.', 'status' => false];
        }


        return ['data' => $data, 'message' => '삭제 되었습니다.', 'status' => true];
    }

}

