<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('users')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
        Route::post('/logout', 'logout');
        Route::post('/forgot-password', 'forgotPassword');
        Route::post('/reset-password-token', 'resetPasswordToken');

        Route::middleware(['auth:sanctum'])->group(function () {
            Route::get('', 'getUser');
            Route::get('/orders', 'getUserOrders');
            Route::put('/edit', 'updateUser');
            Route::delete('', 'destroy');
        });
    });
});

Route::controller(OrderController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::resource('orders', OrderController::class);
        Route::post('orders/{id}/add','addProduct');
        Route::post('orders/{id}/pay','makePayment');
    });
});

