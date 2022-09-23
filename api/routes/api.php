<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Api\{
    DashboardController,
    PaymentController,
    LocationController,
    UserController
};

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

Route::post('/login',  [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')
    ->group(function () {
        Route::get('/user', [AuthController::class, 'me']);

        Route::get('/payments', [PaymentController::class, 'index']);

        Route::get('/locations', [LocationController::class, 'index']);

        Route::get('/networks', [UserController::class, 'getNetworks']);

        // Route::get('/sales-managers', [UserController::class, 'getSalesManagers']);
    }
);

