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
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth']], function() {
// USER
    Route::group(['middleware' => ['can:user']], function () {
        Route::prefix('user')->group(function () {
            Route::post('/', [UserController::class, 'create'])->name('user-create');
            Route::get('/', [UserController::class, 'readAll'])->name('user-all');
            Route::get('/{user}', [UserController::class, 'readOne'])->name('user-one');
            Route::patch('/{user}', [UserController::class, 'update'])->name('user-update');
            Route::delete('/{user}', [UserController::class, 'delete'])->name('user-delete');
        });
    });
//ABSENCE
    Route::group(['middleware' => ['can:absence']], function () {
        Route::prefix('absence')->group(function () {
            Route::post('/', [AbsenceController::class, 'create'])->name('absence-create');
            Route::get('/', [AbsenceController::class, 'readAll'])->name('absence-all');
            Route::get('/{absence}', [AbsenceController::class, 'readOne'])->name('absence-one');
            Route::patch('/{absence}', [AbsenceController::class, 'update'])->name('absence-update');
            Route::delete('/{absence}', [AbsenceController::class, 'delete'])->name('absence-delete');
        });
    });

//COMPANY
    Route::group(['middleware' => ['can:company']], function () {
        Route::prefix('company')->group(function () {
            Route::post('/', [CompanyController::class, 'create'])->name('company-create');
            Route::get('/', [CompanyController::class, 'readAll'])->name('company-all');
            Route::get('/{company}', [CompanyController::class, 'readOne'])->name('company-one');
            Route::patch('/{company}', [CompanyController::class, 'update'])->name('company-update');
            Route::delete('/{company}', [CompanyController::class, 'delete'])->name('company-delete');
        });
    });

//CURRENCY
    Route::group(['middleware' => ['can:currency']], function () {
        Route::prefix('currency')->group(function () {
            Route::post('/', [CurrencyController::class, 'create'])->name('currency-create');
            Route::get('/', [CurrencyController::class, 'readAll'])->name('currency-all');
            Route::get('/{currency}', [CurrencyController::class, 'readOne'])->name('currency-one');
            Route::patch('/{currency}', [CurrencyController::class, 'update'])->name('currency-update');
            Route::delete('/{currency}', [CurrencyController::class, 'delete'])->name('currency-delete');
        });
    });

//CURRENCY_RECORD
    Route::group(['middleware' => ['can:currency_record']], function () {
        Route::prefix('currency_record')->group(function () {
            Route::post('/', [CurrencyRecordController::class, 'create'])->name('currency_record-create');
            Route::get('/', [CurrencyRecordController::class, 'readAll'])->name('currency_record-all');
            Route::get('/{currency_record}', [CurrencyRecordController::class, 'readOne'])->name('currency_record-one');
            Route::patch('/{currency_record}', [CurrencyRecordController::class, 'update'])->name('currency_record-update');
            Route::delete('/{currency_record}', [CurrencyRecordController::class, 'delete'])->name('currency_record-delete');
        });
    });

//NOTE
    Route::group(['middleware' => ['can:note']], function () {
        Route::prefix('note')->group(function () {
            Route::post('/', [NoteController::class, 'create'])->name('note-create');
            Route::get('/', [NoteController::class, 'readAll'])->name('note-all');
            Route::get('/{note}', [NoteController::class, 'readOne'])->name('note-one');
            Route::patch('/{note}', [NoteController::class, 'update'])->name('note-update');
            Route::delete('/{note}', [NoteController::class, 'delete'])->name('note-delete');
        });
    });

//SALARY
    Route::group(['middleware' => ['can:salary']], function () {
        Route::prefix('salary')->group(function () {
            Route::post('/', [SalaryController::class, 'create'])->name('salary-create');
            Route::get('/', [SalaryController::class, 'readAll'])->name('salary-all');
            Route::get('/{salary}', [SalaryController::class, 'readOne'])->name('salary-one');
            Route::patch('/{salary}', [SalaryController::class, 'update'])->name('salary-update');
            Route::delete('/{salary}', [SalaryController::class, 'delete'])->name('salary-delete');
        });
    });

//SKILL
    Route::group(['middleware' => ['can:skill']], function () {
        Route::prefix('skill')->group(function () {
            Route::post('/', [SkillController::class, 'create'])->name('skill-create');
            Route::get('/', [SkillController::class, 'readAll'])->name('skill-all');
            Route::get('/{skill}', [SkillController::class, 'readOne'])->name('skill-one');
            Route::patch('/{skill}', [SkillController::class, 'update'])->name('skill-update');
            Route::delete('/{skill}', [SkillController::class, 'delete'])->name('skill-delete');
        });
    });
});
