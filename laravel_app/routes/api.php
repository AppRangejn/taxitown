<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\UserController;

// --- Drivers CRUD ---
Route::get('/drivers', [DriverController::class, 'index']);
Route::get('/drivers/{id}', [DriverController::class, 'show']);
Route::post('/drivers', [DriverController::class, 'store']);          // додати нового водія
Route::put('/drivers/{id}', [DriverController::class, 'update']);    // оновлення водія
Route::delete('/drivers/{id}', [DriverController::class, 'destroy']); // видалення

// --- Orders CRUD (адмінські) ---
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
});

// --- Users CRUD для SPA (можна теж через sanctum)
Route::prefix('users')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::post('/{user}', [UserController::class, 'update']);
    Route::post('/{user}/delete', [UserController::class, 'destroy']);
});
