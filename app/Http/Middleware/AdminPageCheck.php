<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminPageCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // 관리자 플래그값
        $manager_flag = Auth::user()->manager;

        /*
         * 관리자 전용페이지
         * ---근태
         * 근태관리
         * 전체근태현황
         * 근태현황판
         * ---전자결재
         * 문서대장
         * ---설정
         * 사원정보 -
         * 부서정보 -
         * 직책정보 -
         * 회사정보 -
        * */
        $pages = [
            //근태
            '/attendance/page/manage',
            '/attendance/page/list',
            '/attendance/page/plate',
            //설정
            '/setting/companyInfo',
            '/setting/position',
            '/setting/department',
            '/setting/employee',
        ];

        $url = $_SERVER["REQUEST_URI"];
        if($manager_flag == 'N') {
            foreach ($pages as $item) {
                if(strpos('temp'.$url, $item)) {
                    if(strlen($url) == strlen($item)) {
                        return redirect('/')->withErrors('관리자 권한이 없습니다.');
                    } else {
                        return  response()->json(
                            [
                                'status' => false,
                                'message' => '관리자 권한이 없습니다.',
                                'data' => '/'
                            ]
                        );
                    }
                }
            }
        }

        return $next($request);
    }
}
