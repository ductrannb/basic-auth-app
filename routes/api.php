<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

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
})