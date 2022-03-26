<?php

namespace App\Http\Controllers;

use App\Lib\FileManager;
use App\Models\AttachFile;
use App\Models\CompanyInfo;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CompanyInfoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function page(Request $request)
    {
        $company_data = CompanyInfo::orderByDesc('id')->first();

        if(!$company_data) {
            $company_data = false;
        } else {
            $company_data->ip_list = json_decode($company_data->ip_list);
            $attachment = AttachFile::where('fk_table', 'company_info')->where('fk_id', $company_data->id)->first();
            $company_data->attachment = $attachment && $attachment->file_path ? Storage::url($attachment->file_path) : "/img/profile.png";
        }
        
        return view('setting.companyInfo', ['company_data' => $company_data]);
    }

    public function insert(Request $request) {

        $company_name = $request->company_name;
        $ip_list = $request->ip_list;
        $files = $request->file('attach_file');

        try {
            DB::beginTransaction();

            $param = [
                'company_name'      => $company_name,
                'ip_list'           => json_encode($ip_list),
                'created_user_code' => Auth::user()->employee_code,
            ];

            $insert_id = CompanyInfo::insertGetId($param);

            // 첨부파일 저장
            if ($files) {
                // 첨부파일 신규 등록
                FileManager::fileUpload($files, $insert_id, 'company_info', 'public/company_info');
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '등록오류입니다.', 'status' => false];
        }

        return ['data' => '', 'message' => '등록되었습니다.', 'status' => true];
    }


    public function update(Request $request) {

        $id = $request->id;
        $company_name = $request->company_name;
        $ip_list = $request->ip_list;
        $files = $request->file('attach_file');

        try {
            DB::beginTransaction();

            $param = [
                'company_name'      => $company_name,
                'ip_list'           => json_encode($ip_list),
                'updated_user_code' => Auth::user()->employee_code,
            ];

            $data = CompanyInfo::where('id', $id)->update($param);

            // 첨부파일 저장
            if ($files) {
                // 기존 첨부 파일 삭제
                $prev_attach_file_data = AttachFile::where('fk_table', 'company_info')->where('fk_id', $id)->first();

                if ($prev_attach_file_data) {
                    FileManager::fileDelete('company_info', $id);
                }

                // 첨부파일 신규 등록
                FileManager::fileUpload($files, $id, 'company_info', 'public/company_info');
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '등록오류입니다.', 'status' => false];
        }

        return ['data' => '', 'message' => '등록되었습니다.', 'status' => true];
    }

    public function fileDelete(Request $request) {
        $id = $request->id;
        $table = 'company_info';

        $prev_attach_file_data = AttachFile::where('fk_table', $table)->where('fk_id', $id)->first();

        if (!$prev_attach_file_data) {
            return ['data' => '', 'message' => '업로드 된 파일이 없습니다.', 'status' => false];
        }

        FileManager::fileDelete($table, $id);

        return ['data' => '', 'message' => '삭제되었습니다.', 'status' => true];
    }
}
