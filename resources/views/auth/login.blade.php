@extends('layouts.app')

@section('title', 'Вход')

@section('content')
    <div class="row row--nogutter top-line">
        <div class="line"></div>
    </div>
    <div class="main">
        <div class="row">
            <div class="row--small">
                <form action="{{ route('login.store') }}" method="POST">
                    @csrf
                    <h2>Форма авторизации</h2>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" maxlength="255" required>
                        @error('email')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input id="password" type="password" name="password" minlength="6" maxlength="64" required>
                        @error('password')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group form-inline">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember" @checked(old('remember'))>
                            Запомнить меня
                        </label>
                    </div>
                    <div class="form-group">
                        <button class="btn" type="submit">Войти</button>
                    </div>
                    <p class="form-note">
                        Нет аккаунта?
                        <a href="{{ route('register') }}">Перейти к регистрации</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
@endsection
