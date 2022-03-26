<?php

namespace App\Http\Controllers;

use App\Models\AttachFile;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class GlobalController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function fileDownload($id)
    {
        $data = AttachFile::where('id', $id)->first();

        if( !$data ) return back()->withErrors(['첨부파일이 없습니다.']);

        if( !$data->file_ori_name || !Storage::exists($data->file_path)) return back()->withErrors(['첨부파일이 없습니다.']);

        return Storage::download($data->file_path,$data->file_ori_name);     //경로와 파일이름을 반환
    }
}
