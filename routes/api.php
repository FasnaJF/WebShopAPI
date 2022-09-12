<?php

use App\Http\Controllers\OrderController;
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
Route::prefix('users')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login')->name('login');
        Route::post('/logout', 'logout');
        Route::post('/forgot-password', 'forgotPassword');
        Route::post('/reset-password', 'resetPassword');
    });
});

Route::controller(OrderController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::resource('orders', OrderController::class);
        Route::post('orders/{id}/add', 'addProduct');
        Route::post('orders/{id}/pay', 'makePayment');
    });
});
