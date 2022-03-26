<?php


namespace App\Lib;


use App\Models\Attach_file;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

trait Fileerr
{

    public function fileUpload($files, $id, $table, $path) {

        foreach ($files as $file) {
            $file_extension = $file->getClientOriginalExtension();
            $file_ori_name = $file->getClientOriginalName();
            $file_size = $file->getSize();
            $attachment_path = $file->store($path);

            $param = [
                'fk_table'       => $table,
                'fk_id'          => $id,
                'file_extension' => $file_extension,
                'file_ori_name'  => $file_ori_name,
                'file_path'      => $attachment_path,
                'file_size'      => $file_size,
                'sort'           => 1,
                'created_user'   => Auth::user()->user_code,
            ];

            $result = Attach_file::insert($param);
        }

        return $result;
    }
}
