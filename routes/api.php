<?php

use App\Http\Controllers\Api\Admin\efoodController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\User\OrderController;
use App\Http\Controllers\Api\User\efoodController as UserefoodController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::prefix('admin')->group(function () {
         Route::resource('efood', efoodController::class);
         Route::resource('transaksi', TransaksiController::class);
    });

    Route::get('order', [OrderController::class, 'index']);
    Route::get('procces-payment', [OrderController::class, 'processPayment']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::get('efood', [UserefoodController::class, 'index']);
Route::get('efood/{id}', [UserefoodController::class, 'show']);
