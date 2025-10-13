<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Отримати список користувачів
    public function index(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $query = User::query();

        // --- Пошук ---
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%");
            });
        }

        // --- Сортування ---
        $sortField = $request->input('sortField', 'id'); // поле за замовчуванням id
        $sortOrder = $request->input('sortOrder', 'desc'); // порядок за замовчуванням desc
        if (in_array($sortField, ['id','name','email','role']) && in_array($sortOrder, ['asc','desc'])) {
            $query->orderBy($sortField, $sortOrder);
        }

        return response()->json($query->get());
    }


    // Додати нового користувача
    public function store(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'role'     => 'required|string|in:user,admin',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'role'     => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json($user, 201);
    }

    // Оновити дані користувача (використовуємо Route Model Binding)
    public function update(Request $request, User $user)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => ['required','string','email','max:255', Rule::unique('users')->ignore($user->id)],
            'role'  => 'required|string|in:user,admin',
            'password' => 'nullable|string|min:8', // Поле паролю не є обов'язковим при оновленні
        ]);

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ]);

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return response()->json($user);
    }

    // Видалити користувача (використовуємо Route Model Binding)
    public function destroy(Request $request, User $user)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // Забороняємо адміну видаляти самого себе
        if ($request->user()->id === $user->id) {
            return response()->json(['message' => 'Ви не можете видалити власний акаунт'], 403);
        }

        $user->delete();

        return response()->json(['message' => 'Користувача видалено'], 200);
    }
}
