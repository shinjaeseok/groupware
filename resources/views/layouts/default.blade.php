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

    <!-- Datatables -->
    <link href="{{ asset('asset/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">

    <!-- DataPicker -->
    <link href="{{ asset('asset/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">

    <!-- ClockPicker -->
    <link href="{{ asset('asset/css/plugins/clockpicker/clockpicker.css') }}" rel="stylesheet">

    <!-- select2 -->
    <link href="{{ asset('asset/css/plugins/select2/select2.min.css') }}" rel="stylesheet">

    <!-- Toastr style -->
    <link href="{{ asset('asset/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">

    <!-- checkbox style -->
    <link href="{{ asset('asset/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">

    <!-- Custom -->
    <link rel="stylesheet" href="/css/default.css"/>

    @yield('head')
</head>
<body class="pace-done light-skin">

@error('title')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror


<div id="wrapper">
    <!-- side menu -->
    @include('layouts.aside')
    <div id="page-wrapper" class="gray-bg">
        <!-- top menu(header) -->
        @include('layouts.header')
        <div class="wrapper wrapper-content">
            <!-- content -->
            @yield('content')
        </div>
        <!-- modal -->
        @yield('modal')
        <!-- footer -->
        @include('layouts.footer')
    </div>
</div>

<!-- Mainly scripts -->
<script src="{{ asset('asset/js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('asset/js/popper.min.js') }}"></script>
<script src="{{ asset('asset/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('asset/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('asset/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('asset/js/inspinia.js') }}"></script>
<script src="{{ asset('asset/js/plugins/pace/pace.min.js') }}"></script>

<!-- Datatables -->
<script src="{{ asset('asset/js/plugins/dataTables/datatables.min.js') }}"></script>

<!-- DataPicker -->
<script src="{{ asset('asset/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>

<!-- ClockPicker -->
<script src="{{ asset('asset/js/plugins/clockpicker/clockpicker.js') }}"></script>

<!-- toastr -->
<script src="{{ asset('asset/js/plugins/toastr/toastr.min.js') }}"></script>

<!-- select2 -->
<script src="{{ asset('asset/js/plugins/select2/select2.full.min.js') }}"></script>

<!-- icheck -->
<script src="{{ asset('asset/js/plugins/iCheck/icheck.min.js') }}"></script>

<!-- SlimScroll -->
<script src="{{ asset('asset/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('asset/js/plugins/jqueryMask/jquery.mask.min.js') }}"></script>
<!-- Custom -->
<script src="/js/default.js"></script>

<!-- 세션 toast 메세지 -->
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

    function approvalCheck() {
        $.ajax({
            type: "GET",
            url: "/approvalCheck",
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function(result) {
            if (result.status) {
                if (result.data > 0) {
                    $('.approval_count').addClass("label label-warning ml-2").text('대기 ' + result.data + '건');
                }
            } else {

            }
        });
    }

    approvalCheck();
</script>
@yield('script')

</body>
</html>
