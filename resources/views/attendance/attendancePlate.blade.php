@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="col-xl-12">
            <div id="ibox_1" class="ibox">
                <div class="ibox-title">
                    <h3>근태현황판</h3>
                </div>

                <div id="content" class="row">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('attendance.attendancePlate_js')
@endsection
