<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use Illuminate\Http\Request;

// Маршрут для отримання даних залогіненого користувача
Route::middleware('auth:web')->get('/user', function (Request $request) {
    return $request->user();
});

// "Всеїдний" маршрут для SPA. Має бути ОСТАННІМ.
Route::get('/{any}', [PageController::class, 'home'])->where('any', '.*');

// Бекенд-маршрути для автентифікації
require __DIR__.'/auth.php';
