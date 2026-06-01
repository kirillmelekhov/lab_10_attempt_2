@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
    <div class="row row--nogutter top-line">
        <div class="line"></div>
    </div>
    <div class="main">
        <div class="row">
            <div class="row--small">
                <form action="{{ route('register.store') }}" method="POST">
                    @csrf
                    <h2>Форма регистрации</h2>
                    <div class="form-group">
                        <label for="name">ФИО</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" minlength="5" maxlength="255" required>
                        @error('name')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
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
                    <div class="form-group">
                        <label for="password_confirmation">Подтверждение пароля</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" minlength="6" maxlength="64" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Номер телефона</label>
                        <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" minlength="10" maxlength="20" required>
                        @error('phone')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button class="btn" type="submit">Зарегистрироваться</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
