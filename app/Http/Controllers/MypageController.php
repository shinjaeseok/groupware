<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Hash;

class MypageController extends Controller
{
    public function page(Request $request)
    {
        return view('mypage.profile');
    }

    public function mypageUpdate(Request $request)
    {
        $user_code = $request->user_code;
        $user_password = $request->user_password;
        $user_name = $request->user_name;
        $user_phone = $request->user_phone;
        $user_zip_code = $request->user_zip_code;
        $user_address = $request->user_address;
        $user_email = $request->user_email;
        $attachment = $request->attachment;

        $user_data = User::where('user_code', $user_code)->first();

        if (!$user_password) {
            $user_password = $user_data->password;
        } else {
            $user_password = Hash::make($user_password);
        }

        if ($attachment) {
            Storage::delete($user_data->attachment);
            $attachment_path = $request->file('attachment')->store('public/profile');
        } else {
            $attachment_path = $user_data->attachment;
        }


        $data = User::where('user_code', $user_code)
            ->update([
                         'password' => $user_password,
                         'user_name' => $user_name,
                         'email' => $user_email,
                         'phone' => $user_phone,
                         'address' => $user_address,
                         'zip_code' => $user_zip_code,
                         'attachment' => $attachment_path,
                         'updated_user' => Auth::user()->user_code
                     ]);

        if(!$data) {
            return ['data' => '', 'message' => '오류가 발생하였습니다.', 'status' => false];
        }

        return ['data' => $data, 'message' => '정상 처리 되었습니다.', 'status' => true];
    }

}
