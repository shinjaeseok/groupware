
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">

            <!-- 프로필 메뉴 -->
            <li class="nav-header mt-0">
                <div class="dropdown profile-element">
                    <div class="row" style="padding-left: 20px;">
                        <div style="padding-top:16px;">
                            <img alt="image" class="img-md" style="border-radius: 50%!important;" src="{{ session()->get('profile_img') }}">
                        </div>

                        <a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false" style="padding-left: 16px;">
                            <span class="block m-t-xs">{{ Auth::user()->name }}</span>
                            <span class="text-muted text-xs block">{{ session()->get('position_name') }}<b class="caret"></b></span>
                        </a>

                        <ul class="dropdown-menu animated fadeInRight m-t-xs" x-placement="bottom-start" style="position: absolute; top: 92px; left: 0px; will-change: top, left;">
                            <li><a class="dropdown-item" href="/setting/profile">개인정보</a></li>
                            <li class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/logout">로그아웃</a></li>
                        </ul>
                    </div>
                </div>
                <div class="logo-element">
                    gw
                </div>
            </li>

            <!-- 일반 메뉴 -->
            <li class="{{ (request()->is('/')) ? 'active' : '' }} nav-border-bottom">
                <a href="/">
                    <i class="fa fa-th-large"></i>
                    <span class="nav-label" data-i18n="nav.home">대시보드</span>
                </a>
            </li>

            {{--<li class="nav-header">업무</li>--}}

            <li class="{{ (request()->is('attendance*')) ? 'active' : '' }} nav-border-bottom">
                <a href="#">
                    <i class="fa fa-clock-o"></i>
                    <span class="nav-label">근태</span><span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse" >
                    <li class="{{ (request()->is('attendance')) ? 'active' : '' }}"><a href="/attendance">근태현황</a></li>
                    @if (Auth::user()->manager == 'Y')
                        <li class="{{ (request()->is('attendance/page/manage')) ? 'active' : '' }}"><a href="/attendance/page/manage">근태관리[관리자]</a></li>
                        <li class="{{ (request()->is('attendance/page/day_list')) ? 'active' : '' }}"><a href="/attendance/page/day_list">일별 근태현황[관리자]</a></li>
                        <li class="{{ (request()->is('attendance/page/list')) ? 'active' : '' }}"><a href="/attendance/page/list">전체 근태현황[관리자]</a></li>
                        <li class="{{ (request()->is('attendance/page/plate')) ? 'active' : '' }}"><a href="/attendance/page/plate">근태현황판[관리자]</a></li>
                    @endif
                </ul>
            </li>

            <li class="{{ (request()->is('calendar*')) ? 'active' : '' }} nav-border-bottom">
                <a href="#">
                    <i class="fa fa-calendar"></i>
                    <span class="nav-label" data-i18n="nav.home">일정</span><span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse" >
                    <li class="{{ (request()->is('calendar/calendar')) ? 'active' : '' }}"><a href="/calendar/calendar">일정</a></li>
                </ul>
            </li>
            <li class="{{ (request()->is('task*')) ? 'active' : '' }} nav-border-bottom">
                <a href="#">
                    <i class="fa fa-tasks"></i>
                    <span class="nav-label" data-i18n="nav.home">업무관리</span><span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse" >
                    <li class="{{ (request()->is('task/daily_task')) ? 'active' : '' }}"><a href="/task/daily_task">업무일지</a></li>
                    {{--<li class="{{ (request()->is('task/project')) ? 'active' : '' }}"><a href="/task/project">프로젝트[작업중]</a></li>--}}
                    @if (Auth::user()->manager == 'Y')
                    <li class="{{ (request()->is('task/daily_task_manager')) ? 'active' : '' }}"><a href="/task/daily_task_manager">업무일지현황[관리자]</a></li>
                    @endif
                </ul>
            </li>

            <li class="{{ (request()->is('approval*')) ? 'active' : '' }} nav-border-bottom">
                <a href="#">
                    <i class="fa fa-pencil"></i>
                    <span class="nav-label">전자결재</span><span class="fa arrow"></span><span class="approval_count"></span>
                </a>
                <ul class="nav nav-second-level collapse" >
                    <li class="{{ (request()->is('approval/write')) || (request()->is('approval/write_*')) ? 'active' : '' }}"><a href="/approval/write" class="">기안작성</a></li>
                    <li class="{{ (request()->is('approval/writeList')) ? 'active' : '' }}"><a href="/approval/writeList">기안함</a></li>
                    <li class="{{ (request()->is('approval/tempList')) ? 'active' : '' }}"><a href="/approval/tempList">임시저장함</a></li>
                    <li class="{{ (request()->is('approval/approvalList')) ? 'active' : '' }}"><a href="/approval/approvalList">결재함<span class="approval_count"></span></a> </li>
                    <li class="{{ (request()->is('approval/document')) ? 'active' : '' }}"><a href="/approval/document">문서대장</a></li>
                </ul>
            </li>

            {{--<li class="nav-header">환경설정</li>--}}

            <li class="{{ (request()->is('setting*')) ? 'active' : '' }} nav-border-bottom">
                <a href="#">
                    <i class="fa fa-cog"></i>
                    <span class="nav-label">설정</span><span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse" >
                    <li class="{{ (request()->is('setting/profile')) ? 'active' : '' }}"><a href="/setting/profile">개인정보</a></li>
                    <li class="{{ (request()->is('setting/notice')) ? 'active' : '' }}"><a href="/setting/notice">공지사항</a></li>
                    @if (Auth::user()->manager == 'Y')
                    <li class="{{ (request()->is('setting/employee')) ? 'active' : '' }}"><a href="/setting/employee">사원정보</a></li>
                    <li class="{{ (request()->is('setting/department')) ? 'active' : '' }}"><a href="/setting/department">부서정보</a></li>
                    <li class="{{ (request()->is('setting/position')) ? 'active' : '' }}"><a href="/setting/position">직책정보</a></li>
                    <li class="{{ (request()->is('setting/companyInfo')) ? 'active' : '' }}"><a href="/setting/companyInfo">회사정보</a></li>
                    @endif
                </ul>
            </li>
        </ul>
    </div>
</nav>
