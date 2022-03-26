<?php

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\ApprovalDocumentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\CompanyInfoController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarController;

/*
|--------------------------------------------------------------------------
| ROUTE 기본 규칙
|--------------------------------------------------------------------------
|
| 페이지 이동 : URL naming = 해당 URL, function naming = page
| 목록 : URL naming = URL + /list, function naming = list
| 입력 : URL naming = URL + /insert , function naming = insert
| 선택 : URL naming = URL + /select , function naming = select
| 수정 : URL naming = URL + /update , function naming = update
| 삭제 : URL naming = URL + /delete , function naming = delete
|
*/

// 로그인
Route::get('/login',[LoginController::class, 'loginPage'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::middleware(['auth', 'admin'])->group(
    function () {
        // 홈
        Route::get('/', [MainController::class, 'page']);
        Route::get('/approvalCheck', [MainController::class, 'approvalCheck']);
        Route::get('/todoList/list', [MainController::class, 'todoList']);
        Route::post('/todoList/insert', [MainController::class, 'todoListInsert']);
        Route::post('/todoList/update', [MainController::class, 'todoListUpdate']);
        Route::post('/todoList/delete', [MainController::class, 'todoListDelete']);

        // 로그아웃
        Route::get('/logout',[LoginController::class, 'logout']);


        /*
        |--------------------------------------------------------------------------
        | 공통
        |--------------------------------------------------------------------------
        |
        | 공통 :: GlobalController
        |
        */

        Route::get('/fileDownload/{id}',[GlobalController::class, 'fileDownload']);


        /*
        |--------------------------------------------------------------------------
        | 근태
        |--------------------------------------------------------------------------
        |
        | 근태 :: AttendanceController
        |
        */

        // 근태
        Route::get('/attendance', [AttendanceController::class, 'page']);
        Route::get('/attendance/list', [AttendanceController::class, 'list']);
        Route::get('/attendance/select', [AttendanceController::class, 'select']);
        Route::post('/attendance/update', [AttendanceController::class, 'update']);

        // 근태관리
        Route::get('/attendance/page/manage', [AttendanceController::class, 'managePage']);

        // 전체근태현황
        Route::get('/attendance/page/list', [AttendanceController::class, 'listPage']);

        // 근태현황판
        Route::get('/attendance/page/plate', [AttendanceController::class, 'platePage']);
        Route::get('/attendance/info', [AttendanceController::class, 'info']);

        // 메인 출퇴근 시간
        Route::get('/attendance/work_time', [AttendanceController::class, 'workTime']);
        Route::post('/attendance/work', [AttendanceController::class, 'work']);
        Route::get('/attendance/chart', [AttendanceController::class, 'chart']);

        //일별근태현황
        Route::get('/attendance/page/day_list', [AttendanceController::class, 'dayListPage']);
        Route::get('/attendance/day_list', [AttendanceController::class, 'dayList']);


        /*
        |--------------------------------------------------------------------------
        | 일정
        |--------------------------------------------------------------------------
        |
        | 일정 :: CalendarController
        |
        */

        Route::get('/calendar/calendar', [CalendarController::class, 'page']);
        Route::get('/calendar/calendar/list', [CalendarController::class, 'list']); // calendar list
        Route::post('/calendar/calendar/insert', [CalendarController::class, 'insert']); // calendar insert
        Route::post('/calendar/calendar/update', [CalendarController::class, 'update']); // calendar update
        Route::post('/calendar/calendar/delete', [CalendarController::class, 'delete']); // calendar delete
        Route::get('/calendar/calendar/childList', [CalendarController::class, 'childList']); // calendar child list
        Route::post('/calendar/calendar/calendarKindChildInsert', [CalendarController::class, 'calendarKindChildInsert']); // calendar child list
        Route::get('/calendar/calendar/calendarKindChildSelect', [CalendarController::class, 'calendarKindChildSelect']); // calendar child list
        Route::post('/calendar/calendar/calendarKindChildUpdate', [CalendarController::class, 'calendarKindChildUpdate']); // calendar child list
        Route::post('/calendar/calendar/calendarKindChildDelete', [CalendarController::class, 'calendarKindChildDelete']); // calendar child list


        /*
        |--------------------------------------------------------------------------
        | 전자결재
        |--------------------------------------------------------------------------
        |
        | 기안작성 :: ApprovalController
        | 기안함 :: ApprovalController
        | 임시저장함 :: ApprovalController
        | 결재함 :: ApprovalController
        | 문서대장 :: ApprovalDocumentController
        |
        */

        // 기안작성
        Route::get('/approval/write', [ApprovalController::class, 'page']);
        Route::get('/approval/write_step2', [ApprovalController::class, 'pageStep2']);

        // 기안 상신
        Route::post('/approval/write/insert', [ApprovalController::class, 'insert']); // 기안 생성
        Route::post('/approval/write/update', [ApprovalController::class, 'update']); // 기안 상신
        Route::post('/approval/write/tempUpdate', [ApprovalController::class, 'tempUpdate']); // 기안 임시저장
        Route::post('/approval/write/tempDelete', [ApprovalController::class, 'tempDelete']); // 기안 삭제 (임시저장함에서만 삭제)
        Route::post('/approval/approvalLineStateChangeAdmit', [ApprovalController::class, 'approvalLineStateChangeAdmit']); // 기안 승인
        Route::post('/approval/approvalLineStateChangeDeny', [ApprovalController::class, 'approvalLineStateChangeDeny']); // 기안 반려
        Route::post('/approval/approvalLineStateChangeCancel', [ApprovalController::class, 'approvalLineStateChangeCancel']); // 결재 취소
        Route::post('/approval/approvalLineStateChangeRetrieve', [ApprovalController::class, 'approvalLineStateChangeRetrieve']); // 기안 회수

        // 기안 정보 관련
        Route::post('/approval/write/info/update', [ApprovalController::class, 'infoUpdate']); // 기안 정보 수정
        Route::get('/approval/write/info/select', [ApprovalController::class, 'infoSelect']); // 기안 정보 조회

        // 기안 결재선 관련
        Route::post('/approval/write/line/insert', [ApprovalController::class, 'lineInsert']); // 결재선 저장
        Route::get('/approval/write/line/select', [ApprovalController::class, 'lineSelect']); // 결재선 저장 목록 조회
        Route::get('/approval/approvalDepartmentTree', [ApprovalController::class, 'approvalDepartmentTree']); // 결재선 Tree
        Route::get('/approval/approvalDepartmentUserList', [ApprovalController::class, 'approvalDepartmentUserList']); // 결재선 목록

        // 기안 의견 관련
        Route::post('/approval/write/comment/insert', [ApprovalController::class, 'commentInsert']); // 의견 저장
        Route::post('/approval/write/comment/update', [ApprovalController::class, 'commentUpdate']); // 의견 수정
        Route::post('/approval/write/comment/delete', [ApprovalController::class, 'commentDelete']); // 의견 삭제
        Route::get('/approval/write/comment/select', [ApprovalController::class, 'commentSelect']); // 의견 조회

        // 첨부파일 관련
        Route::post('/approval/write/attachFile/insert', [ApprovalController::class, 'attachInsert']); // 첨부파일 저장
        Route::post('/approval/write/attachFile/delete', [ApprovalController::class, 'attachDelete']); // 첨부파일 삭제
        Route::get('/approval/write/attachFile/select', [ApprovalController::class, 'attachSelect']); // 첨부파일 조회


        // 기안함
        Route::get('/approval/writeList', [ApprovalController::class, 'writeListPage']); // approval write page
        Route::get('/approval/writeList/list/{type?}', [ApprovalController::class, 'writeList']); // approval write list

        // 임시저장함
        Route::get('/approval/tempList', [ApprovalController::class, 'tempListPage']); // temp_list
        Route::get('/approval/tempList/list', [ApprovalController::class, 'tempList']); // temp_list list

        // 결재함
        Route::get('/approval/approvalList', [ApprovalController::class, 'approvalListPage']); // list
        Route::get('/approval/approvalList/list/{type?}', [ApprovalController::class, 'approvalList']); // approval list list

        // 문서대장
        Route::get('/approval/document', [ApprovalDocumentController::class, 'page']);
        Route::get('/approval/document/list', [ApprovalDocumentController::class, 'list']); // document list
        Route::post('/approval/document/insert', [ApprovalDocumentController::class, 'insert']); // document insert
        Route::get('/approval/document/select', [ApprovalDocumentController::class, 'select']); // document select
        Route::post('/approval/document/update', [ApprovalDocumentController::class, 'update']); // document update
        Route::post('/approval/document/delete', [ApprovalDocumentController::class, 'delete']); // document delete


        /*
        |--------------------------------------------------------------------------
        | 업무관리
        |--------------------------------------------------------------------------
        |
        | 업무관리 :: taskController
        |
        */

        // 일일업무관리
        Route::get('/task/daily_task', [TaskController::class, 'dailyTaskPage']);
        Route::get('/task/daily_task/list', [TaskController::class, 'list']);
        Route::post('/task/daily_task/insert', [TaskController::class, 'insert']); // task insert
        Route::get('/task/daily_task/select', [TaskController::class, 'select']); // task select
        Route::post('/task/daily_task/update', [TaskController::class, 'update']); // task update
        Route::post('/task/daily_task/delete', [TaskController::class, 'delete']); // task delete


        Route::get('/task/project', [TaskController::class, 'projectPage']);


        Route::get('/task/daily_task_manager', [TaskController::class, 'dailyTaskManagerPage']);
        Route::get('/task/daily_task_manager/list', [TaskController::class, 'managerList']);
        Route::get('/task/daily_task_manager/select', [TaskController::class, 'managerSelect']); // task select


        /*
        |--------------------------------------------------------------------------
        | 설정
        |--------------------------------------------------------------------------
        |
        | 개인정보 :: SettingProfileController
        | 사원정보 :: EmployeeController
        | 부서정보 :: DepartmentController
        | 직책정보 :: PositionController
        | 회사정보 :: CompanyInfoController
        |
        */

        // 개인정보
        Route::get('/setting/profile', [ProfileController::class, 'page']);
        Route::post('/setting/profile/update', [ProfileController::class, 'update']); // profile update
        Route::post('/setting/profile/file_delete', [ProfileController::class, 'fileDelete']); // profile file delete
        Route::post('/setting/profile/password_check', [ProfileController::class, 'passwordCheck']); // profile password check
        Route::post('/setting/profile/password_change', [ProfileController::class, 'passwordChange']); // profile password change
        Route::post('/setting/profile/profile_file_update', [ProfileController::class, 'profileFileUpdate']); // profile password change

        // 사원정보
        Route::get('/setting/employee', [EmployeeController::class, 'page']);
        Route::get('/setting/employee/list/{type?}', [EmployeeController::class, 'list']); // employee list
        Route::post('/setting/employee/insert', [EmployeeController::class, 'insert']); // employee insert
        Route::get('/setting/employee/select', [EmployeeController::class, 'select']); // employee select
        Route::post('/setting/employee/update', [EmployeeController::class, 'update']); // employee update
        Route::post('/setting/employee/delete', [EmployeeController::class, 'delete']); // employee delete

        // 부서정보
        Route::get('/setting/department', [DepartmentController::class, 'page']);
        Route::get('/setting/department/list', [DepartmentController::class, 'list']); // department list
        Route::post('/setting/department/insert', [DepartmentController::class, 'insert']); // department insert
        Route::get('/setting/department/select', [DepartmentController::class, 'select']); // department select
        Route::post('/setting/department/update', [DepartmentController::class, 'update']); // department update
        Route::post('/setting/department/delete', [DepartmentController::class, 'delete']); // department delete

        // 직책정보
        Route::get('/setting/position', [PositionController::class, 'page']);
        Route::get('/setting/position/list', [PositionController::class, 'list']); // position list
        Route::post('/setting/position/insert', [PositionController::class, 'insert']); // position insert
        Route::get('/setting/position/select', [PositionController::class, 'select']); // position select
        Route::post('/setting/position/update', [PositionController::class, 'update']); // position update
        Route::post('/setting/position/delete', [PositionController::class, 'delete']); // position delete

        // 회사정보
        Route::get('/setting/companyInfo', [CompanyInfoController::class, 'page']);
        Route::post('/setting/companyInfo/insert', [CompanyInfoController::class, 'insert']); // company info insert
        Route::post('/setting/companyInfo/update', [CompanyInfoController::class, 'update']); // company info update
        Route::post('/setting/companyInfo/fileDelete', [CompanyInfoController::class, 'fileDelete']); // company info file delete

        // 공지사항
        Route::get('/setting/notice', [BoardController::class, 'page']);
        Route::get('/setting/notice/list', [BoardController::class, 'list']); // notice list
        Route::post('/setting/notice/insert', [BoardController::class, 'insert']); // notice insert
        Route::get('/setting/notice/select', [BoardController::class, 'select']); // notice select
        Route::post('/setting/notice/update', [BoardController::class, 'update']); // notice update
        Route::post('/setting/notice/delete', [BoardController::class, 'delete']); // notice delete

        // sub 페이지
        /*
        |--------------------------------------------------------------------------
        | sub
        |--------------------------------------------------------------------------
        |
        | sub :: SubController
        |
        */

        // sub
        Route::get('/sub', [SubController::class, 'page']); // sub page
        Route::get('/sub/list', [SubController::class, 'list']); // sub list
        Route::post('/sub/insert', [SubController::class, 'insert']); // sub insert
        Route::get('/sub/select', [SubController::class, 'select']); // sub select
        Route::post('/sub/update', [SubController::class, 'update']); // sub update
        Route::post('/sub/delete', [SubController::class, 'delete']); // sub delete
    }
);
