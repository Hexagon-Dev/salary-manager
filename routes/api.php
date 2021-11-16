<?php

use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureTokenIsValid;
use Illuminate\Support\Facades\Route;
use Tymon\JWTAuth\Facades\JWTAuth;

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

Route::post('/login', [UserController::class, 'login']);

Route::middleware([EnsureTokenIsValid::class])->group(function () {
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
});
