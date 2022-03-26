<?php

namespace App\Http\Controllers;

use App\Models\ApprovalDocument;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ApprovalDocumentController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function page(Request $request) {
    // todo:: 문서대장 페이지 로드

        return view('approval.approvalDocument');
    }

    public function list(Request $request) {
        $message = 'success';
        $status = true;

        $data = ApprovalDocument::orderByDesc('id')->get();

        if(!$data) {
            $message = 'no data';
            $status = false;
        }

        foreach($data as $item) {

        }

        return ['data' => $data, 'message' => $message, 'status' => $status];
    // todo:: 문서 대장 리스트
    }

    public function insert(Request $request) {

        $title = $request->modal_document_title;
        $contents = $request->modal_document_contents;
        $division = $request->modal_document_division;

        try {
            DB::beginTransaction();

            //저장
            $param = [
                'title'             => $title,
                'division'          => $division,
                'contents'          => $contents,
                'created_user_code' => Auth::user()->employee_code
            ];

            $data = ApprovalDocument::insert($param);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '등록 오류입니다.', 'status' => false];
        }

        return ['data' => $data, 'message' => '등록 되었습니다.', 'status' => true];
    }

    public function select(Request $request) {

        $id = $request->id;
        $data = ApprovalDocument::where('id', $id)->first();

        if (!$data) {

            return ['data' => '', 'message' => '데이터가 없습니다.', 'status' => false];
        }

        return ['data' => $data, 'message' => '', 'status' => true];
    }

    public function update(Request $request) {

        $id = $request->modal_id;
        $title = $request->modal_document_title;
        $contents = $request->modal_document_contents;
        $division = $request->modal_document_division;

        try {
            DB::beginTransaction();

            //저장
            $param = [
                'title'             => $title,
                'division'          => $division,
                'contents'          => $contents,
                'updated_user_code' => Auth::user()->employee_code
            ];

            $data = ApprovalDocument::where('id', $id)->update($param);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '등록 오류입니다.', 'status' => false];
        }

        return ['data' => $data, 'message' => '등록 되었습니다.', 'status' => true];
    }

    public function delete(Request $request) {

        $id = $request->id;

        $data = ApprovalDocument::where('id', $id)->first();

        if (!$data) {
            return ['data' => '', 'message' => '데이터가 없습니다.', 'status' => false];
        }

        try {
            DB::beginTransaction();

            // 삭제
            $data = ApprovalDocument::where('id', $id)->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '삭제 오류입니다.', 'status' => false];
        }

        return ['data' => $data, 'message' => '삭제 되었습니다.', 'status' => true];
    }

}
