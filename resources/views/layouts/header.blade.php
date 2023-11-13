<div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-default " href="#"><i class="fa fa-bars"></i> </a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <span class="m-r-sm text-muted welcome-message">안녕하세요. {{ Auth::user()->name }}님!</span>
            </li>

            {{--<li class="dropdown">--}}
            {{--    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">--}}
            {{--        <i class="fa fa-bell"></i>  <span class="label label-warning">8</span>--}}
            {{--    </a>--}}
            {{--    <ul class="dropdown-menu dropdown-alerts">--}}
            {{--        <li>--}}
            {{--            <a href="mailbox.html">--}}
            {{--                <div>--}}
            {{--                    <i class="fa fa-envelope fa-fw"></i> You have 16 messages--}}
            {{--                    <span class="float-right text-muted small">4 minutes ago</span>--}}
            {{--                </div>--}}
            {{--            </a>--}}
            {{--        </li>--}}
            {{--        <li class="dropdown-divider"></li>--}}
            {{--        <li>--}}
            {{--            <a href="profile.html">--}}
            {{--                <div>--}}
            {{--                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers--}}
            {{--                    <span class="float-right text-muted small">12 minutes ago</span>--}}
            {{--                </div>--}}
            {{--            </a>--}}
            {{--        </li>--}}
            {{--        <li class="dropdown-divider"></li>--}}
            {{--        <li>--}}
            {{--            <a href="grid_options.html">--}}
            {{--                <div>--}}
            {{--                    <i class="fa fa-upload fa-fw"></i> Server Rebooted--}}
            {{--                    <span class="float-right text-muted small">4 minutes ago</span>--}}
            {{--                </div>--}}
            {{--            </a>--}}
            {{--        </li>--}}
            {{--        <li class="dropdown-divider"></li>--}}
            {{--        <li>--}}
            {{--            <div class="text-center link-block">--}}
            {{--                <a href="notifications.html">--}}
            {{--                    <strong>See All Alerts</strong>--}}
            {{--                    <i class="fa fa-angle-right"></i>--}}
            {{--                </a>--}}
            {{--            </div>--}}
            {{--        </li>--}}
            {{--    </ul>--}}
            {{--</li>--}}


            <li>
                <a href="/logout">
                    <i class="fa fa-sign-out"></i> 로그아웃
                </a>
            </li>
        </ul>

    </nav>
</div>
