<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:255', 'regex:/^[\p{L}\s\-]+$/u'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'max:64', 'confirmed'],
            'phone' => ['required', 'regex:/^\+?[0-9\s\-\(\)]{10,20}$/'],
        ], [
            'name.required' => 'Введите ФИО.',
            'name.min' => 'ФИО должно содержать не менее 5 символов.',
            'name.regex' => 'ФИО может содержать только буквы, пробелы и дефис.',
            'email.required' => 'Введите email.',
            'email.email' => 'Введите корректный email.',
            'email.unique' => 'Пользователь с таким email уже существует.',
            'password.required' => 'Введите пароль.',
            'password.min' => 'Пароль должен содержать минимум 6 символов.',
            'password.max' => 'Пароль не должен превышать 64 символа.',
            'password.confirmed' => 'Подтверждение пароля не совпадает.',
            'phone.required' => 'Введите номер телефона.',
            'phone.regex' => 'Введите корректный номер телефона.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'phone' => $validated['phone'],
            'role' => User::ROLE_VISITOR,
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('home')
            ->with('status', 'Регистрация прошла успешно.');
    }
}
