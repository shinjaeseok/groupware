<?php

namespace App\Http\Controllers;

use App\Lib\FileManager;
use App\Models\AttachFile;
use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function page(Request $request)
    {
        $user_data = User::where('id', Auth::user()->id)->first();

        if (!$user_data) {
            return back()->withErrors(['회원 정보가 없습니다.']);
        }

        $department_data = Department::select('name')->where('id', $user_data->department_id)->first();
        $user_data->department_name = $department_data->name;

        $position_data = Position::select('position')->where('id', $user_data->position_id)->first();
        $user_data->position_name = $position_data->position;

        $attachment = AttachFile::where('fk_table', 'users')->where('fk_id', Auth::user()->id)->first();
        $user_data->attachment = $attachment && $attachment->file_path ? Storage::url($attachment->file_path) : "/img/profile.png";

        return view('setting.profile', ['user_data' => $user_data]);
    }

    public function update(Request $request) {

        $user_id = Auth::user()->id;
        $email = $request->email;
        $phone = $request->phone;
        $post = $request->post;
        $address_1 = $request->address_1;
        $address_2 = $request->address_2;

        try {
            DB::beginTransaction();

            // 수정
            $param = [
                'email'             => $email,
                'phone'             => $phone,
                'post'              => $post,
                'address_1'         => $address_1,
                'address_2'         => $address_2,
                'updated_user_code' => Auth::user()->employee_code,
            ];

            $data = User::where('id', $user_id)->update($param);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '등록 중 오류가 발생했습니다.', 'status' => false];
        }

        return ['data' => $data, 'message' => '등록되었습니다.', 'status' => true];
    }

    public function profileFileUpdate(Request $request) {
        $user_id = Auth::user()->id;
        $files = $request->file('attach_file');

        try {
            DB::beginTransaction();

            // 기존 첨부 파일 삭제
            $prev_attach_file_data =AttachFile::where('fk_table', 'users')->where('fk_id', $user_id)->first();

            if ($prev_attach_file_data) {
                FileManager::fileDelete('users', $user_id);
            }

            // 첨부파일 신규 등록
            $data = FileManager::fileUpload($files, $user_id, 'users', 'public/profile');

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '등록 중 오류가 발생했습니다.', 'status' => false];
        }

        // 프로필 사진
        $profile_img =AttachFile::where('fk_table', 'users')->where('fk_id', Auth::user()->id)->first();

        $profile_img_path = $profile_img && $profile_img->file_path ? Storage::url($profile_img->file_path) : "/img/profile.png";

        $request->session()->put('profile_img', $profile_img_path);

        return ['data' => $data, 'message' => '등록되었습니다.', 'status' => true];
    }

    public function fileDelete(Request $request) {
        $id = Auth::user()->id;
        $table = 'users';

        $prev_attach_file_data =AttachFile::where('fk_table', $table)->where('fk_id', $id)->first();

        if (!$prev_attach_file_data) {
            return ['data' => '', 'message' => '업로드 된 파일이 없습니다.', 'status' => false];
        }

        FileManager::fileDelete($table, $id);

        // 프로필 사진
        $profile_img =AttachFile::where('fk_table', 'users')->where('fk_id', Auth::user()->id)->first();

        $profile_img_path = $profile_img && $profile_img->file_path ? Storage::url($profile_img->file_path) : "/img/profile.png";

        $request->session()->put('profile_img', $profile_img_path);

        return ['data' => '', 'message' => '삭제되었습니다.', 'status' => true];
    }

    public function passwordCheck(Request $request) {
        $password = $request->password;

        if (!$password) {
            return ['data' => '', 'message' => '올바른 값이 아닙니다.', 'status' => false];
        }

        $user =User::where('id', Auth::user()->id)->first();

        if (!$user) {
            return ['data' => '', 'message' => '유저 정보가 없습니다.', 'status' => false];
        }

        if (!Hash::check($request->password, $user->password)) {
            return ['data' => '', 'message' => '기존 비밀번호를 확인해주세요.', 'status' => false];
        }

        return ['data' => '', 'message' => '확인되었습니다.', 'status' => true];
    }

    public function passwordChange(Request $request) {

        $new_password = $request->new_password;
        $check_password = $request->check_password;

        if (!$new_password || !$check_password) {
            return ['data' => '', 'message' => '올바른 비밀번호를 입력해주세요.', 'status' => false];
        }

        if ($new_password != $check_password) {
            return ['data' => '', 'message' => '비밀번호가 일치하지 없습니다.', 'status' => false];
        }

        $user =User::where('id', Auth::user()->id)->first();

        if (!$user) {
            return ['data' => '', 'message' => '유저 정보가 없습니다.', 'status' => false];
        }

        $password = Hash::make($new_password);

        $param = [
            'password' => $password,
            'updated_user_code' => Auth::user()->employee_code,
        ];

        $data =User::where('id', Auth::user()->id)->update($param);

        if (!$data) {
            return ['data' => '', 'message' => '비밀번호 변경에 실패했습니다.', 'status' => false];
        }

        return ['data' => $data, 'message' => '비밀번호가 변경 되었습니다.', 'status' => true];
    }
}
