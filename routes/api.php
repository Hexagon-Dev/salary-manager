<?php

use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('user')->group(function () {
    Route::get('', [UserController::class, 'index']);
    Route::post('', [UserController::class, 'create']);
    Route::get('/{user}', [UserController::class, 'show']);
    Route::put('/{user}', [UserController::class, 'update']);
    Route::delete('/{user}', [UserController::class, 'delete']);
});

Route::prefix('absence')->group(function () {
    Route::get('', [AbsenceController::class, 'index']);
    Route::post('', [AbsenceController::class, 'create']);
    Route::get('/{absence}', [AbsenceController::class, 'show']);
    Route::put('/{absence}', [AbsenceController::class, 'update']);
    Route::delete('/{absence}', [AbsenceController::class, 'delete']);
});
