<?php

use App\Http\Controllers\Api\Admin\HotelController;
use App\Http\Controllers\Api\Admin\TransactionController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\User\BookHotelController;
use App\Http\Controllers\Api\User\HotelController as UserHotelController;
use App\Http\Controllers\Api\User\MyOrderController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::prefix('admin')->group(function () {
        Route::resource('hotel', HotelController::class);
        Route::resource('transaction', TransactionController::class);
    });

    Route::get('my-order', [MyOrderController::class, 'index']);
    Route::post('book-hotel/{hotel:slug}', [BookHotelController::class, 'store']);
    Route::post('payment', [MyOrderController::class, 'processPaymentHotel']);

    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/hotels', [UserHotelController::class, 'index']);
Route::get('/hotel/{hotel:slug}', [UserHotelController::class, 'show']);
