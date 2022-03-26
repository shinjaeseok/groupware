<?php


namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use App\Models\AttachFile;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function page(Request $request)
    {
        return view('setting.employee');
    }

    public function list(Request $request, $type = null)
    {
        $message = 'success';
        $status = true;

        $data = DB::table('users as u')
            ->select('u.*', 'd.name as department_name', 'p.position as position_name')
            ->leftJoin('departments as d', 'u.department_id', '=', 'd.id')
            ->leftJoin('positions as p', 'u.position_id', '=', 'p.id')
            ->orderByDesc('u.id')->get();

        if (!$data) {
            $message = 'no data';
            $status = false;
        }

        foreach ($data as $item) {
        }

        return ['data' => $data, 'message' => $message, 'status' => $status];
    }

    public function insert(Request $request)
    {
        $employee_code = $request->employee_code;
        $name = $request->name;
        $department_id = $request->department_id;
        $position_id = $request->position_id;
        $manager = $request->manager ? "Y" : "N";
        $join_date = $request->join_date;
        $leave_date = $request->leave_date;
        $post = $request->post;
        $address_1 = $request->address_1;
        $address_2 = $request->address_2;
        $phone = $request->phone;
        $email = $request->email;

        $user_overlab_check =  DB::table('users')->select('employee_code')->where('employee_code' ,'=' , $employee_code)->first();

        if($user_overlab_check) {
            return ['data' => '', 'message' => '이미 등록된 사원코드입니다.', 'status' => false];
        }

        try {
            DB::beginTransaction();

            //저장
            $param = [
                'employee_code'     => $employee_code,
                'name'              => $name,
                'department_id'     => $department_id,
                'position_id'       => $position_id,
                'manager'           => $manager,
                'join_date'         => $join_date,
                'leave_date'        => $leave_date,
                'post'              => $post,
                'address_1'         => $address_1,
                'address_2'         => $address_2,
                'phone'             => $phone,
                'email'             => $email,
                'created_user_code' => Auth::user()->employee_code,
            ];

            $data =User::insert($param);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{" . $e->getFile() . "} : {" . $e->getMessage() . "} => {" . $e->getLine() . "}");

            return ['data' => '', 'message' => '등록 오류입니다.', 'status' => false];
        }

        return ['data' => $data, 'message' => '등록 되었습니다.', 'status' => true];
    }

    public function select(Request $request)
    {
        $data = User::where('id', $request->id)->first();

        if (!$data) {
            return ['data' => '', 'message' => '데이터가 없습니다.', 'status' => false];
        }

        // 부서명
        $department_data = Department::select('name')->where('id', $data->department_id)->first();
        $data->department_name = $department_data->name;

        //첨부파일 가져오기
        $attachment = AttachFile::where('fk_table', 'users')->where('fk_id', $request->id)->first();

        $data->attachment = $attachment && $attachment->file_path ? Storage::url($attachment->file_path) : "/img/profile.png";

        return ['data' => $data, 'message' => '', 'status' => true];
    }

    public function update(Request $request)
    {
        // 사원 정보
        $employee_code = $request->employee_code;
        $name = $request->name;
        $department_id = $request->department_id;
        $position_id = $request->position_id;
        $manager = $request->manager ? "Y" : "N";
        $join_date = $request->join_date;
        $leave_date = $request->leave_date;
        $post = $request->post;
        $address_1 = $request->address_1;
        $address_2 = $request->address_2;
        $is_deleted = $request->is_deleted;
        $phone = $request->phone;
        $email = $request->email;

        try {
            DB::beginTransaction();

            $param = [
                'employee_code'     => $employee_code,
                'name'              => $name,
                'department_id'     => $department_id,
                'position_id'       => $position_id,
                'manager'           => $manager,
                'join_date'         => $join_date,
                'leave_date'        => $leave_date,
                'post'              => $post,
                'address_1'         => $address_1,
                'address_2'         => $address_2,
                'phone'             => $phone,
                'email'             => $email,
                'is_deleted'        => $is_deleted,
                'updated_user_code' => Auth::user()->employee_code,
            ];

            $data = User::where('id', $request->modal_id)->update($param);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{" . $e->getFile() . "} : {" . $e->getMessage() . "} => {" . $e->getLine() . "}");

            return ['data' => '', 'message' => '등록 오류입니다.', 'status' => false];
        }

        return ['data' => $data, 'message' => '등록되었습니다.', 'status' => true];

    }

    public function delete(Request $request)
    {
        $data =User::where('id', $request->id)->first();
        $flag = false;

        if (!$data) {

            return ['data' => '', 'message' => '데이터가 없습니다.', 'status' => false];
        }

        try {
            DB::beginTransaction();

            if ($request->id == Auth::user()->id) {
                $flag = true;
            }
            // 삭제시 수정됨
            $data = User::where('id', $request->id)->update(['is_deleted' => $request->state]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{" . $e->getFile() . "} : {" . $e->getMessage() . "} => {" . $e->getLine() . "}");

            return ['data' => '', 'message' => '수정 오류입니다.', 'status' => false];
        }

        if($flag)
            Auth::logout();


        return ['data' => $data, 'message' => '수정 되었습니다.', 'status' => true];
    }

}
