<!DOCTYPE html>
<html lang="ko" class="root-text-sm">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="icon" href="/favicon.ico">
    <!-- CSS Files -->
    <link href="{{ asset('asset/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
    <!-- Toastr style -->
    <link href="{{ asset('asset/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">

    <!-- Custom -->
    <link rel="stylesheet" href="/css/default.css"/>
</head>

<body class="pace-done light-skin">
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div class="mb-4" style="margin-top:150px;">
                <h3 class="font-bold" style="color:#000000; font-size: 24px;">그룹웨어</h3>
                {{--<h3 class="font-bold" style="color:#000000; font-size: 24px;">제이픽스에 오신것을<br> 환영합니다.</h3>--}}
            </div>
            {{--<h3>로그인</h3>--}}
            <form action="login" method="post" id="login_form" onsubmit="return check()">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" id="employee_code" name="employee_code" placeholder="사원코드" autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="비밀번호">
                </div>
                <div class="text-left mb-3">
                    <div class="form-check abc-checkbox abc-checkbox-primary">
                        <input class="abc-checkbox-primary" type="checkbox" id="remember_id" name="remember_id">
                        <label for="remember_id" data-toggle="tooltip" data-placement="top" title="" data-title="아이디는 저장한 날로부터 7일간 유효합니다." >아이디 기억하기</label>
                    </div>
                </div>
                    <button type="submit" class="btn btn-primary block full-width m-b" id="btn_login">로그인</button>
            </form>
            <p class="m-t"> <small>joohong.dev &copy; 2021</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('asset/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('asset/js/popper.min.js') }}"></script>
    <script src="{{ asset('asset/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('asset/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('asset/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('asset/js/inspinia.js') }}"></script>
    <script src="{{ asset('asset/js/plugins/pace/pace.min.js') }}"></script>
    <script src="{{ asset('asset/js/plugins/iCheck/icheck.min.js') }}"></script>
        <!-- toastr -->
    <script src="{{ asset('asset/js/plugins/toastr/toastr.min.js') }}"></script>

</body>
</html>

<script>
    @if (Session::has('message'))
    toastr.success('{{ Session::get('message') }}');
    @endif
    @if (count($errors) > 0)
    @foreach ($errors->all() as $error)
    toastr.error('{{ $error }}');
    @endforeach
    @endif
</script>

<script>
    function check(){
        if (!$("#employee_code").val()) {
            toastr.error('아이디를 입력하세요.', '오류');
            return false;
        };

        if (!$("#password").val()) {
            toastr.error('비밀번호를 입력하세요.', '오류');
            return false;
        };
    }

    $(document).ready(function () {
        $('#employee_code').focus();
        var userCode = getCookie("userCode");
        $("input[name='employee_code']").val(userCode);

        $("#btn_login").attr('disabled', true);
        if ($("input[name='employee_code']").val() != "") { // 그 전에 ID를 저장해서 처음 페이지 로딩 시, 입력 칸에 저장된 ID가 표시된 상태라면,
            $("#remember_id").attr("checked", true); // ID 저장하기를 체크 상태로 두기.
            $("#btn_login").attr('disabled', false);
        }

        $("#remember_id").change(function () { // 체크박스에 변화가 있다면,
            if ($("#remember_id").is(":checked")) { // ID 저장하기 체크했을 때,
                var userCode = $("input[name='employee_code']").val();
                setCookie("userCode", userCode, 7); // 7일 동안 쿠키 보관
            } else { // ID 저장하기 체크 해제 시,
                deleteCookie("userCode");
            }
        });

        // ID 저장하기를 체크한 상태에서 ID를 입력하는 경우, 이럴 때도 쿠키 저장.
        $("input[name='employee_code']").keyup(function () { // ID 입력 칸에 ID를 입력할 때,
            var userCode = $("input[name='employee_code']").val();
            if (userCode) {
                $("#btn_login").attr('disabled', false);
            } else {
                $("#btn_login").attr('disabled', true);
            }
            if ($("#remember_id").is(":checked")) { // ID 저장하기를 체크한 상태라면,
                setCookie("userCode", userCode, 7); // 7일 동안 쿠키 보관
            }
        });

        function setCookie(cookieName, value, exdays) {
            var exdate = new Date();
            exdate.setDate(exdate.getDate() + exdays);
            var cookieValue = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toGMTString());
            document.cookie = cookieName + "=" + cookieValue;
        }

        function deleteCookie(cookieName) {
            var expireDate = new Date();
            expireDate.setDate(expireDate.getDate() - 1);
            document.cookie = cookieName + "= " + "; expires=" + expireDate.toGMTString();
        }

        function getCookie(cookieName) {
            cookieName = cookieName + '=';
            var cookieData = document.cookie;
            var start = cookieData.indexOf(cookieName);
            var cookieValue = '';
            if (start != -1) {
                start += cookieName.length;
                var end = cookieData.indexOf(';', start);
                if (end == -1) end = cookieData.length;
                cookieValue = cookieData.substring(start, end);
            }
            return unescape(cookieValue);
        }
    });
</script>
