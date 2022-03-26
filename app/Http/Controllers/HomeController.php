<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Commute;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function page(Request $request)
    {
        //todo:: commute DB 작업(2021-11-10)
        //$commute_data = Commute::where('fk_user_id', Auth::user()->id)->where('work_date', date('Y-m-d'))->where('on_work', '!=', '')->first();

        $commute_data = true;
        return view('main', ['commute_data'=>$commute_data]);
    }

    public function homeOnCommute(Request $request)
    {
var_dump(1);
exit;

        return $data;
    }
}
