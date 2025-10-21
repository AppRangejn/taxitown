<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Маршрути для сторінки профілю
Route::middleware('auth')->group(function () {
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Бекенд-маршрути для автентифікації (login, register, etc)
require __DIR__ . '/auth.php';

// ЄДИНИЙ БЛОК API-МАРШРУТІВ ДЛЯ SPA
Route::prefix('api')->middleware('auth:sanctum')->group(function () {

    Route::get('/user', fn (Request $request) => $request->user());

    // CRUD користувачів
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::post('/users/{user}', [UserController::class, 'update']);
    Route::post('/users/{user}/delete', [UserController::class, 'destroy']);

    // Замовлення
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::delete('/orders/{id}', [OrderController::class, 'destroy']);

    // для адміна
    Route::get('/admin/orders', [OrderController::class, 'indexAdmin']);
    Route::put('/admin/orders/{id}', [OrderController::class, 'update']);
    Route::delete('/admin/orders/{id}', [OrderController::class, 'destroy']);
});



// SPA Fallback Route (ЗАВЖДИ ОСТАННІЙ)
// Цей маршрут перехоплює будь-які GET-запити що не співпали
// і повертає головний Blade-шаблон який завантажує Vue-додаток
Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
