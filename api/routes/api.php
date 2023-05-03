<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Api\{
    DashboardController,
    PaymentController,
    InvoiceController,
    LocationController,
    CalendarController,
    UserController,
    ReservationController,
    ReportController,
    PropertyController
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
    Route::get('/mail/send-grid', [AuthController::class, 'sendMail'])->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')
    ->group(function () {
        Route::get('/dashboard/statuses', [DashboardController::class, 'getStatuses']);

        Route::get('/branches', [AuthController::class, 'getBranches']);

        Route::get('/payments', [PaymentController::class, 'index']);

        Route::post('/payments', [PaymentController::class, 'store']);

        Route::post('/payments/delete', [PaymentController::class, 'destroy']);

        Route::get('/calendar/past-dues', [CalendarController::class, 'index']);

        Route::get('/invoices', [InvoiceController::class, 'index']);

        Route::get('/locations', [LocationController::class, 'index']);

        Route::post('/locations', [LocationController::class, 'store']);

        Route::get('/locations/{location}/properties', [LocationController::class, 'getLocationProperties']);

        
        
        Route::get('/reservations', [ReservationController::class, 'index']);

        Route::get('/reservations/locations', [ReservationController::class, 'locations']);

        Route::get('/reservations/{buyer:slug}', [ReservationController::class, 'show']);

        Route::get('/reservations/{buyer:slug}/document/download', [ReservationController::class, 'download']);
        
        Route::post('/reservations/delete', [ReservationController::class, 'destroy']);

        Route::post('/reservations/{buyer:slug}/property', [ReservationController::class, 'updateOrCreateProperty']);

        Route::post('/reservations/{buyer:slug}/document', [ReservationController::class, 'updateDocument']);

        Route::post('/reservations/{buyer:slug}/payment', [ReservationController::class, 'updatePayment']);

        Route::post('/reservations/{buyer:slug}/payment/delete', [ReservationController::class, 'deletePayment']);

        

        Route::post('/reservations', [ReservationController::class, 'store']);

        Route::get('/properties', [PropertyController::class, 'index']);
        
        Route::get('/properties/statuses', [PropertyController::class, 'getStatuses']);

        Route::post('/properties', [PropertyController::class, 'store']);

        // Route::get('/sales-managers', [UserController::class, 'getSalesManagers']);

        Route::prefix('reports')->group(function(){
            Route::get('/sales', [ReportController::class, 'getSales']);
            Route::get('/expenses', [ReportController::class, 'getExpenses']);
        });

        Route::prefix('users')->group(function(){
            Route::get('/', [UserController::class, 'index']);

            Route::get('/search', [UserController::class, 'searchBuyer']);

            Route::post('/delete', [UserController::class, 'destroy']);
        });

        Route::get('/networks', [UserController::class, 'getNetworks']);

        Route::get('/documents', [UserController::class, 'getDocuments']);
    }
);

