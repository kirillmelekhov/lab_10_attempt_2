<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ОчУмелые ручки')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
</head>
<body class="@yield('body_class')">
    <div class="header">
        <div class="row grid middle between">
            <div class="logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Логотип">
                </a>
            </div>
            <div class="title">
                Клуб любителей творчества «ОчУмелые ручки»
            </div>
            <div class="auth auth--template">
                @auth
                    @if(auth()->user()->isLeader())
                        <a href="{{ route('leader.cabinet') }}">Кабинет</a>
                    @else
                        <a href="{{ route('home') }}">Мои записи</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="inline-form">
                        @csrf
                        <button type="submit" class="link-button auth-secondary">Выход</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Вход / Регистрация</a>
                @endauth
            </div>
        </div>
    </div>

    @if(session('status'))
        <div class="row row--nogutter">
            <div class="flash-message">{{ session('status') }}</div>
        </div>
    @endif

    @yield('content')

    <div class="row row--nogutter">
        <div class="line"></div>
    </div>
    <div class="footer">
        <div class="row">
            <div class="row--small grid between footer-grid">
                <div class="address">Наш адрес: ВДНХ, 120в</div>
                <div class="tel">Тел: +7 (912) 345-67-65</div>
                <div class="copy">(с) Copyright, 2026</div>
            </div>
        </div>
    </div>
</body>
</html>
