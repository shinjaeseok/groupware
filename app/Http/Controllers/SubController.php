<?php

namespace App\Http\Controllers;

use App\Models\Subs;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function page(Request $request)
    {
        return view('sub.sub');
    }

    public function list(Request $request)
    {
        $message = 'success';
        $status = true;

        $data =Subs::orderByDesc('id')->get();

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
        $division = $request->division;
        $date = $request->date;
        $title = $request->title;
        $contents = $request->contents;

        try {
            DB::beginTransaction();

            //저장
            $param = [
                'division'          => $division,
                'date'              => $date,
                'title'             => $title,
                'contents'          => $contents,
                'created_user_code' => '유저',
            ];

            $data =Subs::insert($param);

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
        $data =Subs::where('id', $request->id)->first();

        if (!$data) {

            return ['data' => '', 'message' => '데이터가 없습니다.', 'status' => false];
        }

        return ['data' => $data, 'message' => '', 'status' => true];
    }

    public function update(Request $request)
    {
        // 기안 정보
        $title = $request->title;
        $contents = $request->contents;
        $date = $request->date;

        try {
            DB::beginTransaction();

            // 수정
            $param = [
                'date'              => $date,
                'title'             => $title,
                'contents'          => $contents,
                'updated_user_code' => '유저',
            ];

            $data =Subs::where('id', $request->modal_id)->update($param);

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
        $data =Subs::where('id', $request->id)->first();

        if (!$data) {

            return ['data' => '', 'message' => '데이터가 없습니다.', 'status' => false];
        }

        try {
            DB::beginTransaction();

            // 삭제
            $data =Subs::where('id', $request->id)->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '삭제 오류입니다.', 'status' => false];
        }


        return ['data' => $data, 'message' => '삭제 되었습니다.', 'status' => true];
    }

}
