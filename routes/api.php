<?php

use App\Http\Controllers\PersoneController;
use Illuminate\Http\Request;
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

Route::get('persone', [PersoneController::class, 'index']);
Route::post('persone', [PersoneController::class, 'create']);
Route::get('persone/{persone}', [PersoneController::class, 'show']);
Route::put('persone/{persone}', [PersoneController::class, 'update']);
Route::delete('persone/{persone}', [PersoneController::class, 'delete']);
