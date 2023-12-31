<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['auth:sanctum']], function () {
   Route::get('/', [TransactionController::class, 'index']);
   Route::get('/deposit', [TransactionController::class, 'deposits']);
   Route::get('/withdrawal', [TransactionController::class, 'widrawals']);
});


Route::post('/login', [AuthController::class, 'login']);
Route::post('/user', [UserController::class, 'store']);

Route::post('/deposit', [TransactionController::class, 'addDeposit']);
Route::post('/withdrawal', [TransactionController::class, 'addWidrawal']);
