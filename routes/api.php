<?php

use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CurrencyController;
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

// AUTH
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware([EnsureTokenIsValid::class])->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);
    });

});

// USER
Route::post('user', [UserController::class, 'create']);

Route::middleware([EnsureTokenIsValid::class])->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('', [UserController::class, 'readAll']);
        Route::get('/{user}', [UserController::class, 'readOne']);
        Route::patch('/{user}', [UserController::class, 'update']);
        Route::delete('/{user}', [UserController::class, 'delete']);
    });

    //ABSENCE
    Route::prefix('absence')->group(function () {
        Route::post('', [AbsenceController::class, 'create']);
        Route::get('', [AbsenceController::class, 'readAll']);
        Route::get('/{absence}', [AbsenceController::class, 'readOne']);
        Route::patch('/{absence}', [AbsenceController::class, 'update']);
        Route::delete('/{absence}', [AbsenceController::class, 'delete']);
    });

    //COMPANY
    Route::prefix('company')->group(function () {
        Route::post('', [CompanyController::class, 'create']);
        Route::get('', [CompanyController::class, 'readAll']);
        Route::get('/{company}', [CompanyController::class, 'readOne']);
        Route::patch('/{company}', [CompanyController::class, 'update']);
        Route::delete('/{company}', [CompanyController::class, 'delete']);
    });

    //CURRENCY
    Route::prefix('currency')->group(function () {
        Route::post('', [CurrencyController::class, 'create']);
        Route::get('', [CurrencyController::class, 'readAll']);
        Route::get('/{currency}', [CurrencyController::class, 'readOne']);
        Route::patch('/{currency}', [CurrencyController::class, 'update']);
        Route::delete('/{currency}', [CurrencyController::class, 'delete']);
    });
});
