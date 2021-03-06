<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DepartmentController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function page(Request $request)
    {
        return view('setting.department');
    }

    public function list(Request $request)
    {
        $message = 'success';
        $status = true;

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
        $space = '';
        foreach ($list as $item) {
            $space = str_repeat('&nbsp', ($item->depth-1) * 4);
            $item->name = "${space}???$item->name";
            $data[] = $item;
        }

        return ['data' => $data, 'message' => $message, 'status' => $status];
    }


    public function insert(Request $request)
    {
        $name = $request->modal_name;
        $sort = $request->modal_sort;
        $status = $request->modal_status;
        $parent_id = $request->modal_parent_id;

        try {
            DB::beginTransaction();

            //??????
            $param = [
                'name' => $name,
                'sort' => $sort,
                'status' => $status,
                'parent_id' => $parent_id,
                'created_user_code' => Auth::user()->employee_code
            ];

            $data = Department::insert($param);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '?????? ???????????????.', 'status' => false];
        }

        return ['data' => $data, 'message' => '?????? ???????????????.', 'status' => true];
    }

    public function select(Request $request)
    {
        $id = $request->id;
        $data = Department::where('id', $id)->first();

        if (!$data) {

            return ['data' => '', 'message' => '???????????? ????????????.', 'status' => false];
        }

        return ['data' => $data, 'message' => '', 'status' => true];
    }

    public function update(Request $request)
    {
        // ?????? ??????
        $id = $request->modal_id;
        $name = $request->modal_name;
        $sort = $request->modal_sort;
        $status = $request->modal_status;
        $parent_id = $request->modal_parent_id;

        try {
            DB::beginTransaction();

            //??????
            $param = [
                'name' => $name,
                'sort' => $sort,
                'status' => $status,
                'parent_id' => $parent_id,
                'updated_user_code' => Auth::user()->employee_code
            ];

            $data = Department::where('id', $id)->update($param);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '?????? ???????????????.', 'status' => false];
        }

        return ['data' => $data, 'message' => '?????????????????????.', 'status' => true];
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $data = Department::where('id', $id)->first();

        if (!$data) {
            return ['data' => '', 'message' => '???????????? ????????????.', 'status' => false];
        }

        $data = Department::where('parent_id', $id)->first();

        if ($data) {
            return ['data' => '', 'message' => '??????????????? ???????????????.', 'status' => false];
        }

        try {
            DB::beginTransaction();

            // ??????
            $data = Department::where('id', $id)->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{".$e->getFile()."} : {".$e->getMessage()."} => {".$e->getLine()."}");

            return ['data' => '', 'message' => '?????? ???????????????.', 'status' => false];
        }


        return ['data' => $data, 'message' => '?????? ???????????????.', 'status' => true];
    }
}
