<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Всі маршрути для вашого SPA, включаючи API, мають бути тут,
| щоб вони проходили через middleware "web" з підтримкою сесій.
|
*/

// Маршрути для сторінки профілю
Route::middleware('auth')->group(function () {
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Бекенд-маршрути для автентифікації (login, register, etc)
require __DIR__ . '/auth.php';

// --- ЄДИНИЙ БЛОК API-МАРШРУТІВ ДЛЯ SPA ---
Route::prefix('api')->middleware('auth:sanctum')->group(function () {

    // Отримання поточного користувача
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // CRUD операції з користувачами
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::post('/users/{user}', [UserController::class, 'update']);      // Оновлення через POST
    Route::post('/users/{user}/delete', [UserController::class, 'destroy']); // Видалення через POST
});


// --- SPA Fallback Route (ЗАВЖДИ ОСТАННІЙ) ---
// Цей маршрут перехоплює будь-які GET-запити, що не співпали,
// і повертає головний Blade-шаблон, який завантажує ваш Vue-додаток.
Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
