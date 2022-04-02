<?php

namespace App\Http\Controllers;

use App\Models\AttachFile;
use App\Models\Attendance;
use App\Models\CompanyInfo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /*근태현황*/
    public function page(Request $request)
    {
        return view('attendance.attendance');
    }

    /*근태관리*/
    public function managePage(Request $request)
    {
        return view('attendance.attendanceManage');
    }

    /*전체근태현황*/
    public function listPage(Request $request)
    {
        return view('attendance.attendanceList');
    }

    /*근태현황판*/
    public function platePage(Request $request)
    {
        return view('attendance.attendancePlate');
    }

    /*전체근태현황*/
    public function dayListPage(Request $request)
    {
        return view('attendance.attendanceDayList');
    }

    public function list(Request $request)
    {
        $message = 'success';
        $status = true;
        $process_mode = $request->process_mode;
        $sql = DB::table("attendances as a")
            ->select(
                "a.*",
                "u.id as user_id",
                "u.name as user_name",
                "d.name as department_name",
                "p.position as position_name"
            )
            ->leftJoin("users as u", "a.user_id", "=", "u.id")
            ->leftJoin("departments as d", "u.department_id", "=", "d.id")
            ->leftJoin("positions as p", "u.position_id","=", "p.id");

        if($process_mode == "page")
            $sql->where('a.user_id', Auth::user()->id);
        else if($process_mode == "page_manage")
            $sql->where('a.status', '!=', '완료');
        else if($process_mode == "page_plate")
            $sql->where('a.work_date', Carbon::now()->format("Y-m-d"));

        $list = $sql->where('u.is_deleted', 'N')->orderByDesc('a.id')->get();

        if(!$list) {
            $message = 'no data';
            $status = false;
        }

        $data = [];
        foreach ($list as $item) {
            if($item->work_end_time_after && $item->status == '승인' && $process_mode != "page_manage") {
                $item->work_start_time = $item->work_start_time_after ? $item->work_start_time_after : $item->work_start_time;
                $item->work_end_time = $item->work_end_time_after ? $item->work_end_time_after : $item->work_end_time;
            }
            $temp_start_time = $item->work_start_time_after && $item->status == '승인'? $item->work_start_time_after : $item->work_end_time;
            $temp_end_time = $item->work_end_time_after && $item->status == '승인'? $item->work_end_time_after : $item->work_end_time;

            $item->work_time = strtotime($temp_end_time) - strtotime($temp_start_time);
            $item->work_time = !$temp_end_time  ? '-' : Carbon::parse($item->work_time)->format("H:i:s");
            $item->work_start_time = !$item->work_start_time  ? '-' : $item->work_start_time;
            $item->work_end_time = !$item->work_end_time  ? '-' : $item->work_end_time;
            $item->work_start_time_after = !$item->work_start_time_after  ? '-' : $item->work_start_time_after;
            $item->work_end_time_after = !$item->work_end_time_after  ? '-' : $item->work_end_time_after;

            $attachment = AttachFile::where('fk_table', 'users')->where('fk_id', $item->user_id)->first();
            $item->attachment = $attachment && $attachment->file_path ? Storage::url($attachment->file_path) : "/img/profile.png";

            $data[] = $item;
        }

        return ['data' => $data, 'message' => $message, 'status' => $status];
    }

    public function select(Request $request)
    {
        $id = $request->id;
        $data = Attendance::where('id', $id)->first();

        if (!$data) {
            return ['data' => '', 'message' => '데이터가 없습니다.', 'status' => false];
        } else {
            $user_data =User::where('id', $data->user_id)->first();
            $data->user_name = '-';
            if($user_data && $user_data->name) {
                $data->user_name = $user_data->name;
            }

            if(!$data->work_start_time_after) $data->work_start_time_after = $data->work_start_time;
            if(!$data->work_end_time_after) $data->work_end_time_after = $data->work_end_time;

            $data->work_start_time_after = Carbon::parse($data->work_start_time_after)->format("H:i");
        }

        return ['data' => $data, 'message' => '', 'status' => true];
    }

    public function update(Request $request)
    {
        $id = $request->modal_id;
        $work_date = $request->modal_work_date;
        $work_start_time_after = $request->modal_work_start_time_after;
        $work_end_time_after = $request->modal_work_end_time_after;
        $reason = $request->modal_reason;
        $answer = $request->modal_answer;
        $status = $request->modal_status ? $request->modal_status : '미처리';
        $approval_user_id = $status == "승인" || $status == "반려" ? Auth::user()->id : null;

        try {
            DB::beginTransaction();

            //수정
            $param = [
                'user_id'               => Auth::user()->id,
                'approval_user_id'      => $approval_user_id,
                'work_date'             => $work_date,
                'work_start_time_after' => $work_start_time_after,
                'work_end_time_after'   => $work_end_time_after,
                'status'                => $status,
                'reason'                => $reason,
                'answer'                => $answer,
                'updated_user_code'     => Auth::user()->employee_code
            ];

            $data = Attendance::where('id', $id)->update($param);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '등록 오류입니다.', 'status' => false];
        }

        return ['data' => $data, 'message' => '등록되었습니다.', 'status' => true];
    }

    public function info(Request $request)
    {
        $now = Carbon::now()->format("Y-m-d");
        $sql = <<<SQL
                    WITH RECURSIVE TEMP AS (
                        SELECT
                            id,
                            parent_id,
                            name,
                            sort,
                            status,
                            CONCAT(sort, name) AS path,
                            1 AS depth
                        FROM departments
                        WHERE parent_id is null
                        UNION ALL
                        SELECT
                            b2.id,
                            b2.parent_id,
                            b2.name,
                            b2.sort,
                            b2.status,
                            CONCAT(t.path, ',', b2.sort, b2.name) AS path,
                            t.depth+1 AS depth
                        FROM TEMP AS t
                        INNER JOIN departments AS b2
                        ON t.id = b2.parent_id
                    )
                    SELECT t.name as department_name,
                           t.parent_id,
                           u.employee_code as employee_code,
                           u.name as user_name,
                           p.position as position_name,
                           a.work_start_time,
                           af.file_path
                    FROM TEMP AS t
                    LEFT JOIN users AS u
                    ON t.id = u.department_id
                    AND u.is_deleted = 'N'
                    LEFT JOIN positions AS p
                    ON u.position_id = p.id
                    LEFT JOIN attendances AS a
                    ON u.id = a.user_id
                    AND a.work_date = '${now}'
                    LEFT JOIN attach_files AS af
                    ON u.id = af.fk_id
                    AND af.fk_table = 'users'
                    ORDER BY t.path ASC
            SQL;

        $list = DB::select($sql);

        if (!$list) {
            return ['data' => '', 'message' => '데이터가 없습니다.', 'status' => false];
        }

        $data = [];
        $department_name = '';
        foreach ($list as $item) {
            if(!$item->parent_id) $department_name = $item->department_name;

            $item->parent_department_name = $department_name;
            $item->file_path = $item->file_path && Storage::exists($item->file_path) ? Storage::url($item->file_path) : "/img/profile.png";
            $item->opacity = 1;
            if(!$item->work_start_time) $item->opacity = 0.2;
            $data[$department_name][] = $item;
        }

        return ['data' => $data, 'message' => '', 'status' => true];
    }

    function workTime(Request $request) {
        $now = Carbon::now()->format("Y-m-d H:i:s");
        $now = explode(' ', $now);
        $now_date = $now[0];
        $now_time = $now[1];

        $data = Attendance::where("work_date", $now_date)
            ->where('user_id', Auth::user()->id)
            ->first();

        if (!$data) {
            $data['work_start_time'] = '출근전';
            return ['data' => $data, 'message' => '', 'status' => false];
        }

        $temp_end_time = $data->work_end_time ? $data->work_end_time : $now_time;
        $data->work_time = strtotime($temp_end_time) - strtotime($data->work_start_time);
        $data->work_time = !$data->work_start_time  ? '출근전' : Carbon::parse($data->work_time)->format("H:i:s");
        $data->work_end_time = $data->work_end_time ? $data->work_end_time : '퇴근전';

        return ['data' => $data, 'message' => '', 'status' => true];
    }

    function work(Request $request) {
        $now = Carbon::now()->format("Y-m-d H:i:s");
        $now = explode(' ', $now);
        $now_date = $now[0];
        $now_time = $now[1];
        $process_mode = $request->process_mode;
        $ips = CompanyInfo::select('id')->where('ip_list', 'LIKE', "%".$request->ip()."%")->first();

        if(!$ips) {
            log::info(Auth::user()->employee_code."출석 아이피 : ".$request->ip());
            return ['data' => '', 'message' => '허용된 ip가 아닙니다.', 'status' => false];
        }

        try {
            DB::beginTransaction();
            $msg = '등록 오류입니다.';
            $check = Attendance::where("work_date", $now_date)
                ->where('user_id', Auth::user()->id)
                ->first();

            if ($process_mode == 'start') {
                if(isset($check) && $check->work_start_time) {
                    $msg = '출근 기록이 있습니다.';
                    throw new \Exception($msg);
                }

                $param = [
                    'user_id'           => Auth::user()->id,
                    'work_date'         => $now_date,
                    'work_start_time'   => $now_time,
                    'work_start_ip'     => $request->ip(),
                    'created_user_code' => Auth::user()->employee_code
                ];

                $data = Attendance::insert($param);

            } else {

                if(!isset($check) || !$check->work_start_time) {
                    $msg = '출근 기록이 없습니다.';
                    throw new \Exception($msg);
                }

                $param = [
                    'user_id'           => Auth::user()->id,
                    'work_end_time'     => $now_time,
                    'work_end_ip'       => $request->ip(),
                    'updated_user_code' => Auth::user()->employee_code
                ];

                $data = Attendance::where('work_date', $now_date)
                    ->where('user_id', Auth::user()->id)
                    ->update($param);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => $msg, 'status' => false];
        }

        return ['data' => $data, 'message' => '등록되었습니다.', 'status' => true];
    }

    public function chart(Request $request) {
        $message = 'success';
        $status = true;

        $user_id = Auth::user()->id;

        $sql = <<<SQL
                   SELECT
                   c.tab,
                   c.day,
                   IF(
                     isnull(work_end_time_after),
                        IF(
                            TIMESTAMPDIFF(SECOND,c.work_start_time, c.work_end_time) >= 32400,
                            32400,
                            TIMESTAMPDIFF(SECOND ,c.work_start_time, c.work_end_time)
                        ),

                        IF(
                            TIMESTAMPDIFF(SECOND,c.work_start_time_after, c.work_end_time_after) >= 32400,
                            32400,
                            TIMESTAMPDIFF(SECOND ,c.work_start_time_after, c.work_end_time_after)
                        )
                   ) as 근무시간,

                   IF(
                     isnull(work_end_time_after),
                        IF(
                           TIMESTAMPDIFF(SECOND,c.work_start_time, c.work_end_time) < 32400,
                           0,
                           TIMESTAMPDIFF(SECOND,c.work_start_time, c.work_end_time) - 32400
                        ),

                        IF(
                           TIMESTAMPDIFF(SECOND,c.work_start_time_after, c.work_end_time_after) < 32400,
                           0,
                           TIMESTAMPDIFF(SECOND,c.work_start_time_after, c.work_end_time_after) - 32400
                        )
                   ) as 초과근무시간

                    from
                    (
                        SELECT
                            SUBSTR( _UTF8'일월화수목금토', DAYOFWEEK( b.date ), 1 ) as day,
                            concat(right(b.date, 2),'(',SUBSTR( _UTF8'일월화수목금토', DAYOFWEEK( b.date ), 1 ),')') as tab,
                            (SELECT c.work_start_time FROM attendances as c WHERE c.work_date = b.date and c.user_id = '${user_id}') as work_start_time,
                            (SELECT d.work_end_time FROM attendances as d WHERE d.work_date = b.date and d.user_id = '${user_id}') as work_end_time,
                            (SELECT e.work_start_time_after FROM attendances as e WHERE e.work_date = b.date and e.user_id = '${user_id}' and e.status = '승인') as work_start_time_after,
                            (SELECT f.work_end_time_after FROM attendances as f WHERE f.work_date = b.date and f.user_id = '${user_id}' and f.status = '승인') as work_end_time_after
                        from (
                            select ADDDATE( CURDATE(), - WEEKDAY(CURDATE()) + (a.a) ) as date
                            from (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6) as a
                        ) as b

                    ) as c

                    order by c.tab;

        SQL;

        $data = DB::select($sql);

        return ['data' => $data, 'message' => $message, 'status' => $status];
    }

    public function dayList(Request $request) {

        $message = 'success';
        $status = true;

        //$sql = DB::table("jgw_users as u")
        //    ->select(
        //        "u.*",
        //        "d.name as department_name",
        //        "p.position as position_name"
        //    )
        //    ->leftJoin("jgw_attendances as a", "u.id", "=", "a.user_id")->where('a.work_date', date('Y-m-d'))
        //    ->leftJoin("jgw_departments as d", "u.department_id", "=", "d.id")
        //    ->leftJoin("jgw_positions as p", "u.position_id","=", "p.id");
        //
        //$data = $sql->where('u.is_deleted', 'N')->get();

        $date = $request->work_date;

        $sql = <<<SQL
                    SELECT u.id as fk_user_id
                         , u.name
                         , a.*
                         , d.name as department_name
                         , p.position as position_name
                         ,
                           IF(
                             isnull(a.work_end_time_after)
                               , IF(
                                    isnull(a.work_end_time)
                                   ,IF(
                                       TIMESTAMPDIFF(SECOND,a.work_start_time, CURTIME()) < 32400,
                                       0,
                                       TIMESTAMPDIFF(SECOND,a.work_start_time, CURTIME()) - 32400
                                    )

                                    ,IF(
                                       TIMESTAMPDIFF(SECOND,a.work_start_time, a.work_end_time) < 32400,
                                       0,
                                       TIMESTAMPDIFF(SECOND,a.work_start_time, a.work_end_time) - 32400
                                    )
                                ),

                                IF(
                                   TIMESTAMPDIFF(SECOND,a.work_start_time_after, a.work_end_time_after) < 32400,
                                   0,
                                   TIMESTAMPDIFF(SECOND,a.work_start_time_after, a.work_end_time_after) - 32400
                                )
                           ) as diff_over_time

                    FROM users as u
                    LEFT JOIN attendances as a on u.id = a.user_id and a.work_date = '${date}'
                    LEFT JOIN departments as d on u.department_id = d.id
                    LEFT JOIN positions as p on u.position_id = p.id

                    WHERE u.is_deleted = 'N'

                    ORDER BY u.id desc
            SQL;

        $data = DB::select($sql);

        foreach ($data as $item) {
            $attachment = AttachFile::where('fk_table','users')->where('fk_id', $item->fk_user_id)->first();
            $item->attachment_path = $attachment && $attachment->file_path ? Storage::url($attachment->file_path) : "/img/profile.png";

            $min_time = '00:00:00';
            $max_time = '14:00:00';
            $default_max_time = '09:00:00';
            $item->default_rest_time = '01:00:00';
            $item->progress_work_start_time = '-';
            $item->progress_work_end_time = '-';
            $item->diff_over_time = $item->diff_over_time ? Carbon::parse($item->diff_over_time)->format("H:i:s") : '-';

            if (!$item->work_start_time) {
                // 출근전
                $item->work_state = $date < date('Y-m-d') ? '미출근' : '출근전';
                $item->work_start_time = '-';
                $item->work_end_time = '-';
                $item->work_progress_bar = 0;
                $item->work_progress_pie = 0;
                $item->progress_work_time = $min_time;
            } else {
                // 출근
                $item->work_start_time = $item->work_start_time_after && $item->status == '승인'? $item->work_start_time_after : $item->work_start_time;
                $item->work_end_time = $item->work_end_time_after && $item->status == '승인'? $item->work_end_time_after : $item->work_end_time;

                $item->sub_work_time = strtotime($item->work_end_time) - strtotime($item->work_start_time);
                $item->work_time = !$item->work_end_time  ? '-' : Carbon::parse($item->sub_work_time)->format("H:i:s");

                $item->progress_work_start_time = ($item->work_start_time_after ? $item->work_start_time_after : $item->work_start_time) ? $item->work_start_time : '-';
                $item->progress_work_end_time = ($item->work_end_time_after ? $item->work_end_time_after : $item->work_end_time) ? $item->work_end_time : '-';

                $item->work_time == '-' ? $work_state = '근무중' : $work_state = '퇴근';

                if ($work_state == '근무중') {
                    $item->work_state = $date < date('Y-m-d') ? '미퇴근' : '근무중';
                    $progress_time = strtotime(date('H:i:s')) - strtotime($item->work_start_time);
                } else {
                    $item->work_state = '퇴근';
                    $progress_time = $item->sub_work_time;
                }

                $item->progress_work_time = Carbon::parse($progress_time)->copy()->format("H:i:s");
                $set_progress_time = strtotime($max_time) - strtotime($min_time);
                $set_progress_pie_time = strtotime($default_max_time) - strtotime($min_time);

                $item->work_progress_bar = bcmul(bcdiv($progress_time, $set_progress_time, 2), 100);
                $item->work_progress_pie = bcmul(bcdiv($progress_time, $set_progress_pie_time, 2), 100);
            }
        }

        return ['data' => $data, 'message' => $message, 'status' => $status];
    }
}
