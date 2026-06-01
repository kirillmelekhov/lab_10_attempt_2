<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'max:64'],
        ], [
            'email.required' => 'Введите email.',
            'email.email' => 'Введите корректный email.',
            'email.max' => 'Email не должен превышать 255 символов.',
            'password.required' => 'Введите пароль.',
            'password.min' => 'Пароль должен содержать минимум 6 символов.',
            'password.max' => 'Пароль не должен превышать 64 символа.',
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Неверный email или пароль.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        if (Auth::user()?->role === User::ROLE_LEADER) {
            return redirect()->route('leader.cabinet')
                ->with('status', 'Вход выполнен. Открыт личный кабинет ведущего.');
        }

        return redirect()->route('home')
            ->with('status', 'Вход выполнен.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('status', 'Вы вышли из аккаунта.');
    }
}
