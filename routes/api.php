<?php

use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CurrencyRecordController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\SkillController;
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
        Route::post('/', [AbsenceController::class, 'create'])->name('absence-create');
        Route::get('/', [AbsenceController::class, 'readAll'])->name('absence-all');
        Route::get('/{absence}', [AbsenceController::class, 'readOne'])->name('absence-one');
        Route::patch('/{absence}', [AbsenceController::class, 'update'])->name('absence-update');
        Route::delete('/{absence}', [AbsenceController::class, 'delete'])->name('absence-delete');
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

    //CURRENCY_RECORD
    Route::prefix('currency_record')->group(function () {
        Route::post('', [CurrencyRecordController::class, 'create']);
        Route::get('', [CurrencyRecordController::class, 'readAll']);
        Route::get('/{currency_record}', [CurrencyRecordController::class, 'readOne']);
        Route::patch('/{currency_record}', [CurrencyRecordController::class, 'update']);
        Route::delete('/{currency_record}', [CurrencyRecordController::class, 'delete']);
    });

    //NOTE
    Route::prefix('note')->group(function () {
        Route::post('', [NoteController::class, 'create']);
        Route::get('', [NoteController::class, 'readAll']);
        Route::get('/{note}', [NoteController::class, 'readOne']);
        Route::patch('/{note}', [NoteController::class, 'update']);
        Route::delete('/{note}', [NoteController::class, 'delete']);
    });

    //SALARY
    Route::prefix('salary')->group(function () {
        Route::post('', [SalaryController::class, 'create']);
        Route::get('', [SalaryController::class, 'readAll']);
        Route::get('/{salary}', [SalaryController::class, 'readOne']);
        Route::patch('/{salary}', [SalaryController::class, 'update']);
        Route::delete('/{salary}', [SalaryController::class, 'delete']);
    });

    //SKILL
    Route::prefix('skill')->group(function () {
        Route::post('', [SkillController::class, 'create']);
        Route::get('', [SkillController::class, 'readAll']);
        Route::get('/{skill}', [SkillController::class, 'readOne']);
        Route::patch('/{skill}', [SkillController::class, 'update']);
        Route::delete('/{skill}', [SkillController::class, 'delete']);
    });
});
