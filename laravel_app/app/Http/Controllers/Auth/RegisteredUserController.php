<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response; // <-- Змінюємо тип відповіді
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Метод create() нам більше не потрібен, оскільки сторінку реєстрації
     * тепер показує Vue Router. Його можна видалити або залишити - він не буде викликатись.
     */
    // public function create(): Response
    // {
    //     return Inertia::render('Auth/Register');
    // }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): Response // <-- Змінюємо тип відповіді
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Повертаємо відповідь "204 No Content", що означає успіх для API
        return response()->noContent(); // <-- Головна зміна
    }
}
