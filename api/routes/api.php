<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Api\{
    DashboardController,
    PaymentController,
    LocationController,
    UserController,
    ReservationController
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



Route::group(['prefix' => 'auth'], function () {
    Route::post('/login',  [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/user', [AuthController::class, 'getUser'])->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')
    ->group(function () {
        Route::get('/payments', [PaymentController::class, 'index']);

        Route::post('/payments', [PaymentController::class, 'store']);

        Route::get('/locations', [LocationController::class, 'index']);

        Route::get('/networks', [UserController::class, 'getNetworks']);

        Route::get('/users/search', [UserController::class, 'searchBuyer']);

        Route::get('/documents', [UserController::class, 'getDocuments']);
        
        Route::get('/reservations', [ReservationController::class, 'index']);

        Route::get('/reservations/{buyer:slug}', [ReservationController::class, 'show']);

        Route::post('/reservations', [ReservationController::class, 'store']);

        // Route::get('/sales-managers', [UserController::class, 'getSalesManagers']);
    }
);

