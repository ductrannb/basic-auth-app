<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\WardController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::get('provinces', [ProvinceController::class, 'getList']);
Route::get('districts', [DistrictController::class, 'getList']);
Route::get('wards', [WardController::class, 'getList']);

Route::group(['middleware' => 'api'], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::get('info', function () {
    return response()->json([
        'name' => 'Trần Xuân Đức',
        'birthday' => '2002-12-24',
        'address' => 'Ninh Bình',
        'nickname' => 'Đức Đẹp Trai',
        'relationship' => [
            'status' => 'Married',
            'partner' => 'Bé Bao cute'
        ],
        'ingame' => 'Fizz Not Feed#FNF',
    ]);
});