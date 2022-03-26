<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

});

// open API
Route::get('/userList',[ApiController::class, 'userList']);
Route::get('/userInfo/{user_id?}',[ApiController::class, 'userInfo']);
Route::post('/userCreate',[ApiController::class, 'userCreate']);
Route::get('/attendance/{user_id?}',[ApiController::class, 'attendanceInfo']);
