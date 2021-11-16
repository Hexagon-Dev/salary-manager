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

Route::group(['prefix' => 'auth'], function () {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

});

Route::middleware([EnsureTokenIsValid::class])->group(function () {
    Route::group(['middleware' => ['can:users']], function () {
        Route::prefix('user')->group(function () {
            Route::get('', [UserController::class, 'index']);
            Route::post('', [UserController::class, 'create']);
            Route::get('/{user}', [UserController::class, 'show']);
            Route::put('/{user}', [UserController::class, 'update']);
            Route::delete('/{user}', [UserController::class, 'delete']);
        });
    });

    Route::prefix('absence')->group(function () {
        Route::get('', [AbsenceController::class, 'index']);
        Route::post('', [AbsenceController::class, 'create']);
        Route::get('/{absence}', [AbsenceController::class, 'show']);
        Route::put('/{absence}', [AbsenceController::class, 'update']);
        Route::delete('/{absence}', [AbsenceController::class, 'delete']);
    });
});
