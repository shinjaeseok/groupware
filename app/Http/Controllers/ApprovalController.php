<?php

namespace App\Http\Controllers;

use App\Lib\FileManager;
use App\Models\Approval;
use App\Models\ApprovalComment;
use App\Models\ApprovalDocument;
use App\Models\ApprovalLine;
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

class ApprovalController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function page(Request $request) {
        return view('approval.approvalWriteStep1');
    }

    public function pageStep2(Request $request) {

        $id = $request->id;

        $approval_data = Approval::where('id', $id)->first();
        if (!$approval_data) {
            return back()->withErrors(['등록된 기안이 없습니다.']);
        }
        if ($approval_data->fk_user_id != Auth::user()->id) {
            return back()->withErrors(['작성 권한이 없습니다.']);
        }
        if ($approval_data->status != '임시') {
            return back()->withErrors(['상신된 문서입니다.']);
        }

        $user_data = User::select('name')->where('id', $approval_data->fk_user_id)->first();
        $approval_data->user_name = $user_data->name;

        $department_data = Department::select('name')->where('id', $approval_data->fk_department_id)->first();
        $approval_data->department_name = $department_data->name;

        return view('approval.approvalWriteStep2',[ 'approval_data' => $approval_data]);
    }

    public function insert(Request $request) {
        $id = $request->id;

        if (!$id) {
            return ['data' => '', 'message' => '기안 양식을 선택해주세요.', 'status' => false];
        }

        $document_data = ApprovalDocument::where('id', $id)->first();
        if (!$document_data) {
            return ['data' => '', 'message' => '기안 양식이 없습니다.', 'status' => false];
        }

        try {
            DB::beginTransaction();

            $param = [
                'fk_user_id'        => Auth::user()->id,
                'fk_department_id'  => Auth::user()->department_id,
                'fk_document_id'    => $document_data->id,
                'send_type'         => '내부',
                'document_life'     => '0',
                'emergency_type'    => 'N',
                'agreement_type'    => '순차',
                'contents'          => $document_data->contents,
                'created_user_code' => Auth::user()->employee_code,
            ];

            $id = Approval::insertGetId($param);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '등록 오류입니다.', 'status' => false];
        }

        $redirectUrl = "/approval/write_step2?id={$id}";

        return ['data' => '', 'redirect_url'=>$redirectUrl, 'message' => '저장되었습니다.', 'status' => true];
    }

    public function update(Request $request) {
        $id = $request->id;

        $approval_data = Approval::where('id', $id)->where('fk_user_id', Auth::user()->id)->first();
        if (!$approval_data) {
            return ['data' => '', 'message' => '기안 정보가 없습니다.', 'status' => false];
        }

        if ($approval_data->status != '임시') {
            return ['data' => '', 'message' => '상신된 문서입니다.', 'status' => false];
        }

        $title = $request->title;
        $contents = $request->contents;
        $approval_date = $request->approval_date;

        if (!$title) {
            return ['data' => '', 'message' => '제목을 입력해주세요.', 'status' => false];
        }

        // Fixme:: 빈 내용 체크
        if (!$contents) {
            return ['data' => '', 'message' => '내용을 입력해주세요.', 'status' => false];
        }

        if (!$approval_date) {
            return ['data' => '', 'message' => '기안일자를 입력해주세요.', 'status' => false];
        }

        $approval_line_count = ApprovalLine::where('fk_approval_id', $id)->count();

        if ($approval_line_count == 0) {
            return ['data' => '', 'message' => '결재선을 입력해주세요.', 'status' => false];
        }

        try {
            DB::beginTransaction();

            $param = [
                'title'             => $title,
                'contents'          => $contents,
                'approval_date'     => $approval_date,
                'status'            => '진행',
                'updated_user_code' => Auth::user()->employee_code,
            ];

           Approval::where('id', $id)->update($param);

           ApprovalLine::where('fk_approval_id', $id)->where('sort', 1)->update(
                [
                    'approval_status' => '가능'
                ]
            );

            // 별렬 합의 체크
            if ($approval_data->agreement_type == '병렬') {

                for ($i = 2; $i <= $approval_line_count; $i++) {
                    $approval_line_data = ApprovalLine::where('fk_approval_id', $id)->where('sort', $i)->first();

                    if (!$approval_line_data) {
                        break;
                    }

                    if ($approval_line_data->approval_type != '합의') {
                        break;
                    }

                   ApprovalLine::where('fk_approval_id', $id)->where('sort', $i)->update(
                        [
                            'approval_status' => '가능'
                        ]
                    );
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '등록 오류입니다.', 'status' => false];
        }

        $redirectUrl = "/approval/writeList";

        return ['data' => '', 'redirect_url'=>$redirectUrl, 'message' => '저장되었습니다.', 'status' => true];
    }

    public function tempUpdate(Request $request) {
        $id = $request->id;

        $approval_data = Approval::where('id', $id)->where('fk_user_id', Auth::user()->id)->first();
        if (!$approval_data) {
            return ['data' => '', 'message' => '기안 정보가 없습니다.', 'status' => false];
        }

        if ($approval_data->status != '임시') {
            return ['data' => '', 'message' => '상신된 문서입니다.', 'status' => false];
        }

        $title = $request->title;
        $contents = $request->contents;
        $approval_date = $request->approval_date;

        try {
            DB::beginTransaction();

            $param = [
                'title'             => $title,
                'contents'          => $contents,
                'approval_date'     => $approval_date,
                'status'            => '임시',
                'updated_user_code' => Auth::user()->employee_code,
            ];

           Approval::where('id', $id)->update($param);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '등록 오류입니다.', 'status' => false];
        }

        $redirectUrl = "/approval/tempList";

        return ['data' => '', 'redirect_url'=>$redirectUrl, 'message' => '저장되었습니다.', 'status' => true];
    }

    public function tempDelete(Request $request) {

        $approval_id = $request->id;

        try {
            DB::beginTransaction();

            Approval::where('id', $approval_id)->delete();
            ApprovalLine::where('fk_approval_id', $approval_id)->delete();
            ApprovalComment::where('fk_approval_id', $approval_id)->delete();
            FileManager::fileDelete('approval', $approval_id);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '삭제 오류입니다.', 'status' => false];
        }

        return ['data' => '', 'message' => '삭제 되었습니다.', 'status' => true];
    }

    public function infoUpdate(Request $request) {

        $approval_id = $request->modal_id;
        if (!$approval_id) {
            return ['data' => '', 'message' => '기안 양식을 선택해주세요.', 'status' => false];
        }

        $approval_data = Approval::where('id', $approval_id)->where('fk_user_id', Auth::user()->id)->first();
        if (!$approval_data) {
            return ['data' => '', 'message' => '작성중인 기안이 없습니다.', 'status' => false];
        }

        $send_type = $request->send_type;
        $emergency_type = $request->emergency_type;
        $document_life = $request->document_life;
        $agreement_type = $request->agreement_type;

        try {
            DB::beginTransaction();

            $param = [
                'send_type' => $send_type,
                'emergency_type' => $emergency_type,
                'document_life' => $document_life,
                'agreement_type' => $agreement_type,
                'updated_user_code' => Auth::user()->employee_code,
            ];

            $result = Approval::where('id', $approval_id)->update($param);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '등록 오류입니다.', 'status' => false];
        }

        return ['data' => $result, 'message' => '저장되었습니다.', 'status' => true];
    }

    public function infoSelect(Request $request) {
        $approval_id = $request->id;
        if (!$approval_id) {
            return ['data' => '', 'message' => '기안 정보가 없습니다.', 'status' => false];
        }

        $sql = DB::table("approvals as a")
            ->select(
                "a.*",
                "u.name as user_name",
                "d.name as department_name"
            )
            ->leftJoin("users as u", "a.fk_user_id", "=", "u.id")
            ->leftJoin("departments as d", "a.fk_department_id", "=", "d.id");

        $approval_data = $sql->where('a.id', $approval_id)->first();

        if (!$approval_data) {
            return ['data' => '', 'message' => '기안 정보가 없습니다.', 'status' => false];
        }

        $auth_user_approval_line_data = ApprovalLine::where('fk_approval_id', $approval_id)->where('fk_user_id', Auth::user()->id)->first();

        if ($auth_user_approval_line_data) {
            $approval_data->auth_user_approval_line_data = $auth_user_approval_line_data;
        }

        return ['data' => $approval_data, 'message' => '', 'status' => true];
    }

    public function lineSelect(Request $request) {
        $approval_id = $request->id;
        if (!$approval_id) {
            return ['data' => '', 'message' => '기안 정보가 없습니다.', 'status' => false];
        }

        $approval_line_data = DB::table("approval_lines as l")
            ->select(
                "l.*",
                "u.name as user_name",
            )
            ->leftJoin("users as u", "l.fk_user_id", "=", "u.id")
            ->where('l.fk_approval_id', $approval_id)
            ->orderBy('sort')
            ->get();

        if (count($approval_line_data) == 0) {
            return ['data' => '', 'message' => '기안 정보가 없습니다.', 'status' => false];
        }

        return ['data' => $approval_line_data, 'message' => '', 'status' => true];
    }

    public function approvalDepartmentTree(Request $request) {

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
                    SELECT *
                    FROM TEMP
                    ORDER BY path ASC
            SQL;

        $list = DB::select($sql);

        if(!$list) {
            $message = 'no data';
            $status = false;
        }

        $data=[];
        foreach ($list as $item) {
            if ($item->parent_id == NULL) {
                $item->parent_id = '#';
            }

            $data[] = $item;
        }

        return json_encode($data);
    }

    public function approvalDepartmentUserList(Request $request) {
        $message = 'success';
        $status = true;

        $search_key = $request->search_key;
        $search_value = $request->search_value;

        $sql = DB::table("users as u")
            ->select(
                "u.*",
                "d.name as department_name",
                "p.position as position_name"
            )
            ->leftJoin("departments as d", "u.department_id", "=", "d.id")
            ->leftJoin("positions as p", "u.position_id","=", "p.id");

        if($search_key == "name")
            $sql->where('u.name','like', '%'.$search_value.'%');
        else if($search_key == "department")
            $sql->where('d.name', 'like', '%'.$search_value.'%');
        else if ($request->id)
            $sql->where('d.id', $request->id);

        $user_list = $sql->where('u.is_deleted', 'N')->orderByDesc('u.id')->get();


        if(!$user_list) {
            $message = 'no data';
            $status = false;
        }

        foreach ($user_list as $item) {

            $item->attachment_path = '';

            $attachment = AttachFile::where('fk_table','users')->where('fk_id', $item->id)->first();

            $item->attachment_path = $attachment && $attachment->file_path ? Storage::url($attachment->file_path) : "/img/profile.png";
        }

        return ['data' => $user_list, 'message' => $message, 'status' => $status];
    }


    public function lineInsert(Request $request) {
        $approval_id = $request->approval_id;

        if (!$approval_id) {
            return ['data' => '', 'message' => '기안 정보가 없습니다.', 'status' => false];
        }

        $approval_type = $request->approval_type;
        if (!$approval_type) {
            return ['data' => '', 'message' => '결재선이 없습니다.', 'status' => false];
        }

        if (end($approval_type) == '합의') {
            return ['data' => '', 'message' => '마지막 결재는 합의가 될 수 없습니다.', 'status' => false];
        }

        $approval_user_id = $request->approval_user_id;

        if (count($approval_user_id) != count(array_unique($approval_user_id))) {
            return ['data' => '', 'message' => '중복된 결재자가 있습니다.', 'status' => false];
        }

        try {
            DB::beginTransaction();

            $before_line = ApprovalLine::where('fk_approval_id', $approval_id)->get();
            if ($before_line) {
               ApprovalLine::where('fk_approval_id', $approval_id)->delete();
            }

            $insert_array = [];

            for ($i=0; $i < count($approval_type); $i++) {
                array_push($insert_array,
                           [
                               'fk_approval_id'    => $approval_id,
                               'fk_user_id'        => $approval_user_id[$i],
                               'approval_type'     => $approval_type[$i],
                               'sort'              => $i + 1,
                               'created_user_code' => Auth::user()->employee_code,
                           ]
                );
            }

            $result = ApprovalLine::insert($insert_array);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '등록 오류입니다.', 'status' => false];
        }

        return ['data' => $result, 'message' => '저장되었습니다.', 'status' => true];
    }

    public function commentInsert(Request $request) {
        $approval_id = $request->approval_id;
        if (!$approval_id) {
            return ['data' => '', 'message' => '기안 정보가 없습니다.', 'status' => false];
        }

        $comment = $request->comment;
        if (!$comment) {
            return ['data' => '', 'message' => '의견 내용이 없습니다.', 'status' => false];
        }

        $user_id = Auth::user()->id;

        try {
            $comment_count = ApprovalComment::where('fk_approval_id', $approval_id)->count();

            DB::beginTransaction();

            $param = [
                'fk_approval_id'    => $approval_id,
                'sort'              => $comment_count + 1,
                'fk_user_id'        => $user_id,
                'comments'          => $comment,
                'created_user_code' => Auth::user()->employee_code,
            ];

            $result = ApprovalComment::insert($param);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '등록 오류입니다.', 'status' => false];
        }

        return ['data' => $result, 'message' => '저장되었습니다.', 'status' => true];
    }

    public function commentSelect(Request $request) {
        $approval_id = $request->id;
        if (!$approval_id) {
            return ['data' => '', 'message' => '기안 정보가 없습니다.', 'status' => false];
        }

        $approval_comment_data = DB::table("approval_comments as c")
            ->select(
                "c.*",
                "u.name as user_name",
                "d.name as department_name",
                "p.position as position_name"
            )
            ->leftJoin("users as u", "c.fk_user_id", "=", "u.id")
            ->leftJoin("departments as d", "u.department_id", "=", "d.id")
            ->leftJoin("positions as p", "u.position_id","=", "p.id")
            ->where('c.fk_approval_id', $approval_id)
            ->orderBy('c.sort')
            ->get();

        if (count($approval_comment_data) == 0) {
            return ['data' => '', 'message' => '기안 정보가 없습니다.', 'status' => false];
        }

        foreach ($approval_comment_data as $item) {
            $permission = false;
            if ($item->fk_user_id == Auth::user()->id) {
                $permission = true;
                $approval_line_data = ApprovalLine::where('fk_approval_id', $approval_id)->where('fk_user_id', Auth::user()->id)->first();

                if ($approval_line_data && $approval_line_data->approval_status == '완료') {
                    $permission = false;
                }
            }

            $item->permission = $permission;

            $item->attachment_path = '';

            $attachment = AttachFile::where('fk_table','users')->where('fk_id', $item->fk_user_id)->first();

            $item->attachment_path = $attachment && $attachment->file_path ? Storage::url($attachment->file_path) : "/img/profile.png";
        }

        return ['data' => $approval_comment_data, 'message' => '', 'status' => true];
    }

    public function commentDelete(Request $request) {
        $id = $request->id;

        $data = ApprovalComment::where('id', $id)->first();
        if (!$data) {
            return ['data' => '', 'message' => '의견 정보가 없습니다.', 'status' => false];
        }

        try {
            DB::beginTransaction();

            $data = ApprovalComment::where('id', $id)->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '등록 오류입니다.', 'status' => false];
        }

        return ['data' => $data, 'message' => '삭제 되었습니다.', 'status' => true];
    }

    public function writeListPage(Request $request) {
        return view('approval.approvalWriteList');
    }

    public function writeList(Request $request, $type = '') {

        $query = Approval::where('fk_user_id', Auth::user()->id);

        if ($type == 'Proceeding') {
            $status = '진행';
        } else if ($type == 'approval') {
            $status = '완료';
        } else {
            $status = '반려';
        }

        if ($type == 'all') {
            $query->where('status', '!=', '임시');
        } else {
            $query->where('status', $status);
        }

        if ($request->search_value) {
            $query->where($request->search_type, 'like', '%'.$request->search_value.'%');
        }

        $result = $query->orderByDesc('id')->get();

        foreach ($result as $item) {
            $attach_files_count = AttachFile::where('fk_table', 'approval')->where('fk_id', $item['id'])->count();

            $item->attach_file_status = 'N';
            if ($attach_files_count > 0) {
                $item->attach_file_status = 'Y';
            }

            $document_data = ApprovalDocument::select('division')->where('id', $item->fk_document_id)->first();

            $item->document_division = $document_data->division;
        }

        return json_encode($result);
    }

    public function tempListPage(Request $request) {
        return view('approval.approvalTempList');
    }

    public function tempList(Request $request) {

        $query = Approval::where('fk_user_id', Auth::user()->id)->where('status', '임시');

        if ($request->search_value) {
            $query->where($request->search_type, 'like', '%'.$request->search_value.'%');
        }

        $result = $query->orderByDesc('id')->get();

        foreach ($result as $item) {
            $attach_files_count = AttachFile::where('fk_table', 'approval')->where('fk_id', $item['id'])->count();

            $item['attach_file_status'] = 'N';
            if ($attach_files_count > 0) {
                $item['attach_file_status'] = 'Y';
            }

            $document_data = ApprovalDocument::select('division')->where('id', $item->fk_document_id)->first();

            $item->document_division = $document_data->division;
        }

        return json_encode($result);
    }

    public function approvalListPage(Request $request) {
        return view('approval.approvalList');
    }

    public function approvalList(Request $request, $type = null) {

        $query = DB::table("approval_lines as l")
            ->select(
                "l.*",
                "a.id as approval_id",
                "a.fk_user_id as approval_user_id",
                "a.fk_department_id as approval_department_id",
                "a.fk_document_id",
                "a.emergency_type",
                "a.approval_date",
                "a.title",
                "a.contents",
                "a.status",
                "a.document_no",
            )
            ->leftJoin("approvals as a", "l.fk_approval_id", "=", "a.id");

        $status = '';
        if ($type == 'waiting') {
            $status = '가능';
        } else if ($type == 'complete') {
            $status = '완료';
        }

        if ($type == 'all') {
            $query->where('l.approval_status', '!=', '대기');
        } else {
            $query->where('l.approval_status', $status);
        }

        $result = $query->where('l.fk_user_id', Auth::user()->id)->whereNotIn('a.status',['임시'])->orderByDesc('id')->get();

        foreach ($result as $item) {
            $attach_files_count = AttachFile::where('fk_table', 'approval')->where('fk_id', $item->approval_id)->count();

            $item->attach_file_status = 'N';
            if ($attach_files_count > 0) {
                $item->attach_file_status = 'Y';
            }

            $document_data = ApprovalDocument::select('division')->where('id', $item->fk_document_id)->first();

            $item->document_division = $document_data->division;
        }

        return json_encode($result);
    }

    public function approvalLineStateChangeAdmit(Request $request){

        $approval_id = $request->approval_id;
        $user_id = Auth::user()->id;

        $approval_data = Approval::where('id', $approval_id)->first();

        $this_approval_line_data = ApprovalLine::where('fk_approval_id', $approval_id)->where('fk_user_id', $user_id)->first();


        if (!$this_approval_line_data) {
            return ['data' => '', 'message' => '결재선 정보가 없습니다.', 'status' => false];
        }

        if ($this_approval_line_data->approval_status != '가능') {
            return ['data' => '', 'message' => '결재 권한이 없습니다.', 'status' => false];
        }

        if ($this_approval_line_data->approval_result != '대기') {
            return ['data' => '', 'message' => '기결재 된 기안입니다.', 'status' => false];
        }

        try {
            DB::beginTransaction();

            // 본인 승인
           ApprovalLine::where('fk_approval_id', $approval_id)->where('fk_user_id', $user_id)->update(
                [
                    'approval_status'   => '완료',
                    'approval_result'   => '승인',
                    'updated_user_code' => Auth::user()->employee_code,
                ]
            );

            $next_approval_line_data = ApprovalLine::where('fk_approval_id', $approval_id)->where('sort', $this_approval_line_data->sort + 1)->first();

            if (!$next_approval_line_data) {


                //문서번호
                $approval_document_no_max = Approval::where('approval_date', 'like', date('Y').'%')->max('document_no');
                $num = sprintf('%06d',substr($approval_document_no_max, 5,6) + 1);
                $document_no = date('Y').'-'.$num;

               Approval::where('id', $approval_id)->update(
                    [
                        'document_no'       => $document_no,
                        'status'            => '완료',
                        'updated_user_code' => Auth::user()->employee_code,
                    ]
                );

                $message = '최종 승인 처리 되었습니다.';
            } else {
                $approval_line_total_count = ApprovalLine::where('fk_approval_id', $approval_id)->count();

                /*
                 * 병렬인 경우
                 * ㄴ 내가 합의자인 경우
                 *      ㄴ 합의자 전체 체크 후 다음 상태 값 가능으로 변경
                 *
                 * ㄴ 내가 합의자가 아닌 경우
                 *      ㄴ 다음 결재자 체크
                 *          ㄴ 다음 결재자가 합의자인 경우
                 *              ㄴ 합의자 전체 상태 값 가능으로 변경
                 *          ㄴ 다음 결재자가 합의자가 아닌 경우
                 *              ㄴ 다음 상태 값 가능으로 변경
                 * */

                /*
                 * 병렬이 아닌 경우
                 * ㄴ 다음 상태 값 가능으로 변경
                 * */

                if ($approval_data->agreement_type == '병렬') {
                    if ($this_approval_line_data->approval_type == '합의') {
                        $approval_type_last_data = ApprovalLine::where('fk_approval_id', $approval_id)
                            ->select('sort')
                            ->where('approval_type', '합의')
                            ->orderByDesc('sort')
                            ->first();
                        $agreement_count = ApprovalLine::where('fk_approval_id', $approval_id)
                            ->where('approval_type', '합의')
                            ->where('approval_status', '가능')
                            ->where('sort', '<=',$approval_type_last_data->sort)
                            ->count();

                        if ($agreement_count == 0) {
                           ApprovalLine::where('fk_approval_id', $approval_id)->where('sort', $approval_type_last_data->sort + 1)->update(
                                [
                                    'approval_status'   => '가능',
                                    'updated_user_code' => Auth::user()->employee_code,
                                ]
                            );
                        }
                    } else {
                        if ($next_approval_line_data->approval_type == '합의') {
                            for ($i = $next_approval_line_data->sort; $i <= $approval_line_total_count; $i++) {

                                $approval_line_sort_data = ApprovalLine::where('fk_approval_id', $approval_id)->where('sort',$i)->first();

                                if ($approval_line_sort_data->approval_type == '합의' && $approval_line_sort_data->approval_status == '대기') {
                                   ApprovalLine::where('fk_approval_id', $approval_id)->where('sort', $i)->update(
                                        [
                                            'approval_status'   => '가능',
                                            'updated_user_code' => Auth::user()->employee_code,
                                        ]
                                    );
                                } else {
                                    break;
                                }
                            }
                        } else {
                           ApprovalLine::where('fk_approval_id', $approval_id)->where('sort', $next_approval_line_data->sort)->update(
                                [
                                    'approval_status'   => '가능',
                                    'updated_user_code' => Auth::user()->employee_code,
                                ]
                            );
                        }
                    }
                } else {
                   ApprovalLine::where('fk_approval_id', $approval_id)->where('sort', $next_approval_line_data->sort)->update(
                        [
                            'approval_status'   => '가능',
                            'updated_user_code' => Auth::user()->employee_code,
                        ]
                    );
                }

                $message = '승인 처리 되었습니다.';
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '등록 오류입니다.', 'status' => false];
        }

        return ['data' => '', 'message' => $message, 'status' => true];
    }

    public function approvalLineStateChangeDeny(Request $request){
        $approval_id = $request->approval_id;
        $user_id = Auth::user()->id;

        $approval_line_data = ApprovalLine::where('fk_approval_id', $approval_id)->where('fk_user_id', $user_id)->first();

        if (!$approval_line_data) {
            return ['data' => '', 'message' => '결재선 정보가 없습니다.', 'status' => false];
        }

        if ($approval_line_data->approval_status != '가능') {
            return ['data' => '', 'message' => '결재 권한이 없습니다.', 'status' => false];
        }

        if ($approval_line_data->approval_result != '대기') {
            return ['data' => '', 'message' => '기결재 된 기안입니다.', 'status' => false];
        }

        try {
            DB::beginTransaction();

           ApprovalLine::where('fk_approval_id', $approval_id)->where('fk_user_id', $user_id)->update(
                [
                    'approval_status'   => '완료',
                    'approval_result'   => '반려',
                    'updated_user_code' => Auth::user()->employee_code,
                ]
            );

            if ($approval_line_data->approval_type == '합의') {
               ApprovalLine::where('fk_approval_id', $approval_id)->where('approval_type', '합의')->where('approval_status', '가능')->update(
                    [
                        'approval_status'   => '대기',
                        'approval_result'   => '대기',
                        'updated_user_code' => Auth::user()->employee_code,
                    ]
                );
            }

           Approval::where('id', $approval_id)->update(
                [
                    'status'            => '반려',
                    'updated_user_code' => Auth::user()->employee_code,
                ]
            );

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '등록 오류입니다.', 'status' => false];
        }

        return ['data' => '', 'message' => '반려되었습니다.', 'status' => true];
    }

    public function approvalLineStateChangeCancel(Request $request){
        $approval_id = $request->approval_id;
        $user_id = Auth::user()->id;

        $approval_data = Approval::where('id', $approval_id)->first();
        if (!$approval_data) {
            return ['data' => '', 'message' => '기안 정보가 없습니다.', 'status' => false];
        }

        if ($approval_data->status != '진행') {
            return ['data' => '', 'message' => '결재상태가 진행중일 때 결재 취소가 가능합니다.', 'status' => false];
        }

        $approval_line_data = ApprovalLine::where('fk_approval_id', $approval_id)->where('fk_user_id', $user_id)->first();

        if (!$approval_line_data) {
            return ['data' => '', 'message' => '결재선 정보가 없습니다.', 'status' => false];
        }

        if ($approval_line_data->approval_status != '완료') {
            return ['data' => '', 'message' => '결재한 내역이 없습니다.', 'status' => false];
        }

        $next_approval_line_data = ApprovalLine::where('fk_approval_id', $approval_id)->where('sort', $approval_line_data->sort + 1)->first();

        if (!$next_approval_line_data) {
            return ['data' => '', 'message' => '마지막 결재선은 취소가 불가능합니다.', 'status' => false];
        }

        if ($next_approval_line_data->approval_status == '완료') {
            return ['data' => '', 'message' => '다음 결재자가 결재하였습니다. 결재 이전에 취소할 수 있습니다.', 'status' => false];
        }

        $approval_line_count = ApprovalLine::where('fk_approval_id', $approval_id)->count();

        try {
            DB::beginTransaction();

           ApprovalLine::where('fk_approval_id', $approval_id)->where('fk_user_id', $user_id)->update(
                [
                    'approval_status'   => '가능',
                    'approval_result'   => '대기',
                    'updated_user_code' => Auth::user()->employee_code,
                ]
            );

            for ($i = $approval_line_data->sort + 1; $i <= $approval_line_count ; $i++) {
               ApprovalLine::where('fk_approval_id', $approval_id)->where('sort', $i)->update(
                    [
                        'approval_status'   => '대기',
                        'approval_result'   => '대기',
                        'updated_user_code' => Auth::user()->employee_code,
                    ]
                );
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '등록 오류입니다.', 'status' => false];
        }

        return ['data' => '', 'message' => '결재가 취소되었습니다.', 'status' => true];
    }

    public function attachInsert(Request $request) {
        $approval_id = $request->approval_id;
        if (!$approval_id) {
            return ['data' => '', 'message' => '기안 정보가 없습니다.', 'status' => false];
        }

        $files = $request->file('attach_file');
        if (!$files) {
            return ['data' => '', 'message' => '첨부파일이 없습니다.', 'status' => false];
        }

        try {
            DB::beginTransaction();

            $result = FileManager::fileUpload($files, $approval_id, 'approval', 'public/approval');

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '등록 오류입니다.', 'status' => false];
        }

        return ['data' => $result, 'message' => '저장되었습니다.', 'status' => true];
    }

    public function attachSelect(Request $request) {
        $approval_id = $request->approval_id;

        if (!$approval_id) {
            return ['data' => '', 'message' => '기안 정보가 없습니다.', 'status' => false];
        }

        $attachment = AttachFile::where('fk_table', 'approval')->where('fk_id', $approval_id)->get();

        if (count($attachment) == 0) {
            return ['data' => '', 'message' => '파일이 없습니다.', 'status' => false];
        }

        foreach ($attachment as $item) {
        }

        return ['data' => $attachment, 'message' => '', 'status' => true];
    }

    public function attachDelete(Request $request) {
        $id = $request->id;
        if (!$id) {
            return ['data' => '', 'message' => '파일 정보가 없습니다.', 'status' => false];
        }

        try {
            DB::beginTransaction();

            $prev_attach_file_data = AttachFile::where('fk_table', 'approval')->where('id', $id)->first();

            if ($prev_attach_file_data) {
                Storage::delete($prev_attach_file_data->file_path);
                AttachFile::where('fk_table', 'approval')->where('id', $id)->delete();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '삭제 오류입니다.', 'status' => false];
        }

        return ['data' => '', 'message' => '삭제되었습니다.', 'status' => true];
    }

    public function approvalLineStateChangeRetrieve(Request $request) {
        $approval_id = $request->approval_id;
        if (!$approval_id) {
            return ['data' => '', 'message' => '기안 정보가 없습니다.', 'status' => false];
        }

        $approval_data = Approval::where('id', $approval_id)->where('fk_user_id', Auth::user()->id)->first();
        if (!$approval_data) {
            return ['data' => '', 'message' => '기안 정보가 없습니다.', 'status' => false];
        }

        if ($approval_data->status == '완료') {
            return ['data' => '', 'message' => '결재 완료처리된 문서는 회수가 불가합니다.', 'status' => false];
        } else if ($approval_data->status == '진행') {
            $approval_line_confirm_count = ApprovalLine::where('fk_approval_id', $approval_id)->where('approval_status', '완료')->count();

            if ($approval_line_confirm_count > 0) {
                return ['data' => '', 'message' => '승인된 내역이 있는 문서는 회수가 불가능합니다.', 'status' => false];
            }
        }

        try {
            DB::beginTransaction();

            $param = [
                'status'            => '임시',
                'updated_user_code' => Auth::user()->employee_code,
            ];

           Approval::where('id', $approval_id)->update($param);

            $before_line = ApprovalLine::where('fk_approval_id', $approval_id)->get();

            foreach ($before_line as $item) {
                $status = '대기';
                if($item->sort == 1) {
                    $status = '가능';
                }

                $param = [
                    'approval_status' => $status,
                    'approval_result' => '대기',
                ];

               ApprovalLine::where('fk_approval_id', $approval_id)->where('fk_user_id', $item->fk_user_id)->update($param);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '등록 오류입니다.', 'status' => false];
        }

        return ['data' => '', 'message' => '회수되었습니다.', 'status' => true];
    }
}
