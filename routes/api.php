<?php

use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureTokenIsValid;
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

Route::prefix('auth')->group(function () {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

});

Route::middleware([EnsureTokenIsValid::class])->group(function () {
    Route::prefix('user')->group(function () {
        Route::post('', [UserController::class, 'create']);
        Route::get('', [UserController::class, 'readAll']);
        Route::get('/{user}', [UserController::class, 'readOne']);
        Route::patch('/{user}', [UserController::class, 'update']);
        Route::delete('/{user}', [UserController::class, 'delete']);
    });
    Route::prefix('absence')->group(function () {
        Route::post('', [AbsenceController::class, 'create']);
        Route::get('', [AbsenceController::class, 'readAll']);
        Route::get('/{absence}', [AbsenceController::class, 'readOne']);
        Route::patch('/{absence}', [AbsenceController::class, 'update']);
        Route::delete('/{absence}', [AbsenceController::class, 'delete']);
    });
});
