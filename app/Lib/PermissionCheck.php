<?php


namespace App\Lib;


use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Illuminate\Support\Facades\Auth;

class PermissionCheck
{
    // 메뉴별 상세 권한 체크

    public static function permissionLevelCheck($level) {
        $status = true;

        $pathArray = explode('?', explode($_SERVER['HTTP_HOST'], $_SERVER['HTTP_REFERER'])[1])[0];

        $menu_data = DB::table('menu')
            ->select('menu_code')
            ->where('menu_url', $pathArray)
            ->first();

        if (!$menu_data) {
            $status = false;
        }

        // 서비스 리포트 관련
        switch ($menu_data->menu_code) {
            case 'a0501000200':
                $menu_code = 'a0501000201';
                break;
            case 'a0501000202':
                $menu_code = 'a05010002000200';
                break;
            case 'a0501000300':
                $menu_code = 'a0501000301';
                break;
            case 'a0501000302':
                $menu_code = 'a05010003000200';
                break;
            default:
                $menu_code = $menu_data->menu_code;
                break;
        }

        $privilege_data = DB::table('menu_privilege')
            ->select('permission_level')
            ->where('menu_code', $menu_code)
            ->where('staff_code', Auth::user()->staff_code)
            ->first();

        if ($privilege_data->permission_level < $level) {
            $status = false;
        }

        return [
            'status'  => $status,
            'message' => '권한이 없습니다.',
        ];
    }

    public static function permissionExcelCheck($level = null) {
        $status = true;

        $staff = Auth::user()->staff_code;

        $menu_check = DB::table('menu_privilege')
            ->leftJoin('menu','menu.menu_code','menu_privilege.menu_code')
            ->select('menu.*', 'menu_privilege.menu_code', 'menu_privilege.staff_code', 'menu_privilege.permission_level')
            ->where('menu_privilege.staff_code', $staff)
            ->where('menu.menu_url', $_SERVER['REQUEST_URI'])
            ->first();

        if (!$menu_check) {
            $status = false;
        }

        $menu_level = '';
        if ($level) {
            if ($menu_check->permission_level < $level) {
                $status = false;
            }
        } else {
            $menu_level = $menu_check->permission_level;
        }

        return [
            'data'  => $menu_level,
            'status'  => $status,
            'message' => '권한이 없습니다.',
        ];
    }

}
