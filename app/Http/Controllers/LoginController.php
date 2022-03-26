<?php

namespace App\Http\Controllers;

use App\Models\AttachFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LoginController extends Controller
{
    public function loginPage(Request $request) {

        $login_check = Auth::user();

        if ($login_check) {
            return redirect('/');
        }

        return view('loginPage');
    }

    public function login(Request $request) {

        $user = User::where('employee_code', $request->employee_code)->first();

        if (!$user) {
            Log::info('not employee code. Trying to input user_code: '. $request->employee_code. ' and IP: '.$request->ip());

            return back()->withErrors(['아이디를 확인해주세요.']);
        } else {
            if ($user->is_deleted == 'Y') {
                return back()->withErrors(['탈퇴한 사원입니다.']);
        }

            if (Hash::check($request->password, $user->password)) {
                $credentials = $request->only('employee_code', 'password');

                if (Auth::attempt($credentials)) {

                    Log::info('Login employee_code: '.$user->employee_code.', IP: '.$request->ip());

                    // todo: profile 사진, 부서명, 직책명 등 기본 정보 가져와서 세션에 담기
                    $request->session()->put('department_name', '개발팀');
                    $request->session()->put('position_name', '개발자');

                    // 프로필 사진
                    $profile_img =AttachFile::where('fk_table', 'users')->where('fk_id', Auth::user()->id)->first();

                    $profile_img_path = $profile_img && $profile_img->file_path ? Storage::url($profile_img->file_path) : "/img/profile.png";

                    $request->session()->put('profile_img', $profile_img_path);

                    return redirect('/')->with('message', $user->name.'님 환영합니다.');
                }
            }
        }

        Log::info('User failed to login. user_code: '. $request->employee_code . ' Trying to connect IP: '.$request->ip());

        return back()->withErrors(['아이디 또는 비밀번호가 일치하지 않습니다.']);
    }

    public function logout(Request $request){

        $request->session()->flush();
        Auth::logout();

        return redirect('/login');
    }
}



