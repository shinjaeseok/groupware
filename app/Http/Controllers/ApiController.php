<?php

namespace App\Http\Controllers;

use App\Models\AttachFile;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    public function userList(Request $request){

        $response = User::get();

        if (!$response) {
            $response = ['data' => '', 'message' => '유저 정보가 없습니다.', 'status' => false];
        }

        return json_encode($response);
    }

    public function userCreate(Request $request){

        $employee_code = $request->employee_code;
        if (!$employee_code) {
            $response = ['data' => '', 'message' => 'employee_code not input data', 'status' => true];
            return json_encode($response);
        }

        $password   = $request->password;
        if (!$password) {
            $response = ['data' => '', 'message' => 'password not input data', 'status' => true];
            return json_encode($response);
        }

        $name = $request->name;
        if (!$name) {
            $response = ['data' => '', 'message' => 'name not input data', 'status' => true];
            return json_encode($response);
        }

        $department_id = $request->department_id;
        if (!$department_id) {
            $response = ['data' => '', 'message' => 'department_id not input data', 'status' => true];
            return json_encode($response);
        }

        $position_id = $request->position_id;
        if (!$position_id) {
            $response = ['data' => '', 'message' => 'position_id not input data', 'status' => true];
            return json_encode($response);
        }

        $manager = $request->manager ? "Y" : "N";

        $join_date = $request->join_date;
        if (!$join_date) {
            $response = ['data' => '', 'message' => 'join_date not input data', 'status' => true];
            return json_encode($response);
        }

        $leave_date = $request->leave_date;


        try {
            DB::beginTransaction();

            //저장
            $param = [
                'employee_code'   => $employee_code,
                'password'   =>  Hash::make($password),
                'name'    => $name,
                'department_id'  => $department_id,
                'position_id' => $position_id,
                'manager'  => $manager,
                'join_date' => $join_date,
                'leave_date' => $leave_date,
                'created_user_code' => Auth::user()->employee_code,

            ];

            $data =User::insert($param);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{" . $e->getFile() . "} : {" . $e->getMessage() . "} => {" . $e->getLine() . "}");

            $response = ['data' => '', 'message' => '등록 오류입니다.', 'status' => false];
        }

        $response = ['data' => $data, 'message' => '등록 되었습니다.', 'status' => true];

        return json_encode($response);
    }

    public function userInfo(Request $request){

        $response = User::where('id',$request->id)->first();

        if (!$response) {
            $response = ['data' => '', 'message' => '유저 정보가 없습니다.', 'status' => false];
        }

        return json_encode($response);
    }

    public function attendanceInfo(Request $request){

        $response = Attendance::where('user_id',$request->id)->get();

        if (!$response) {
            $response = ['data' => '', 'message' => '출근 기록이 없습니다.', 'status' => false];
        }

        return json_encode($response);
    }
}
